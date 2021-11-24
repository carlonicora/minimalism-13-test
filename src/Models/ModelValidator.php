<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Minimalism13Test\Validators\TestValidator;

class ModelValidator extends AbstractModel
{
    /**
     * @param TestValidator $payload
     * @return int
     */
    public function post(
        TestValidator $payload,
    ): int
    {
        return 201;
    }
}