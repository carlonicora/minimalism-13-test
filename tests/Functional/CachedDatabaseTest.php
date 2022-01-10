<?php

namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Functional;

use CarloNicora\Minimalism\Enums\HttpCode;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\AbstractFunctionalTest;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\Data;

use CarloNicora\Minimalism\Minimalism13Test\Tests\Enums\Verbs;
use Exception;

class CachedDatabaseTest extends AbstractFunctionalTest
{
    /**
     * @throws Exception
     */
    public function testGet(
    ): void
    {
        $id = self::createEncrypter()->encryptId(1);

        $response = self::call(
            request: new Data(
                verb: Verbs::Get,
                endpoint: '/modelcacheddatabase/' . $id,
            )
        );

        self::assertEquals(
            expected: HttpCode::Ok,
            actual: $response->getHttpCode(),
        );
    }
}