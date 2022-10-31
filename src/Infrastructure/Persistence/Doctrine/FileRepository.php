<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\File\Model\File;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

class FileRepository implements \App\Domain\File\Repository\FileRepository
{

    private const ENTITY = File::class;
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }


    public function save(File $file): void
    {

        $this->entityManager->persist($file);
        $this->entityManager->flush();
    }

    public function find(UuidInterface $id): ?File
    {

        return $this->entityManager->find(self::ENTITY, $id->toString());
    }
}