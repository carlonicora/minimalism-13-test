<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Functional;

use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\AbstractFunctionalTest;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\Data;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Database\TableData\Oauth\TokensData;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Enums\HttpCode;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Enums\Verbs;
use Exception;

class SecurityTest extends AbstractFunctionalTest
{
    /**x
     * @throws Exception
     */
    public function testGet(
    ): void
    {
        $response = self::call(
            request: new Data(
                verb: Verbs::Get,
                endpoint: '/modelsecurity',
                bearer: TokensData::Default->value,
            )
        );

        self::assertEquals(
            expected: HttpCode::Ok,
            actual: $response->getHttpCode(),
        );
    }
}