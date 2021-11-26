<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\JsonApi\Objects\ResourceObject;
use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Interfaces\Encrypter\Interfaces\EncrypterInterface;
use CarloNicora\Minimalism\Interfaces\Encrypter\Parameters\PositionedEncryptedParameter;
use CarloNicora\Minimalism\Minimalism13Test\Readers\UserReader;
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
}