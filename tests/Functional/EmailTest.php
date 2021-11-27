<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Functional;

use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\AbstractFunctionalTest;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\Data;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Enums\HttpCode;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Enums\Verbs;
use Exception;

class EmailTest extends AbstractFunctionalTest
{
    /**
     * @throws Exception
     */
    public function testSendEmail(
    ): void
    {
        $response = self::call(
            request: new Data(
                verb: Verbs::Post,
                endpoint: '/modelemail',
            )
        );

        self::assertEquals(
            expected: HttpCode::Created,
            actual: $response->getHttpCode(),
        );
    }
}