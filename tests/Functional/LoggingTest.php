<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Functional;

use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\AbstractFunctionalTest;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\Data;
use CarloNicora\Minimalism\Enums\HttpCode;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Enums\Verbs;
use Exception;

class LoggingTest extends AbstractFunctionalTest
{
    /**
     * @throws Exception
     */
    public function testGet(
    ): void
    {
        $response = self::call(
            request: new Data(
                verb: Verbs::Get,
                endpoint: '/modellogging',
            )
        );

        self::assertEquals(
            expected: HttpCode::Ok,
            actual: $response->getHttpCode(),
        );
    }
}