<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Builders;

use CarloNicora\JsonApi\Objects\Link;
use CarloNicora\Minimalism\Interfaces\Data\Interfaces\DataFunctionInterface;
use CarloNicora\Minimalism\Interfaces\Data\Objects\DataFunction;
use CarloNicora\Minimalism\Minimalism13Test\Readers\BookReader;
use CarloNicora\Minimalism\Services\Builder\Abstracts\AbstractResourceBuilder;
use CarloNicora\Minimalism\Services\Builder\Objects\RelationshipBuilder;
use Exception;

class UserBuilder extends AbstractResourceBuilder
{
    /** @var string  */
    public string $type = 'album';

    /**
     * @param array $data
     * @throws Exception
     */
    public function setAttributes(
        array $data
    ): void
    {
        $this->response->id = $this->encrypter->encryptId($data['userId']);
        $this->response->attributes->add('email', $data['email']);
    }

    /**
     * @param array $data
     * @throws Exception
     */
    public function setLinks(
        array $data
    ): void
    {
        $this->response->links->add(
            new Link(
                'self',
                $this->path->getUrl()
                . 'modeluserbuilder/'
                . $this->encrypter->encryptId($data['userId'])
            )
        );
    }

    /**
     * @return array|null
     */
    public function getRelationshipReaders(): ?array
    {
        $response = [];

        /** @see BookReader::loadByUserId() */
        $response[] = new RelationshipBuilder(
            name: 'Books',
            builderClassName: BookBuilder::class,
            function: new DataFunction(
                type: DataFunctionInterface::TYPE_LOADER,
                className: BookReader::class,
                functionName: 'loadByUserId',
                parameters: ['userId']
            )
        );

        return $response;
    }
}