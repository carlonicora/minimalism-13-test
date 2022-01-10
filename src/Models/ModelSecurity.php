<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Enums\HttpCode;
use CarloNicora\Minimalism\Services\Auth\Auth;
use Exception;
use RuntimeException;

class ModelSecurity extends AbstractModel
{
    /**
     * @param Auth $auth
     * @return HttpCode
     * @throws Exception
     */
    public function get(
        Auth $auth,
    ): HttpCode
    {
        /** @noinspection OnlyWritesOnParameterInspection */
        /** @noinspection PhpUnusedLocalVariableInspection */
        if (($token = $auth->getToken()) === null){
            throw new RuntimeException('Unauthorised', 401);
        }

        if (!$auth->isSignatureValid()) {
            throw new RuntimeException('Unauthorised', 401);
        }

        /** @noinspection PhpUnusedLocalVariableInspection */
        $userId = $auth->getUserId();

        return HttpCode::Ok;
    }
}