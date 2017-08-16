<?php 

namespace App\Http\Controllers\API;

use Illuminate\Foundation\Http\FormRequest;

use App\User;
use App\Repository\Transformers\UserTransformer;

/**
 * Request sub class to handle request for the user resource
 */
class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user' => 'required|array',
            'user.email' => 'required|email',
            'user.first_name' => 'required|string',
            'user.last_name' => 'required|string'
        ];
    }
}

class UserAPIController extends APIController
{
    /**
     * @var \App\Repository\Transformers\UserTransformer
     * */
    protected $userTransformer;

    public function __construct(userTransformer $userTransformer)
    {
        $this->userTransformer = $userTransformer;

    }

    /**
     * Returns a the requested user object
     *
     * @param $id user_id
     * @return array
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return $this->userTransformer->transform($user);
    }

    /**
     * Handles updates to an existing resource
     *
     * @param $id user_id
     * @return array
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $input_data = $request->input('user');

        if( !empty($input_data) ){
            foreach($input_data as $field => $value){
                $user->$field = $value;
            }

            $user->save();
        }

        return $this->userTransformer->transform($user);
    }
}
