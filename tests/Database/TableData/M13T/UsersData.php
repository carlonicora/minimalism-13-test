<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\M13T;

use CarloNicora\Minimalism\Minimalism13Test\Data\Databases\M13T\Tables\UsersTable;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\TableDataInterface;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\Traits\MapFields;
use CarloNicora\Minimalism\Services\MySQL\Abstracts\AbstractMySqlTable;

enum UsersData: int implements TableDataInterface
{
    use MapFields;

    case Default = 1;

    /**
     * @return string|AbstractMySqlTable
     */
    public static function tableClass(): string|AbstractMySqlTable
    {
        return UsersTable::class;
    }

    /**
     * @return array
     */
    public function row(): array
    {
        return match ($this) {
            self::Default => $this->map(email: 'my@email.com'),
        };
    }

    /**
     * @param string $email
     * @return array
     */
    private function map(
        string                $email,
    ): array
    {
        return self::mapFields(
            fieldsDefinitions: UsersTable::getTableFields(),
            fieldValues: [$this, $email]
        );
    }
}