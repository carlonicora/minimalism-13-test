<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Objects;

use CarloNicora\Minimalism\Minimalism13Test\Abstracts\AbstractTestObject;

class TestObject extends AbstractTestObject
{
    /**
     * @param array|null $parameters
     */
    public function __construct(
        private ?array $parameters=null,
    )
    {
    }

    /**
     * @return int
     */
    public function countParameters(
    ): int
    {
        if ($this->parameters !== null){
            return count($this->parameters);
        }

        return 0;
    }
}