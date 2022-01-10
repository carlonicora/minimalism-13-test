<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Enums\HttpCode;
use CarloNicora\Minimalism\Interfaces\LoggerInterface;

class ModelLogging extends AbstractModel
{
    /**
     * @param LoggerInterface $logger
     * @return HttpCode
     */
    public function get(
        LoggerInterface $logger,
    ): HttpCode
    {
        $logger->debug('debug message', 'minimalism 13 test', ['Model'=>self::class]);
        $logger->info('info message', 'minimalism 13 test', ['Model'=>self::class]);
        $logger->notice('notice message', 'minimalism 13 test', ['Model'=>self::class]);
        $logger->warning('warning message', 'minimalism 13 test', ['Model'=>self::class]);
        $logger->error('error message', 'minimalism 13 test', ['Model'=>self::class]);
        $logger->critical('critical message', 'minimalism 13 test', ['Model'=>self::class]);
        $logger->alert('alert message', 'minimalism 13 test', ['Model'=>self::class]);
        $logger->emergency('emergency message', 'minimalism 13 test', ['Model'=>self::class]);

        return HttpCode::Ok;
    }
}