<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Services\Slack\Objects\SlackMessage;
use CarloNicora\Minimalism\Services\Slack\Slack;
use GuzzleHttp\Exception\GuzzleException;

class ModelSlack extends AbstractModel
{
    /**
     * @param Slack $slack
     * @return int
     * @throws GuzzleException
     */
    public function post(
        Slack $slack,
    ): int
    {
        $message = new SlackMessage(
            text: 'this is a simple slack message'
        );

        $slack->sendSlackMessage(
            message: $message,
            channel: 'private-carlo',
        );
        return 201;
    }
}