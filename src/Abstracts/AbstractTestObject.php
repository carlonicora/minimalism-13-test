<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Abstracts;

use CarloNicora\Minimalism\Interfaces\ObjectInterface;
use CarloNicora\Minimalism\Minimalism13Test\Factories\TestObjectFactory;

abstract class AbstractTestObject implements ObjectInterface
{
    /**
     * @return TestObjectFactory|string
     */
    final public function getObjectFactoryClass(
    ): TestObjectFactory|string
    {
        return TestObjectFactory::class;
    }
}