<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Readers;

use CarloNicora\JsonApi\Objects\ResourceObject;
use CarloNicora\Minimalism\Interfaces\Data\Interfaces\DataFunctionInterface;
use CarloNicora\Minimalism\Interfaces\Data\Objects\DataFunction;
use CarloNicora\Minimalism\Minimalism13Test\Abstracts\AbstractMinimalismLoader;
use CarloNicora\Minimalism\Minimalism13Test\Builders\UserBuilder;
use CarloNicora\Minimalism\Minimalism13Test\Data\User;
use CarloNicora\Minimalism\Minimalism13Test\Databases\M13T\Tables\UsersTable;
use Exception;

class UserReader extends AbstractMinimalismLoader
{
    /**
     * @param int $userId
     * @return User
     * @throws Exception
     */
    public function loadById(
        int $userId,
    ): User
    {
        /** @see UsersTable::byId() */
        $recordset = $this->data->read(
            tableInterfaceClassName: UsersTable::class,
            functionName: 'byId',
            parameters: [$userId],
            cacheBuilder: $this->cacheFactory->user($userId),
        );

        return $this->returnSingleObject(
            recordset: $recordset,
            objectType: User::class,
        );
    }

    /**
     * @param int $userId
     * @return ResourceObject
     */
    public function loadResourceById(
        int $userId,
    ): ResourceObject
    {
        /** @see UsersTable::byId() */
        return current(
            $this->builder->build(
                resourceTransformerClass: UserBuilder::class,
                function: new DataFunction(
                    type: DataFunctionInterface::TYPE_TABLE,
                    className: UsersTable::class,
                    functionName: 'byId',
                    parameters: [$userId],
                    cacheBuilder: $this->cacheFactory->user($userId)
                ),
                relationshipLevel: 1,
            )
        );
    }
}