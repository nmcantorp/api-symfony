<?php
namespace Mailer\Messenger\Message;

class UserRegisterMessage
{
    private int $idUser;
    private string $name;
    private string $email;
    private string $token;

    /**
     * UserRegisterMessage constructor.
     * @param int $idUser
     * @param string $name
     * @param string $email
     * @param string $token
     */
    public function __construct(int $idUser, string $name, string $email, string $token)
    {
        $this->idUser = $idUser;
        $this->name = $name;
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * @return int
     */
    public function getIdUser(): int
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