<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Services\RabbitMq\RabbitMq;
use CarloNicora\Minimalism\Parameters\PositionedParameter;
use Exception;

class ModelRabbit extends AbstractModel
{
    /**
     * @param RabbitMq $rabbitMq
     * @param PositionedParameter $queueName
     * @param PositionedParameter $message
     * @return int
     * @throws Exception
     */
    public function post(
        RabbitMq            $rabbitMq,
        PositionedParameter $queueName,
        PositionedParameter $message,
    ): int
    {
        $rabbitMq->dispatchMessage(
            message: [$message->getValue()],
            queueName: $queueName->getValue(),
        );

        return 201;
    }
}