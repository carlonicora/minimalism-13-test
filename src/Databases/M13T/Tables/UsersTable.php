<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Databases\M13T\Tables;

use CarloNicora\Minimalism\Services\MySQL\Abstracts\AbstractMySqlTable;
use CarloNicora\Minimalism\Services\MySQL\Interfaces\FieldInterface;

class UsersTable extends AbstractMySqlTable
{
    /** @var string */
    protected static string $tableName = 'users';

    /** @var array  */
    protected static array $fields = [
        'userId'            => FieldInterface::INTEGER
                            +  FieldInterface::PRIMARY_KEY
                            +  FieldInterface::AUTO_INCREMENT,
        'email'             => FieldInterface::STRING,
    ];
}