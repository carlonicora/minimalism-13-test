<?php
namespace CarloNicora\Minimalism\Minimalism13Test\Data;

use CarloNicora\Minimalism\Factories\ObjectFactory;
use CarloNicora\Minimalism\Minimalism13Test\Readers\UserReader;
use CarloNicora\Minimalism\Services\DataMapper\Abstracts\AbstractDataObject;
use Exception;

class Book extends AbstractDataObject
{
    /** @var User|null  */
    private ?User $author=null;

    /**
     * @param ObjectFactory $objectFactory
     * @param array|null $data
     * @param int|null $levelOfChildrenToLoad
     * @param int|null $id
     * @param int|null $userId
     * @param string|null $title
     * @throws Exception
     */
    public function __construct(
        ObjectFactory $objectFactory,
        ?array $data = null,
        ?int $levelOfChildrenToLoad = 0,
        private ?int $id=null,
        private ?int $userId=null,
        private ?string $title=null,
    )
    {
        parent::__construct(
            $objectFactory,
            $data,
            $levelOfChildrenToLoad,
        );

        $this->loadAuthor();
    }

    /**
     * @throws Exception
     */
    private function loadAuthor(
    ): void
    {
        if ($this->userId !== null){
            /** @var UserReader $readUser */
            $readUser = $this->objectFactory->createSimpleObject(
                className: UserReader::class,
            );
            $this->author = $readUser->loadById($this->userId);
        }
    }

    /**
     * @param array $data
     */
    public function import(
        array $data,
    ): void
    {
        $this->id = $data['bookId'];
        $this->userId = $data['userId'];
        $this->title = $data['title'];
    }

    /**
     * @return array
     */
    public function export(
    ): array
    {
        $originalValues = parent::export();

        $data = [
            'bookId' => $this->id,
            'userId' => $this->userId,
            'title' => $this->title,
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
     * @return int
     */
    public function getUserId(
    ): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     * @throws Exception
     */
    public function setUserId(
        int $userId,
    ): void
    {
        $this->userId = $userId;

        $this->loadAuthor();
    }

    /**
     * @return User
     */
    public function getAuthor(
    ): User
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getTitle(
    ): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(
        string $title,
    ): void
    {
        $this->title = $title;
    }
}