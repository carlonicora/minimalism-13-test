<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Functional;

use CarloNicora\JsonApi\Document;
use CarloNicora\JsonApi\Objects\ResourceObject;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\AbstractFunctionalTest;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\Data;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Enums\HttpCode;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Enums\Verbs;
use Exception;

class DatabaseTest extends AbstractFunctionalTest
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
                endpoint: '/modeldatabase/' . $id,
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

    /**
     * @throws Exception
     */
    public function testGetFailsWrongId(
    ): void
    {
        $id = self::createEncrypter()->encryptId(2);

        $response = self::call(
            request: new Data(
                verb: Verbs::Get,
                endpoint: '/modeldatabase/' . $id,
            )
        );

        self::assertEquals(
            expected: HttpCode::NotFound,
            actual: $response->getHttpCode(),
        );
    }

    /**
     * @return Document[]
     * @throws Exception
     */
    public function userPostData(
    ): array
    {
        $response = [];

        $documentErrorWrongType = new Document();
        $resourceErrorWrongType = new ResourceObject(type:'wrong');
        $documentErrorWrongType->addResource($resourceErrorWrongType);
        $response[] = [
            HttpCode::ValidationFailed,
            $documentErrorWrongType,
        ];

        $documentErrorMissingEmail = new Document();
        $resourceErrorMissingEmail = new ResourceObject(type:'user');
        $documentErrorMissingEmail->addResource($resourceErrorMissingEmail);
        $response[] = [
            HttpCode::ValidationFailed,
            $documentErrorMissingEmail,
        ];

        $documentErrorTooManyResources = new Document();
        $resourceErrorTooManyResources = new ResourceObject(type:'user');
        $documentErrorTooManyResources->addResource($resourceErrorTooManyResources);
        $documentErrorTooManyResources->addResource($resourceErrorTooManyResources);
        $response[] = [
            HttpCode::ValidationFailed,
            $documentErrorTooManyResources,
        ];

        $documentCorrect = new Document();
        $resourceCorrect = new ResourceObject(type:'user', id:self::createEncrypter()->encryptId(2));
        $resourceCorrect->attributes->add('email', microtime() . '@email.com');
        $documentCorrect->addResource($resourceCorrect);
        $response[] = [
            HttpCode::Created,
            $documentCorrect,
        ];

        return $response;
    }

    /**
     * @throws Exception
     *
     * @dataProvider userPostData
     */
    public function testPost(
        HttpCode $result,
        Document $document,
    ): void
    {
        $response = self::call(
            request: new Data(
                verb: Verbs::Post,
                endpoint: '/modeldatabase',
                body: $document->prepare()
            )
        );

        self::assertEquals(
            expected: $result,
            actual: $response->getHttpCode(),
        );
    }

    /**
     * @throws Exception
     *
     * @depends testPost
     * @dataProvider userPostData
     */
    public function testPatch(
        HttpCode $result,
        Document $document,
    ): void
    {
        if ($result === HttpCode::Created)  {
            $result = HttpCode::Ok;
        }

        $response = self::call(
            request: new Data(
                verb: Verbs::Patch,
                endpoint: '/modeldatabase',
                body: $document->prepare()
            )
        );

        self::assertEquals(
            expected: $result,
            actual: $response->getHttpCode(),
        );
    }
}