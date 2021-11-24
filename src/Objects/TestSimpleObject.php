<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Objects;

use CarloNicora\Minimalism\Interfaces\SimpleObjectInterface;
use CarloNicora\Minimalism\Minimalism13Test\Test;

class TestSimpleObject implements SimpleObjectInterface
{
    public function __construct(
        Test $test,
        private string $name,
        private ?array $parameters=null,
    )
    {
    }

    public function shoutMyName(
    ): void
    {
        echo PHP_EOL . strtoupper($this->name) . PHP_EOL;
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