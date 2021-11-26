<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Functional;

use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\AbstractFunctionalTest;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\Data;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Enums\HttpCode;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Enums\Verbs;
use Exception;

class DataMapperTest extends AbstractFunctionalTest
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
                endpoint: '/modeldatamapper/' . $id,
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