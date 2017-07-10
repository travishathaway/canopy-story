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

        $treestory = $request->input('treestory');
        $tree_location = $request->input('tree_location');
        $tree_id = $request->input('tree_id'); 

        // Check required fields
        if(empty($tree_id) || empty($tree_location) || empty($treestory)){
          return abort(400, 'Required fields "tree_id", "tree_location" and 
            "treestory" not present');
        }


        // Create the post
        $post = new Post;
        $post->content = $treestory;
        $post->tree_id = $tree_id;
        $post->tree_location = str_replace(',', '', $tree_location);
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

    /**
     * Retrieves a list of posts for our list template
     */
    public function get(Request $request)
    {
        $search_user = User::where('first_name', 'like', "%$request->q%")
            ->orWhere('last_name', 'like', "%$request->q%")->pluck('id')->all();

        $query = Post::with('images')->with('user')->
            where(function($query) use ($request){
                if($request->q){
                    $query->orWhere('content', 'like', "%$request->q%")
                        ->orWhere('tree_location', 'like', "%$request->q%");
                }
            })->where('flagged', '=', false);

        if(count($search_user) > 0){
            $query = $query->orWhereIn('user_id', $search_user);
        }

        $posts = $query->paginate(20);
        $user = $request->user();

        if($user){
            $user = User::find($user->id);
        }

        return view('posts.list', [
            'posts' => $posts,
            'user' => $user,
            'q' => $request->q
        ]);
    }
}
