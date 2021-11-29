<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\Oauth;

use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\TableDataInterface;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\Traits\MapFields;
use CarloNicora\Minimalism\Services\Auth\Databases\OAuth\Tables\AppScopesTable;
use CarloNicora\Minimalism\Services\MySQL\Abstracts\AbstractMySqlTable;

enum AppScopesData: int implements TableDataInterface
{
    use MapFields;

    case Default = 1;

    /**
     * @return string|AbstractMySqlTable
     */
    public static function tableClass(): string|AbstractMySqlTable
    {
        return AppScopesTable::class;
    }

    /**
     * @return array
     */
    public function row(): array
    {
        return match ($this) {
            self::Default => $this->map(),
        };
    }

    /**
     * @return array
     */
    private function map(): array
    {
        return self::mapFields(
            fieldsDefinitions: AppScopesTable::getTableFields(),
            fieldValues: []
        );
    }
}