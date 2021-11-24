<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use Exception;

class PositionedParameter extends AbstractModel
{
    /**
     * @param \CarloNicora\Minimalism\Parameters\PositionedParameter $name
     * @return int
     * @throws Exception
     */
    public function get(
        \CarloNicora\Minimalism\Parameters\PositionedParameter $name,
    ): int
    {
        $this->document->meta->add('name', $name->getValue());
        return 200;
    }
}