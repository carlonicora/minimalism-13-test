<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Enums\HttpCode;

class Index extends AbstractModel
{
    /**
     * @return HttpCode
     */
    public function get(
    ): HttpCode
    {
        return HttpCode::Ok;
    }
}