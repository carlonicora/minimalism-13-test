<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\Oauth;

use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\M13T\UsersData;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\TableDataInterface;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\Traits\MapFields;
use CarloNicora\Minimalism\Services\Auth\Databases\OAuth\Tables\AppsTables;
use CarloNicora\Minimalism\Services\Auth\Databases\OAuth\Tables\Enums\AppReliability;
use CarloNicora\Minimalism\Services\Auth\Databases\OAuth\Tables\Enums\AppStatus;
use CarloNicora\Minimalism\Services\MySQL\Abstracts\AbstractMySqlTable;

enum AppsData: int implements TableDataInterface
{
    use MapFields;

    case Default = 1;

    /**
     * @return string|AbstractMySqlTable
     */
    public static function tableClass(): string|AbstractMySqlTable
    {
        return AppsTables::class;
    }

    /**
     * @return array
     */
    public function row(): array
    {
        return match ($this) {
            self::Default => $this->map(user: UsersData::Default, name: 'live', url: 'https://app.phlow.com/auth', clientId: '0f626d858ac5bae30ab5169645cddc20fa8c55e1c02b95792d8c321171551e20'),
        };
    }

    /**
     * @param UsersData $user
     * @param string $name
     * @param string $url
     * @param string $clientId
     * @return array
     */
    private function map(
        UsersData $user,
        string    $name,
        string    $url,
        string    $clientId
    ): array
    {
        return self::mapFields(
            fieldsDefinitions: AppsTables::getTableFields(),
            fieldValues: [$this, $user, $name, $url, AppStatus::Active, AppReliability::Trusted, $clientId, null, null]
        );
    }
}