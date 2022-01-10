<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Enums\HttpCode;
use Exception;

class PositionedParameter extends AbstractModel
{
    /**
     * @param \CarloNicora\Minimalism\Parameters\PositionedParameter $name
     * @return HttpCode
     * @throws Exception
     */
    public function get(
        \CarloNicora\Minimalism\Parameters\PositionedParameter $name,
    ): HttpCode
    {
        $this->document->meta->add('name', $name->getValue());
        return HttpCode::Ok;
    }
}