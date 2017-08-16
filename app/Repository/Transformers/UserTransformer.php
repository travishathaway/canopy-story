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
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
        ];
    }
}
