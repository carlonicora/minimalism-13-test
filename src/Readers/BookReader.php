<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Readers;

use CarloNicora\Minimalism\Minimalism13Test\Abstracts\AbstractMinimalismLoader;
use CarloNicora\Minimalism\Minimalism13Test\Databases\M13T\Tables\BooksTable;
use Exception;

class BookReader extends AbstractMinimalismLoader
{
    /**
     * @param int $userId
     * @return array
     * @throws Exception
     */
    public function loadByUserId(
        int $userId,
    ): array
    {
        /** @see BooksTable::readByUserId() */
        return $this->data->read(
            tableInterfaceClassName: BooksTable::class,
            functionName: 'readByUserId',
            parameters: [$userId],
        );
    }
}