<?php

namespace Webby\Extensions\Mailgun;

use Nette\DI\CompilerExtension;
use Nette\Mail\IMailer;

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

        $builder->addDefinition($this->prefix('mailgun'))
            ->setClass(
                'Mailgun\Mailgun',
                [
                    $config['key']
                ]
            );

        // Replace default mailer
        $builder->getDefinitionByType(IMailer::class)->setFactory(
            Mailer::class,
            [
                $config['domain']
            ]
        );
    }

}