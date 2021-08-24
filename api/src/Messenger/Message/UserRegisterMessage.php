<?php

namespace App\Messenger\Message;

class UserRegisterMessage
{
    private string $idUser;
    private string $name;
    private string $email;
    private string $token;

    /**
     * UserRegisterMessage constructor.
     * @param string $idUser
     * @param string $name
     * @param string $email
     * @param string $token
     */
    public function __construct(string $idUser, string $name, string $email, string $token)
    {
        $this->idUser = $idUser;
        $this->name = $name;
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getIdUser(): string
    {
        return $this->idUser;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}