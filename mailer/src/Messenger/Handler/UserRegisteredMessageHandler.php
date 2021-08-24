<?php


namespace Mailer\Messenger\Handler;


use Mailer\Messenger\Message\UserRegisterMessage;
use Mailer\Services\Mailer\ClientRoute;
use Mailer\Services\Mailer\MailerService;
use Mailer\Templating\TwigTemplate;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UserRegisteredMessageHandler implements MessageHandlerInterface
{
    private MailerService $mailer;
    private string $host;

    public function __construct(MailerService $mailer, string $host)
    {
        $this->mailer = $mailer;
        $this->host = $host;
    }

    /**
     * @throws \Twig\Error\SyntaxError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\LoaderError
     */
    public function __invoke(UserRegisterMessage $message):void
    {
        $payload = [
            'name'=>$message->getName(),
            'url'=>sprintf(
                '%s%s?token=%s&uuid=%s',
                $this->host,
                ClientRoute::ACTIVATE_ACCOUNT,
                $message->getToken(),
                $message->getIdUser()
            )
        ];

        $this->mailer->send($message->getEmail(), TwigTemplate::USER_REGISTER, $payload);
    }
}