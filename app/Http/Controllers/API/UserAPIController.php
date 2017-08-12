<?php 

namespace App\Http\Controllers\API;

use App\User;
use App\Repository\Transformers\UserTransformer;

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
}
