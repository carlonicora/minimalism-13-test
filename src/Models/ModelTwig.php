<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\JsonApi\Objects\ResourceObject;
use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Enums\HttpCode;
use Exception;

class ModelTwig extends AbstractModel
{
    /**
     * @var string|null
     */
    protected ?string $view='twig';

    /**
     * @return HttpCode
     * @throws Exception
     */
    public function get(
    ): HttpCode
    {
        $this->document->addResource(new ResourceObject('twig', 1));

        return HttpCode::Ok;
    }
}