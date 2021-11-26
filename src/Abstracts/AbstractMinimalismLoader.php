<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Abstracts;

use CarloNicora\Minimalism\Interfaces\Cache\Interfaces\CacheBuilderFactoryInterface;
use CarloNicora\Minimalism\Interfaces\ServiceInterface;
use CarloNicora\Minimalism\Minimalism13Test\Factories\CacheFactory;
use CarloNicora\Minimalism\Minimalism13Test\Test;
use CarloNicora\Minimalism\Services\DataMapper\Abstracts\AbstractLoader;

abstract class AbstractMinimalismLoader extends AbstractLoader
{
    /** @var CacheBuilderFactoryInterface|CacheFactory|null  */
    protected CacheBuilderFactoryInterface|CacheFactory|null $cacheFactory;

    /** @var ServiceInterface|Test|null  */
    protected ServiceInterface|Test|null $defaultService;
}