<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData;

use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\M13T\UsersData;
use IntBackedEnum;

enum Tables
{
    case Users;

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
            self::Users=> UsersData::class,
        };
    }
}