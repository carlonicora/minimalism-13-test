<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Database\Setup\Traits;

use CarloNicora\Minimalism\Services\MySQL\MySQL;
use Exception;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\Tables;

trait GenerateData
{
    /**
     * @throws Exception
     */
    protected static function cleanDatabases(
        MySQL $mysqlService
    ): void
    {
        foreach (Tables::cases() as $table) {
            /** @noinspection UnusedFunctionResultInspection */
            $mysqlService->runSQL(
                tableInterfaceClassName: $table->dataEnum()::tableClass(),
                sql: 'TRUNCATE TABLE ' . $table->dataEnum()::tableClass()::getTableName()
            );
        }
    }

    /**
     * @param MySQL $mysqlService
     * @throws Exception
     */
    protected static function generateTestData(
        MySQL $mysqlService
    ): void
    {
        foreach (Tables::cases() as $table) {
            $records = $table->records();
            if (! empty($records)) {
                /** @noinspection UnusedFunctionResultInspection */
                $mysqlService->insert(
                    tableInterfaceClassName: $table->dataEnum()::tableClass(),
                    records: $records
                );
            }
        }
    }

}