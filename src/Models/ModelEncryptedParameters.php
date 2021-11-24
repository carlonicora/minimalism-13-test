<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Interfaces\Encrypter\Parameters\EncryptedParameter;
use CarloNicora\Minimalism\Interfaces\Encrypter\Parameters\PositionedEncryptedParameter;
use Exception;

class ModelEncryptedParameters extends AbstractModel
{
    /**
     * @param PositionedEncryptedParameter $id
     * @param EncryptedParameter $name
     * @return int
     * @throws Exception
     */
    public function get(
        PositionedEncryptedParameter $id,
        EncryptedParameter $name,
    ): int
    {
        $this->document->meta->add('id', $id->getValue());
        $this->document->meta->add('name', $name->getValue());
        return 200;
    }
}