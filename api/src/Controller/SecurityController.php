<?php

namespace App\Controller;

use App\Services\User\UserRegisterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    private UserRegisterService $userRegister;

    /**
     * @param UserRegisterService $userRegister
     */
    public function __construct(UserRegisterService $userRegister)
    {
        $this->userRegister = $userRegister;
    }

    /**
     * @Route("/register", name="register_user", methods={"POST"})
     */
    public function index(Request $request): Response
    {
        $user = $this->userRegister->create($request);
        return new JsonResponse(['user_id'=>$user->getId()]);
    }
}
