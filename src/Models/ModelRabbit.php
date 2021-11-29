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
     * @param string $queueName
     * @param string $message
     * @return int
     * @throws Exception
     */
    public function post(
        RabbitMq            $rabbitMq,
        string $queueName,
        string $message,
    ): int
    {
        $rabbitMq->dispatchMessage(
            message: [$message],
            queueName: $queueName,
        );

        return 201;
    }
}