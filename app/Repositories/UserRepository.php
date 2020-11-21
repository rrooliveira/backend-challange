<?php


namespace App\Repositories;


use App\Model\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}
