<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\JsonApi\Objects\ResourceObject;
use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Interfaces\Encrypter\Interfaces\EncrypterInterface;
use CarloNicora\Minimalism\Interfaces\Encrypter\Parameters\PositionedEncryptedParameter;
use CarloNicora\Minimalism\Minimalism13Test\Data\User;
use CarloNicora\Minimalism\Minimalism13Test\Readers\UserReader;
use CarloNicora\Minimalism\Minimalism13Test\Validators\UserNewValidator;
use CarloNicora\Minimalism\Minimalism13Test\Validators\UserValidator;
use CarloNicora\Minimalism\Minimalism13Test\Writers\UserWriter;
use Exception;

class ModelDataMapper extends AbstractModel
{
    /**
     * @param EncrypterInterface $encrypter
     * @param UserReader $readUser
     * @param PositionedEncryptedParameter $id
     * @return int
     * @throws Exception
     */
    public function get(
        EncrypterInterface $encrypter,
        UserReader $readUser,
        PositionedEncryptedParameter $id,
    ): int
    {
        $user = $readUser->loadById(
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

        return 200;
    }

    /**
     * @param EncrypterInterface $encrypter
     * @param UserWriter $writeUser
     * @param UserNewValidator $payload
     * @return int
     * @throws Exception
     */
    public function post(
        EncrypterInterface $encrypter,
        UserWriter $writeUser,
        UserNewValidator $payload,
    ): int
    {
        $user = new User(
            objectFactory: $this->objectFactory,
            email: $payload->getDocument()->resources[0]->attributes->get('email')
        );
        $user = $writeUser->insert($user);

        $this->getDocument()->addResource(
            resource: new ResourceObject(
                type: 'user',
                id: $encrypter->encryptId($user->getId()),
            ),
        );

        return 201;
    }

    /**
     * @param EncrypterInterface $encrypter
     * @param UserReader $readUser
     * @param UserWriter $writeUser
     * @param UserValidator $payload
     * @return int
     * @throws Exception
     */
    public function patch(
        EncrypterInterface $encrypter,
        UserReader $readUser,
        UserWriter $writeUser,
        UserValidator $payload,
    ): int
    {
        $id = $encrypter->decryptId($payload->getDocument()->resources[0]->id);

        $user = $readUser->loadById($id);
        $user->setEmail($payload->getDocument()->resources[0]->attributes->get('email'));

        $writeUser->update($user);

        return 200;
    }
}