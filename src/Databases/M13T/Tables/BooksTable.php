<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Databases\M13T\Tables;

use CarloNicora\Minimalism\Services\MySQL\Abstracts\AbstractMySqlTable;
use CarloNicora\Minimalism\Services\MySQL\Interfaces\FieldInterface;
use Exception;

class BooksTable extends AbstractMySqlTable
{
    /** @var string */
    protected static string $tableName = 'books';

    /** @var array  */
    protected static array $fields = [
        'bookId'    => FieldInterface::INTEGER
                    +  FieldInterface::PRIMARY_KEY
                    +  FieldInterface::AUTO_INCREMENT,
        'userId'    => FieldInterface::INTEGER,
        'title'     => FieldInterface::STRING,
    ];

    /**
     * @param int $userId
     * @return array
     * @throws Exception
     */
    public function readByUserId(
        int $userId,
    ): array
    {
        $this->sql = 'SELECT *'
            . ' FROM ' . self::$tableName
            . ' WHERE userId=?;';
        $this->parameters = ['i', $userId];

        return $this->functions->runRead();
    }
}