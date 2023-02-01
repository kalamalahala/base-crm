<?php

namespace BaseCRM\ServerSide;
use BaseCRM\ServerSide\EmailInterface;

class BaseEmailHandler implements EmailInterface
{

    // properties
    private $to;
    private $subject;
    private $message_body;
    private $headers;
    private $attachments;

    public function __construct()
    {
        $this->to = '';
        $this->subject = '';
        $this->message_body = '';
        $this->headers = '';
        $this->attachments = null;

        return $this;
    }


    /**
     * Send email using the current object properties
     * 
     * @var string $to
     * @var string $subject
     * @var string $message_body
     * @var array|string $headers
     * @var array|string $attachments
     *
     * @return boolean
     */
    public function sendEmail(): bool
    {
        return wp_mail($this->to, $this->subject, $this->message_body, $this->headers, $this->attachments ?? []);
    }

    public function getTo()
    {
        return $this->to;
    }

    public function setTo($to)
    {
        $this->to = $to;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function getMessageBody()
    {
        return $this->message_body;
    }

    public function setMessageBody($message_body)
    {
        $this->message_body = $message_body;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    public function getAttachments()
    {
        return $this->attachments;
    }

    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;
    }

}