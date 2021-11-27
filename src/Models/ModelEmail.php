<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Interfaces\Mailer\Enums\RecipientType;
use CarloNicora\Minimalism\Interfaces\Mailer\Interfaces\MailerInterface;
use CarloNicora\Minimalism\Interfaces\Mailer\Objects\Email;
use CarloNicora\Minimalism\Interfaces\Mailer\Objects\Recipient;

class ModelEmail extends AbstractModel
{
    public function post(
        MailerInterface $mailer,
    ): int
    {
        $sender = new Recipient(
            emailAddress: 'carlo@phlow.com',
            name: 'Carlo Nicora',
            type: RecipientType::Sender,
        );
        $mail = new Email(
            sender: $sender,
            subject: 'test message for minimalism 13',
            body: 'This is a message from the minimalism 13 test'
        );
        $mail->addRecipient(
            new Recipient(
                emailAddress: 'carlo.nicora+recipient@gmail.com',
                name: 'Carlo Nicora',
                type: RecipientType::To,
            )
        );

        $mailer->send(email: $mail);

        return 201;
    }
}