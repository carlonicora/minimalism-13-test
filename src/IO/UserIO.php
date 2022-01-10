<?php
namespace CarloNicora\Minimalism\Minimalism13Test\IO;

use CarloNicora\JsonApi\Objects\ResourceObject;
use CarloNicora\Minimalism\Interfaces\Data\Interfaces\DataFunctionInterface;
use CarloNicora\Minimalism\Interfaces\Data\Objects\DataFunction;
use CarloNicora\Minimalism\Minimalism13Test\Abstracts\AbstractMinimalismLoader;
use CarloNicora\Minimalism\Minimalism13Test\Builders\UserBuilder;
use CarloNicora\Minimalism\Minimalism13Test\Data\User;
use CarloNicora\Minimalism\Minimalism13Test\Databases\M13T\Tables\UsersTable;
use Exception;

class UserIO extends AbstractMinimalismLoader
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
            )
        );
    }

    /**
     * @param User|User[] $users
     */
    public function update(
        User|array $users,
    ): void
    {
        $recordset = [];

        if (is_array($users)) {
            foreach ($users ?? [] as $user) {
                $recordset[] = $user->export();
            }
        } else {
            $recordset[] = $users->export();
        }

        $this->data->update(
            tableInterfaceClassName: UsersTable::class,
            records: $recordset,
        );
    }

    /**
     * @param User $user
     * @return User
     * @throws Exception
     */
    public function insert(
        User $user,
    ): User
    {
        $recordset = $this->data->insert(
            tableInterfaceClassName: UsersTable::class,
            records: [$user->export()],
        );

        return $this->returnSingleObject(
            recordset: $recordset,
            objectType: User::class,
        );
    }
}