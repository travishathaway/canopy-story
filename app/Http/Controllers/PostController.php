<?php

namespace App\Http\Controllers;

use LanguageDetection\Language;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\PostImage;


/**
 * Request sub class to handle request for the post resource
 */
class PostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'treestory' => 'required|string',
            'tree_location' => 'required|string',
            'tree_id' => 'required|string'
        ];
    }
}


class PostController extends Controller
{
    /**
     * Provided text, the best fit language in $this->languages
     *
     * @param $test string
     *
     * @return string
     */
    public static function getLanguage($text)
    {
        $ld = new Language;
        # Returns an array with languages as keys and scores as values
        $result = $ld->detect($text)->close();

        # Filter out only the ones we care about
        $lang_scores = array_filter(array_keys($result), function($i){
            return in_array($i, config('app.available_locales'));
        });

        # Return the first one (the array was sorted in the first step)
        return array_shift($lang_scores);
    }

    /**
     * This is the endpoint for creating a new post
     */
    public function create(PostRequest $request)
    {
        $images = $request->get('image-filepath');

        $treestory = $request->input('treestory');
        $tree_location = $request->input('tree_location');
        $tree_id = $request->input('tree_id'); 

        // Create the post
        $post = new Post;
        $post->content = $treestory;
        $post->tree_id = $tree_id;
        $post->language = $this->getLanguage($treestory);
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

    /**
     * This is the endpoint for updating a post
     */
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

    /**
     * This is the endpoint for deleting a post
     */
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

        $post->deleted_at = new \DateTime();
        $post->save();
        return redirect('post');
    }

    /**
     * We use this method to get post from a request and supply we
     * template we should to render it
     *
     * @param $request Request
     * @param $template string
     */
    private function _get(Request $request, $template)
    {
        $search_user = User::where('first_name', 'ilike', "%$request->q%")
            ->orWhere('last_name', 'ilike', "%$request->q%")->pluck('id')->all();

        $query = Post::getPostList($request, $search_user, \App::getLocale());

        $posts = $query->paginate(20);
        $user = $request->user();

        if($user){
            $user = User::find($user->id);
        }

        return view($template, [
            'posts' => $posts,
            'user' => $user,
            'q' => $request->q
        ]);
    }

    /**
     * Retrieves a list of posts for our public list template
     */
    public function get(Request $request)
    {
        return $this->_get($request, 'posts.list');
    }

    /**
     * Retrieves a list of posts for our admin list template
     */
    public function adminGet(Request $request)
    {
        return $this->_get($request, 'posts.admin_list');
    }

}
