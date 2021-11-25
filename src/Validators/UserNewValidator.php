<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Validators;

use CarloNicora\Minimalism\Services\DataValidator\Abstracts\AbstractDataValidator;
use CarloNicora\Minimalism\Services\DataValidator\Objects\AttributeValidator;
use CarloNicora\Minimalism\Services\DataValidator\Objects\DocumentValidator;
use CarloNicora\Minimalism\Services\DataValidator\Objects\ResourceValidator;

class UserNewValidator extends AbstractDataValidator
{
    /**
     *
     */
    public function __construct(
    )
    {
        $this->documentValidator = new DocumentValidator();

        $resourceValidator = new ResourceValidator(
            type: 'user',
            isIdRequired: false,
            isSingleResource: true,
        );

        $resourceValidator->addAttributeValidator(new AttributeValidator(name:'email', isRequired: true));

        $this->documentValidator->addResourceValidator(
            validator: $resourceValidator
        );
    }
}