<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Factories;

use CarloNicora\Minimalism\Services\Cacher\Builders\CacheBuilder;
use CarloNicora\Minimalism\Services\Cacher\Factories\CacheBuilderFactory;

class CacheFactory extends CacheBuilderFactory
{
    /**
     * @param int $userId
     * @return CacheBuilder
     */
    public function user(
        int $userId
    ): CacheBuilder
    {
        return $this->create(
            'userId',
            $userId
        );
    }

}