<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\JsonApi\Objects\ResourceObject;
use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Interfaces\Data\Interfaces\DataInterface;
use CarloNicora\Minimalism\Interfaces\Encrypter\Interfaces\EncrypterInterface;
use CarloNicora\Minimalism\Interfaces\Encrypter\Parameters\PositionedEncryptedParameter;
use CarloNicora\Minimalism\Minimalism13Test\Databases\M13T\Tables\UsersTable;
use CarloNicora\Minimalism\Minimalism13Test\Validators\UserNewValidator;
use CarloNicora\Minimalism\Minimalism13Test\Validators\UserValidator;
use Exception;

class ModelDatabase extends AbstractModel
{
    /**
     * @param DataInterface $data
     * @param PositionedEncryptedParameter $id
     * @return int
     * @throws Exception
     */
    public function get(
        DataInterface $data,
        PositionedEncryptedParameter $id,
    ): int
    {
        $response = $data->read(
            tableInterfaceClassName: UsersTable::class,
            functionName: 'byId',
            parameters: [$id->getValue()],
        );

        if (!array_is_list($response) || count($response) !== 1){
            return 404;
        }

        $user = new ResourceObject(
            type: 'user',
            id:  $id->getEncryptedValue()
        );
        $user->attributes->add('email', $response[0]['email']);

        $this->document->addResource(
            $user
        );

        return 200;
    }

    /**
     * @param EncrypterInterface $encrypter
     * @param DataInterface $data
     * @param UserNewValidator $payload
     * @return int
     * @throws Exception
     */
    public function post(
        EncrypterInterface $encrypter,
        DataInterface $data,
        UserNewValidator $payload,
    ): int
    {
        $newUser = [
            'email' => $payload->getDocument()->resources[0]->attributes->get('email')
        ];

        $newUser = $data->insert(
            tableInterfaceClassName: UsersTable::class,
            records: [$newUser],
        );

        $this->getDocument()->addResource(
            resource: new ResourceObject(
                type: 'user',
                id: $encrypter->encryptId($newUser['userId']),
            ),
        );

        return 201;
    }

    /**
     * @param EncrypterInterface $encrypter
     * @param DataInterface $data
     * @param UserValidator $payload
     * @return int
     * @throws Exception
     */
    public function patch(
        EncrypterInterface $encrypter,
        DataInterface $data,
        UserValidator $payload,
    ): int
    {
        $id = $encrypter->decryptId($payload->getDocument()->resources[0]->id);

        $recordset = $data->read(
            tableInterfaceClassName: UsersTable::class,
            functionName: 'byId',
            parameters: [$id],
        );

        $recordset[0]['email'] = $payload->getDocument()->resources[0]->attributes->get('email');
        $data->update(
            tableInterfaceClassName: UsersTable::class,
            records: $recordset,
        );

        return 200;
    }
}