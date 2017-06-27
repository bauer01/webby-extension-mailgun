<?php

namespace Webby\Extensions\Mailgun;

use Klimesf\Mailgun\MailgunMailer;
use Nette\DI\CompilerExtension;

class Extension extends CompilerExtension
{

    private $defaults = [
        "key" => null,
        "domain" => null
    ];

    public function loadConfiguration()
    {
        $config = $this->getConfig($this->defaults);
        $builder = $this->getContainerBuilder();

        $builder->getByType()
            ->setFactory(
                MailgunMailer::class,
                [
                    $config
                ]
            );

    }

}