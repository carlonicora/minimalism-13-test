<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Models;

use CarloNicora\Minimalism\Abstracts\AbstractModel;
use CarloNicora\Minimalism\Services\Auth\Auth;
use Exception;
use RuntimeException;

class ModelSecurity extends AbstractModel
{
    /**
     * @param Auth $auth
     * @return int
     * @throws Exception
     */
    public function get(
        Auth $auth,
    ): int
    {
        if (($token = $auth->getToken()) === null){
            throw new RuntimeException('Unauthorised', 401);
        }

        if (!$auth->isSignatureValid()) {
            throw new RuntimeException('Unauthorised', 401);
        }

        $userId = $auth->getUserId();

        return 200;
    }
}