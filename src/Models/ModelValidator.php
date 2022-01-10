<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Enums\HttpCode;
use CarloNicora\Minimalism\Minimalism13Test\Validators\TestValidator;

class ModelValidator extends AbstractModel
{
    /**
     * @param TestValidator $payload
     * @return HttpCode
     * @noinspection PhpUnusedParameterInspection
     */
    public function post(
        TestValidator $payload,
    ): HttpCode
    {
        return HttpCode::Created;
    }
}