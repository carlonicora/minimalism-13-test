<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Enums\HttpCode;
use Exception;

class Parameter extends AbstractModel
{
    /**
     * @param string $name
     * @return HttpCode
     * @throws Exception
     */
    public function get(
        string $name,
    ): HttpCode
    {
        $this->document->meta->add('name', $name);
        return HttpCode::Ok;
    }
}