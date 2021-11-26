<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Writers;

use CarloNicora\Minimalism\Minimalism13Test\Abstracts\AbstractMinimalismLoader;
use CarloNicora\Minimalism\Minimalism13Test\Data\User;
use CarloNicora\Minimalism\Minimalism13Test\Databases\M13T\Tables\UsersTable;
use Exception;

class UserWriter extends AbstractMinimalismLoader
{
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