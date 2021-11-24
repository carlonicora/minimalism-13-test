<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Factories;

use CarloNicora\Minimalism\Interfaces\ObjectFactoryInterface;
use CarloNicora\Minimalism\Interfaces\ObjectInterface;

class TestObjectFactory implements ObjectFactoryInterface
{
    public function __construct(
    )
    {
    }

    /**
     * @param string $name
     * @param array|null $parameters
     * @return ObjectInterface
     */
    public function create(
        string $name,
        ?array $parameters = null,
    ): ObjectInterface
    {
        return new $name($parameters);
    }
}