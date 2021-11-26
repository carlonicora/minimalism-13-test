<?php

namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Interfaces\Data\Interfaces\DataInterface;
use CarloNicora\Minimalism\Interfaces\Encrypter\Parameters\PositionedEncryptedParameter;
use CarloNicora\Minimalism\Minimalism13Test\Data\Databases\M13T\Tables\UsersTable;
use CarloNicora\Minimalism\Minimalism13Test\Factories\CacheFactory;
use Exception;

class ModelCachedDatabase extends AbstractModel
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
        $cacheFactory = new CacheFactory();

        $response = $data->read(
            tableInterfaceClassName: UsersTable::class,
            functionName: 'byId',
            parameters: [$id->getValue()],
            cacheBuilder: $cacheFactory->user($id->getValue()),
        );

        if (!array_is_list($response) || count($response) !== 1){
            return 404;
        }

        $email = $response[0]['email'];

        $response[0]['email'] = 'changed';
        $data->update(
            tableInterfaceClassName: UsersTable::class,
            records: $response,
        );

        $response = $data->read(
            tableInterfaceClassName: UsersTable::class,
            functionName: 'byId',
            parameters: [$id->getValue()],
            cacheBuilder: $cacheFactory->user($id->getValue()),
        );

        if ($email !== $response[0]['email']) {
            return 500;
        }

        return 200;
    }
}