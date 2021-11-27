<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Data;

use CarloNicora\Minimalism\Factories\ObjectFactory;
use CarloNicora\Minimalism\Services\DataMapper\Abstracts\AbstractDataObject;

class User extends AbstractDataObject
{
    /**
     * @param ObjectFactory $objectFactory
     * @param array|null $data
     * @param int|null $levelOfChildrenToLoad
     * @param int|null $id
     * @param string|null $email
     */
    public function __construct(
        ObjectFactory $objectFactory,
        ?array $data = null,
        ?int $levelOfChildrenToLoad = 0,
        private ?int $id=null,
        private ?string $email=null,
    )
    {
        parent::__construct(
            $objectFactory,
            $data,
            $levelOfChildrenToLoad,
        );
    }

    /**
     * @param array $data
     */
    public function import(
        array $data,
    ): void
    {
        $this->id = $data['userId'];
        $this->email = $data['email'];
    }

    /**
    * @return array
    */
    public function export(
    ): array
    {
        $originalValues = parent::export();

        $data = [
            'userId' => $this->id,
            'email' => $this->email,
        ];

        return array_merge($originalValues, $data);
    }

    /**
     * @return int
     */
    public function getId(
    ): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(
    ): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(
        string $email,
    ): void
    {
        $this->email = $email;
    }
}