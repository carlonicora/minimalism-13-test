<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData;

use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\M13T\BooksData;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\M13T\UsersData;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\Oauth\AppleIdsData;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\Oauth\AppScopesData;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\Oauth\AppsData;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\Oauth\AuthsData;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\Oauth\CodesData;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\Oauth\ScopesData;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\Oauth\TokensData;
use IntBackedEnum;

enum Tables
{
    //test
    case Users;
    case Books;

    // Oauth
    case AppleIds;
    case Apps;
    case AppScopes;
    case Auths;
    case Codes;
    case OauthScopes;
    case Tokens;

    /**
     * @return array
     */
    public function records(): array
    {
        $data = $this->dataEnum();

        $records = [];
        foreach ($data::cases() as $record) {
            $row = $record->row();
            if (! empty($row)) {
                $records [] = $record->row();
            }
        }

        return $records;
    }

    /**
     * @return string|IntBackedEnum|TableDataInterface
     */
    public function dataEnum(): string|IntBackedEnum|TableDataInterface
    {
        return match ($this) {
            self::Users => UsersData::class,
            self::Books => BooksData::class,
            self::AppleIds => AppleIdsData::class,
            self::Apps => AppsData::class,
            self::AppScopes => AppScopesData::class,
            self::Auths => AuthsData::class,
            self::Codes => CodesData::class,
            self::OauthScopes => ScopesData::class,
            self::Tokens => TokensData::class,
        };
    }
}