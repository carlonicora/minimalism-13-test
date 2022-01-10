<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Enums\HttpCode;
use CarloNicora\Minimalism\Interfaces\Mailer\Enums\RecipientType;
use CarloNicora\Minimalism\Interfaces\Mailer\Interfaces\MailerInterface;
use CarloNicora\Minimalism\Interfaces\Mailer\Objects\Recipient;
use CarloNicora\Minimalism\Services\Path;
use CarloNicora\Minimalism\Services\TwigMailer\Objects\TwigEmail;
use Exception;

class ModelEmailTwig extends AbstractModel
{
    /**
     * @param Path $path
     * @param MailerInterface $mailer
     * @return HttpCode
     * @throws Exception
     */
    public function post(
        Path $path,
        MailerInterface $mailer,
    ): HttpCode
    {
        $sender = new Recipient(
            emailAddress: 'carlo@phlow.com',
            name: 'Carlo Nicora',
            type: RecipientType::Sender,
        );

        $mail = new TwigEmail(
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

        $mail->addTemplate(file_get_contents($path->getRoot() . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'email.twig'));

        $mail->setParameters([
            'receiver' => [
                'name' => 'Carlo'
            ]
        ]);

        $mailer->send(email: $mail);

        return HttpCode::Created;
    }
}