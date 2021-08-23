<?php

namespace App\Services\User;

use App\Entity\User;
use App\Exception\User\UserRegistered;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegisterService
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $userPasswordHasher;

    /**
     * @param UserRepository $userRepository
     * @param UserPasswordHasherInterface $userPasswordHasher
     */
    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userRepository = $userRepository;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function create(Request $request): User
    {
        $data = json_decode($request->getContent(), true);
        if($this->userRepository->findOneBy(['email'=>$data['email']])){
            throw UserRegistered::fromEmail($data['email']);
        }
        $user = new User($data['name'], $data['email']);
        $this->userRepository->upgradePassword(
            $user,
            $this->userPasswordHasher->hashPassword($user, $data['password'])
        );

        return $user;
    }
}