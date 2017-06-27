<?php

namespace Webby\Extensions\Mailgun;


use Mailgun\Mailgun;
use Nette\Mail\IMailer;
use Nette\Mail\Message;

class Mailer implements IMailer
{

    private $mailgun;

    private $domain;

    public function __construct($domain, Mailgun $mailgun)
    {
        $this->domain = $domain;
        $this->mailgun = $mailgun;
    }

    public function send(Message $mail)
    {
        $postData = [
            'from'    => $mail->getHeader('Return-Path') ?: key($mail->getHeader('From')),
            'to'      => $this->getCommaSeparatedEmails((array) $mail->getHeader('To')),
            'cc'      => $this->getCommaSeparatedEmails((array) $mail->getHeader('Cc')),
            'bcc'     => $this->getCommaSeparatedEmails((array) $mail->getHeader('Bcc')),
            'subject' => $mail->getSubject(),
            'text'    => $mail->getBody(),
            'html'    => $mail->getHtmlBody()
        ];
        $this->mailgun->sendMessage($this->domain, array_filter($postData));
    }

    private function getCommaSeparatedEmails($emails)
    {
        return implode(
            ', ', array_map(
                function ($name, $email) {
                    return $name ? $name . ' <' . $email . '>' : $email;
                }, $emails, array_keys($emails)
            )
        );
    }

}