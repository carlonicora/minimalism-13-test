<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Validators;

use CarloNicora\Minimalism\Interfaces\Encrypter\Interfaces\EncrypterInterface;
use CarloNicora\Minimalism\Services\DataValidator\Abstracts\AbstractDataValidator;
use CarloNicora\Minimalism\Services\DataValidator\Objects\AttributeValidator;
use CarloNicora\Minimalism\Services\DataValidator\Objects\DocumentValidator;
use CarloNicora\Minimalism\Services\DataValidator\Objects\ResourceValidator;
use \Exception;

class TestValidator extends AbstractDataValidator
{
    /**
     *
     */
    public function __construct(
        private EncrypterInterface $encrypter,
    )
    {
        $this->documentValidator = new DocumentValidator();

        $resourceValidator = new ResourceValidator(type: 'test', isIdRequired: true);
        $resourceValidator->addAttributeValidator(new AttributeValidator(name:'name', isRequired: true));
        $resourceValidator->addAttributeValidator(new AttributeValidator(name:'description'));

        $this->documentValidator->addResourceValidator(
            validator: $resourceValidator
        );
    }

    /**
     * @return bool
     * @throws Exception
     */
    public function validateData(
    ): bool
    {
        $testResource = $this->getDocument()->resources[0];

        return $testResource->id === $this->encrypter->encryptId(1);
    }
}