<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\M13T;

use CarloNicora\Minimalism\Minimalism13Test\Databases\M13T\Tables\BooksTable;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\TableDataInterface;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\Traits\MapFields;
use CarloNicora\Minimalism\Services\MySQL\Abstracts\AbstractMySqlTable;

enum BooksData: int implements TableDataInterface
{
    use MapFields;

    case Book1 = 1;
    case Book2 = 2;

    /**
     * @return string|AbstractMySqlTable
     */
    public static function tableClass(
    ): string|AbstractMySqlTable
    {
        return BooksTable::class;
    }

    /**
     * @return array
     */
    public function row(): array
    {
        return match ($this) {
            self::Book1 => $this->map(userId: UsersData::Default, title: 'My First Book'),
            self::Book2 => $this->map(userId: UsersData::Default, title: 'My Second Book'),
        };
    }

    /**
     * @param UsersData $userId
     * @param string $title
     * @return array
     */
    private function map(
        UsersData $userId,
        string $title,
    ): array
    {
        return self::mapFields(
            fieldsDefinitions: BooksTable::getTableFields(),
            fieldValues: [$this, $userId->value, $title]
        );
    }
}