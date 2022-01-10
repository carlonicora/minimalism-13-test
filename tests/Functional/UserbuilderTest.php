<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Functional;

use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\AbstractFunctionalTest;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\Data;
use CarloNicora\Minimalism\Enums\HttpCode;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Enums\Verbs;
use Exception;

class UserbuilderTest extends AbstractFunctionalTest
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
                endpoint: '/modeluserbuilder/' . $id,
            )
        );

        self::assertEquals(
            expected: HttpCode::Ok,
            actual: $response->getHttpCode(),
        );

        self::assertEquals(
            expected: 'my@email.com',
            actual: $response->getDocument()->resources[0]->attributes->get('email'),
        );
    }
}