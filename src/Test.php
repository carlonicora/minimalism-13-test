<?php
namespace CarloNicora\Minimalism\Minimalism13Test;

use CarloNicora\Minimalism\Abstracts\AbstractService;
use CarloNicora\Minimalism\Interfaces\DefaultServiceInterface;
use CarloNicora\Minimalism\Minimalism13Test\Factories\CacheFactory;
use CarloNicora\Minimalism\Services\DataMapper\DataMapper;
use Exception;

class Test extends AbstractService implements DefaultServiceInterface
{
    /**
     * @param DataMapper $mapper
     */
    public function __construct(
        private DataMapper $mapper,
    )
    {
        parent::__construct();
    }

    /**
     *
     * @throws Exception
     */
    public function initialise(

    ): void
    {
        $this->mapper->setCacheFactory(new CacheFactory());
        $this->mapper->setDefaultService($this);
    }

    /**
     * @return array
     */
    public function getDelayedServices(
    ): array
    {
        return [];
    }

    /**
     * @return string|null
     */
    public function getApplicationUrl(
    ): ?string
    {
        return null;
    }

    /**
     * @return string|null
     */
    public function getApiUrl(
    ): ?string
    {
        return null;
    }
}