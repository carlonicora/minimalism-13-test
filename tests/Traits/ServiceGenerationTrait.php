<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Traits;

use CarloNicora\Minimalism\Interfaces\Data\Interfaces\DataInterface;
use CarloNicora\Minimalism\Interfaces\Encrypter\Interfaces\EncrypterInterface;
use CarloNicora\Minimalism\Interfaces\ServiceInterface;
use CarloNicora\Minimalism\Minimalism;
use CarloNicora\Minimalism\Services\MySQL\MySQL;
use CarloNicora\Minimalism\Services\RabbitMq\RabbitMq;
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
    }

    /**
     * @return RabbitMq|ServiceInterface
     * @throws Exception
     */
    protected static function createRabbitMQ(
    ): RabbitMq|ServiceInterface
    {
        self::setupMinimalism();

        return self::$minimalism->getService(RabbitMq::class);
    }
}