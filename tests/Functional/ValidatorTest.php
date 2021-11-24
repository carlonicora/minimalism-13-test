<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Functional;

use CarloNicora\JsonApi\Document;
use CarloNicora\JsonApi\Objects\ResourceObject;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\AbstractFunctionalTest;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\Data;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Enums\HttpCode;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Enums\Verbs;
use Exception;

class ValidatorTest extends AbstractFunctionalTest
{
    /**
     * @throws Exception
     */
    public function testPushFailsWrongType(
    ): void
    {
        $encrypter = self::createEncrypter();
        $document = new Document();
        $resource = new ResourceObject('wrongType', $encrypter->encryptId(1));
        $resource->attributes->add('name', 'name');
        $document->addResource($resource);

        $response = self::call(
            request: new Data(
                verb: Verbs::Post,
                endpoint: '/ModelValidator',
                body: $document->prepare()
            )
        );

        self::assertEquals(
            expected: HttpCode::ValidationFailed,
            actual: $response->getHttpCode(),
        );
    }

    /**
     * @throws Exception
     */
    public function testPushFailsMissingName(
    ): void
    {
        $encrypter = self::createEncrypter();
        $document = new Document();
        $resource = new ResourceObject('test', $encrypter->encryptId(1));
        $document->addResource($resource);

        $response = self::call(
            request: new Data(
                verb: Verbs::Post,
                endpoint: '/ModelValidator',
                body: $document->prepare()
            )
        );

        self::assertEquals(
            expected: HttpCode::ValidationFailed,
            actual: $response->getHttpCode(),
        );
    }

    /**
     * @throws Exception
     */
    public function testPushSucceed(
    ): void
    {
        $encrypter = self::createEncrypter();
        $document = new Document();
        $resource = new ResourceObject('test', $encrypter->encryptId(1));
        $resource->attributes->add('name', 'name');
        $document->addResource($resource);

        $response = self::call(
            request: new Data(
                verb: Verbs::Post,
                endpoint: '/ModelValidator',
                body: $document->prepare()
            )
        );

        self::assertEquals(
            expected: HttpCode::Created,
            actual: $response->getHttpCode(),
        );
    }
}