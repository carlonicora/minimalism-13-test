<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Enums\HttpCode;
use CarloNicora\Minimalism\Interfaces\Encrypter\Parameters\PositionedEncryptedParameter;
use CarloNicora\Minimalism\Minimalism13Test\IO\UserIO;

class ModelUserBuilder extends AbstractModel
{
    /**
     * @param UserIO $readUser
     * @param PositionedEncryptedParameter $id
     * @return HttpCode
     */
    public function get(
        UserIO                       $readUser,
        PositionedEncryptedParameter $id,
    ): HttpCode
    {
        $this->document->addResource(
            $readUser->loadResourceById(
                userId: $id->getValue()
            )
        );

        return HttpCode::Ok;
    }
}