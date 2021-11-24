<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Functional;

use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\AbstractFunctionalTest;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\Data;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Enums\HttpCode;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Enums\Verbs;
use Exception;

class EncryptedParametersTest extends AbstractFunctionalTest
{
    /**
     * @throws Exception
     */
    public function testGet(
    ): void
    {
        $encrypter = self::createEncrypter();
        $id = $encrypter->encryptId(1);
        $name = $encrypter->encryptId(2);

        $response = self::call(
            request: new Data(
                verb: Verbs::Get,
                endpoint: '/modelencryptedparameters/' . $id . '/?name=' . $name,
            )
        );

        self::assertEquals(
            expected: HttpCode::Ok,
            actual: $response->getHttpCode(),
        );
    }
}