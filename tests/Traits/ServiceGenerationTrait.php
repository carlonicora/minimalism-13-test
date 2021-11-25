<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Traits;

use CarloNicora\Minimalism\Interfaces\Data\Interfaces\DataInterface;
use CarloNicora\Minimalism\Interfaces\Encrypter\Interfaces\EncrypterInterface;
use CarloNicora\Minimalism\Interfaces\ServiceInterface;
use CarloNicora\Minimalism\Minimalism;
use CarloNicora\Minimalism\Services\MySQL\MySQL;
use Exception;

trait ServiceGenerationTrait
{
    /** @var Minimalism|null  */
    protected static ?Minimalism $minimalism=null;

    /**
     *
     */
    private static function setupMinimalism(
    ): void
    {
        if (self::$minimalism === null) {
            $_SERVER['HTTP_TEST_ENVIRONMENT'] = 1;
            self::$minimalism = new Minimalism();
        }
    }

    /**
     * @return EncrypterInterface|ServiceInterface
     * @throws Exception
     */
    protected static function createEncrypter(
    ): EncrypterInterface|ServiceInterface
    {
        self::setupMinimalism();

        return self::$minimalism->getService(EncrypterInterface::class);
    }

    /**
     * @return MySQL|DataInterface|ServiceInterface
     * @throws Exception
     */
    protected static function createMySQL(
    ): MySQL|DataInterface|ServiceInterface
    {
        self::setupMinimalism();

        return self::$minimalism->getService(MySQL::class);

        /*
        if (self::$mysql === null) {
            $MINIMALISM_SERVICE_MYSQL = self::getEnvParameter('MINIMALISM_SERVICE_MYSQL');
            putenv('MINIMALISM_SERVICE_MYSQL=' . $MINIMALISM_SERVICE_MYSQL);
            $_ENV['MINIMALISM_SERVICE_MYSQL'] = $MINIMALISM_SERVICE_MYSQL;
            foreach (explode(',', $MINIMALISM_SERVICE_MYSQL) as $db){
                $dbConnectionString = self::getEnvParameter($db);
                putenv($db . '=' . $dbConnectionString);
                $_ENV[$db] = $dbConnectionString;
            }

            self::$mysql = new MySQL(
                logger: self::generateLogger(),
                cache: null,
                MINIMALISM_SERVICE_MYSQL: $MINIMALISM_SERVICE_MYSQL,
            );
        }

        return self::$mysql;
        */
    }
}