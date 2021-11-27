<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Tests\Functional;

use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\AbstractFunctionalTest;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Abstracts\Data;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Enums\HttpCode;
use CarloNicora\Minimalism\Minimalism13Test\Tests\Enums\Verbs;
use Exception;

class RabbitTest extends AbstractFunctionalTest
{
    /**x
     * @throws Exception
     */
    public function testPost(
    ): void
    {
        $response = self::call(
            request: new Data(
                verb: Verbs::Post,
                endpoint: '/modelrabbit/myQueue/myMessage',
            )
        );

        self::assertEquals(
            expected: HttpCode::Created,
            actual: $response->getHttpCode(),
        );
    }

    /**
     * @depends testPost
     * @throws Exception
     */
    public function testQueue(
    ):void
    {
        self::assertEquals(
            expected: 1,
            actual: self::createRabbitMQ()->countMessagesInQueue('myQueue')
        );
    }
}