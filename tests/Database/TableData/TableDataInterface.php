<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData;

use CarloNicora\Minimalism\Services\MySQL\Abstracts\AbstractMySqlTable;

interface TableDataInterface
{

    /**
     * @return string|AbstractMySqlTable
     */
    public static function tableClass(): string|AbstractMySqlTable;

    /**
     * @return array
     */
    public function row(): array;
}