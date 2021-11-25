<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\JsonApi\Objects\ResourceObject;
use CarloNicora\Minimalism\Abstracts\AbstractModel;
use Exception;

class ModelTwig extends AbstractModel
{
    /**
     * @var string|null
     */
    protected ?string $view='twig';

    /**
     * @return int
     * @throws Exception
     */
    public function get(
    ): int
    {
        $this->document->addResource(new ResourceObject('twig', 1));

        return 200;
    }
}