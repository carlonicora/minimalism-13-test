<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use Exception;

class Parameter extends AbstractModel
{
    /**
     * @param string $name
     * @return int
     * @throws Exception
     */
    public function get(
        string $name,
    ): int
    {
        $this->document->meta->add('name', $name);
        return 200;
    }
}