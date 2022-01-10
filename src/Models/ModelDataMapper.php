<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\JsonApi\Objects\ResourceObject;
use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Enums\HttpCode;
use CarloNicora\Minimalism\Interfaces\Encrypter\Interfaces\EncrypterInterface;
use CarloNicora\Minimalism\Interfaces\Encrypter\Parameters\PositionedEncryptedParameter;
use CarloNicora\Minimalism\Minimalism13Test\Data\User;
use CarloNicora\Minimalism\Minimalism13Test\IO\UserIO;
use CarloNicora\Minimalism\Minimalism13Test\Validators\UserNewValidator;
use CarloNicora\Minimalism\Minimalism13Test\Validators\UserValidator;
use Exception;

class ModelDataMapper extends AbstractModel
{
    /**
     * @param EncrypterInterface $encrypter
     * @param PositionedEncryptedParameter $id
     * @return HttpCode
     * @throws Exception
     */
    public function get(
        EncrypterInterface           $encrypter,
        PositionedEncryptedParameter $id,
    ): HttpCode
    {
        $user = $this->objectFactory->create(UserIO::class)->loadById(
            $id->getValue()
        );

        $userResource = new ResourceObject(
            type: 'user',
            id: $encrypter->encryptId($user->getId())
        );
        $userResource->attributes->add(
            name: 'email',
            value: $user->getEmail(),
        );

        $this->document->addResource(
            $userResource
        );

        return HttpCode::Ok;
    }

    /**
     * @param EncrypterInterface $encrypter
     * @param UserNewValidator $payload
     * @return HttpCode
     * @throws Exception
     */
    public function post(
        EncrypterInterface $encrypter,
        UserNewValidator $payload,
    ): HttpCode
    {
        $user = new User(
            objectFactory: $this->objectFactory,
            email: $payload->getDocument()->resources[0]->attributes->get('email')
        );
        $user = $this->objectFactory->create(UserIO::class)->insert($user);

        $this->getDocument()->addResource(
            resource: new ResourceObject(
                type: 'user',
                id: $encrypter->encryptId($user->getId()),
            ),
        );

        return HttpCode::Created;
    }

    /**
     * @param EncrypterInterface $encrypter
     * @param UserValidator $payload
     * @return HttpCode
     * @throws Exception
     */
    public function patch(
        EncrypterInterface $encrypter,
        UserValidator      $payload,
    ): HttpCode
    {
        $id = $encrypter->decryptId($payload->getDocument()->resources[0]->id);

        $user = $this->objectFactory->create(UserIO::class)->loadById($id);
        $user->setEmail($payload->getDocument()->resources[0]->attributes->get('email'));

        $this->objectFactory->create(UserIO::class)->update($user);

        return HttpCode::NoContent;
    }
}