<?php


namespace App\Exception\User;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserRegistered extends NotFoundHttpException
{
    private const MESSAGE = "User with email %s currently is registered.";

    /**
     * @param string $email
     */
    public static function fromEmail(string $email)
    {
        throw new self(\sprintf(self::MESSAGE, $email));
    }
}