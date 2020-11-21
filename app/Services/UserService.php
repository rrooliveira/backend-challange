<?php


namespace App\Services;


use App\Model\User;
use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function checkIfUserIsValid(int $userId)
    {
        $user = $this->userRepository->find($userId);

        if (is_null($user)) {
            return false;
        }

        return $user;
    }

    public function checkIfUserCanTransferValue(User $user): bool
    {
        if ($user->type_user == 'S') {
            return false;
        }
        return true;
    }
}
