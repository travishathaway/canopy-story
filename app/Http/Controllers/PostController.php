<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\PostImage;

class PostController extends Controller
{
    /**
     *
     */
    public function create(Request $request)
    {
        $images = $request->get('image-filepath');
        $data = $request->data;
        $treestory = $request->input('treestory');

        // Check required fields
        if(empty($data) || empty($treestory)){
            return abort(400, 'Required fields "data" and "treestory" not present');
        }

        // Parse out tree information
        $this_tree = explode(', ', $data, 2)[0];
        $tree_id = explode(' ', $this_tree, 2)[0];
        $tree_location = explode(' ', $this_tree, 2)[1];

        // Create the post
        $post = new Post;
        $post->content = $request->input('treestory');
        $post->tree_id = $tree_id;
        $post->tree_location = $tree_location;
        $post->user_id = $request->user()->id;
        $post->flagged = false;
        $post->save();

        // Create the Post images 
        if(is_array($images)){
            foreach($images as $img){
                $post_image = new PostImage;
                $post_image->image_url = $img;
                $post_image->post_id = $post->id;
                $post_image->save();
            }
        }

        return redirect('post');
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $user = User::find($request->user()->id);

        if(!$post){
            return abort(404);
        }


        if(!$user->isAdmin() && $user->id != $post->user_id){
            return abort(
                403, "You are not authorized to perform this action"
            );
        }

        $post->flagged = $request->input('flagged');
        $post->save();

        return redirect('post');
    }

    public function delete(Request $request, $id)
    {
        $post = Post::find($id);
        $user = User::find($request->user()->id);

        if(!$post){
            return abort(404);
        }

        if(!$user->isAdmin() && $user->id != $post->user_id){
            return abort(403, "You are not authorized to perform this action");
        }

        $post->delete();
        return redirect('post');
    }

    public function get(Request $request)
    {
      $query = Post::with('images')/**->with(['user' => function($q) use ($request){
          if($request->q){
              $q->orWhere('last_name', 'like', $request->q)
                ->orWhere('first_name', 'like', $request->q);
          }
      }])*/->where(function($query) use ($request){
          if($request->q){
              $query->where('content', 'like', $request->q)
                  ->orWhere('tree_location', 'like', $request->q)
                  ->orWhere('posts.created_at', 'like', $request->q);
          }
      })->where('flagged', '=', false);
        $posts = $query->paginate(20);
        $user = $request->user();

        if($user){
            $user = User::find($user->id);
        }

        return view('posts.list', [
            'posts' => $posts,
            'user' => $user
        ]);
    }
}