<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Builders;

use CarloNicora\Minimalism\Services\Builder\Abstracts\AbstractResourceBuilder;
use Exception;

class BookBuilder extends AbstractResourceBuilder
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
        $this->response->id = $this->encrypter->encryptId($data['bookId']);
        $this->response->attributes->add('title', $data['title']);
    }
}