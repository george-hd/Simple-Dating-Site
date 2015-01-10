<?php

/**
 * Class messageViewModel
 * helper class for sending specified data to the view
 */

class messageViewModel {
    private $sender;
    private $receiver;
    private $message;

    public function __construct(Message $message)
    {
        $user = User::find($message->sender);
        $this->sender = $user;
        $receiver = User::find($message->receiver);
        $this->receiver = $receiver;
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param mixed $receiver
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param Message $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param mixed $sender
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }
} 