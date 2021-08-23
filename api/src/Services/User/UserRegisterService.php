<?php

namespace App\Services\User;

use App\Entity\User;
use App\Exception\User\UserRegistered;
use App\Messenger\Message\UserRegisterMessage;
use App\Messenger\RoutingKey;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegisterService
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $userPasswordHasher;
    private MessageBusInterface $messageBus;

    /**
     * @param UserRepository $userRepository
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param MessageBusInterface $messageBus
     */
    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasher, MessageBusInterface $messageBus)
    {
        $this->userRepository = $userRepository;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->messageBus = $messageBus;
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

        $temporal = $this->messageBus->dispatch(
            new UserRegisterMessage($user->getId(), $user->getName(), $user->getEmail(), $user->getToken()),
            [new AmqpStamp(RoutingKey::USERQUEUE)]
        );
dump($temporal);die;
        return $user;
    }
}