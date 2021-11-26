<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Validators;

use CarloNicora\Minimalism\Interfaces\Data\Interfaces\DataInterface;
use CarloNicora\Minimalism\Interfaces\Encrypter\Interfaces\EncrypterInterface;
use CarloNicora\Minimalism\Minimalism13Test\Databases\M13T\Tables\UsersTable;
use CarloNicora\Minimalism\Services\DataValidator\Abstracts\AbstractDataValidator;
use CarloNicora\Minimalism\Services\DataValidator\Objects\AttributeValidator;
use CarloNicora\Minimalism\Services\DataValidator\Objects\DocumentValidator;
use CarloNicora\Minimalism\Services\DataValidator\Objects\ResourceValidator;
use Exception;

class UserValidator extends AbstractDataValidator
{
    /**
     *
     */
    public function __construct(
        private EncrypterInterface $encrypter,
        private DataInterface $data,
    )
    {
        $this->documentValidator = new DocumentValidator();

        $resourceValidator = new ResourceValidator(
            type: 'user',
            isIdRequired: true,
            isSingleResource: true,
        );

        $resourceValidator->addAttributeValidator(new AttributeValidator(name:'email', isRequired: true));

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
        $id = $this->encrypter->decryptId($this->getDocument()->resources[0]->id);

        $response = $this->data->read(
            tableInterfaceClassName: UsersTable::class,
            functionName: 'byId',
            parameters: [$id],
        );

        return (array_is_list($response) && count($response) === 1);
    }
}