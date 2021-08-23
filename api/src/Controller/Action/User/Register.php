<?php

namespace App\Controller\Action\User;

use App\Entity\User;
use App\Services\User\UserRegisterService;
use Symfony\Component\HttpFoundation\Request;

class Register
{
    private UserRegisterService $userRegister;

    public function __construct(UserRegisterService $userRegister)
    {
        $this->userRegister = $userRegister;
    }

    public function __invoke(Request $request):User
    {
        return $this->userRegister->create($request);
    }
}