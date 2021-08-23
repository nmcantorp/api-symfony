<?php


namespace Mailer\Serializer\Messenger;


use Mailer\Messenger\Message\UserRegisterMessage;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\Serializer;

class EventSerializer extends Serializer
{
    /**
     * @param array $encodedEnvelope
     * @return Envelope
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        $translateType = $this->translateType($encodedEnvelope['headers']['type']);

        $encodedEnvelope['headers']['type']=$translateType;

        return parent::decode($encodedEnvelope);
    }

    /**
     * @param string $type
     * @return string
     */
    private function translateType(string $type): string
    {
        $map = ['App\Messenger\Message\UserRegisteredMessage' =>UserRegisterMessage::class];

        if(array_key_exists($type, $map)){
            return $map[$type];
        }

    }
}