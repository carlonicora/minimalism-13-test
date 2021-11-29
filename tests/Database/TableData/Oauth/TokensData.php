<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\Oauth;

use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\M13T\UsersData;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\TableDataInterface;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\Traits\MapFields;
use CarloNicora\Minimalism\Services\Auth\Databases\OAuth\Tables\Enums\TokenUserType;
use CarloNicora\Minimalism\Services\Auth\Databases\OAuth\Tables\TokensTable;
use CarloNicora\Minimalism\Services\MySQL\Abstracts\AbstractMySqlTable;
use RuntimeException;

enum TokensData: string implements TableDataInterface
{
    use MapFields;

    case Default = 'bearerValidUser';

    /**
     * @param UsersData $user
     * @return self
     */
    public static function byUser(
        UsersData $user
    ): self
    {
        foreach (self::cases() as $token) {
            if ($token->user() === $user) {
                return $token;
            }
        }

        throw new RuntimeException('Token not found for a user with id ' . $user->value);
    }

    /**
     * @return UsersData|null
     */
    public function user(): ?UsersData
    {
        return $this->isUser() === TokenUserType::Registered ? UsersData::from($this->row()['userId']) : null;
    }

    /**
     * @return TokenUserType
     */
    private function isUser(): TokenUserType
    {
        return TokenUserType::from($this->row()['isUser']);
    }

    /**
     * @return array
     */
    public function row(): array
    {
        return match ($this) {
            self::Default        => $this->map(user: UsersData::Default),
        };
    }

    /**
     * @param UsersData $user
     * @param TokenUserType $isUser
     * @return array
     */
    private function map(
        UsersData     $user,
        TokenUserType $isUser = TokenUserType::Registered,
    ): array
    {
        return self::mapFields(
            fieldsDefinitions: TokensTable::getTableFields(),
            fieldValues: [null, AppsData::Default, $user, $isUser, $this]
        );
    }

    /**
     * @return string|AbstractMySqlTable
     */
    public static function tableClass(): string|AbstractMySqlTable
    {
        return TokensTable::class;
    }

    /**
     * @return int|null
     */
    public function visitorId(): ?int
    {
        return $this->isUser() === TokenUserType::Visitor ? $this->row()['userId'] : null;
    }
}