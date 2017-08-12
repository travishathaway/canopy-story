<?php

namespace App\Repository\Transformers;

/**
 * Class that defines the transformation behaviour 
 * for the User model
 */
class UserTransformer extends BaseTransformer{
    /**
     * Provide only details about the user that we want
     * to return in the API
     *
     * @param $user User
     * @return array
     */
    public function transform($user){
        return [
            'fullname' => $user->name,
            'email' => $user->email,
            'api_token' => $user->token,
        ];
    }
}
