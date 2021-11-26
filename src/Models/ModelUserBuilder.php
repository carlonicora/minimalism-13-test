<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Interfaces\Encrypter\Parameters\PositionedEncryptedParameter;
use CarloNicora\Minimalism\Minimalism13Test\Readers\UserReader;

class ModelUserBuilder extends AbstractModel
{
    /**
     * @param UserReader $readUser
     * @param PositionedEncryptedParameter $id
     * @return int
     */
    public function get(
        UserReader $readUser,
        PositionedEncryptedParameter $id,
    ): int
    {
        $this->document->addResource(
            $readUser->loadResourceById(
                userId: $id->getValue()
            )
        );

        return 200;
    }
}