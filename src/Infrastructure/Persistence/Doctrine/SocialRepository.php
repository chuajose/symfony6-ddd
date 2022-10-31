<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Post\Model\Post;
use App\Domain\Social\Model\Social;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

class SocialRepository implements \App\Domain\Social\SocialRepository
{

    private const ENTITY = Social::class;
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }


    public function save(Social $post): void
    {

        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    public function find(UuidInterface $id): ?Social
    {
        return $this->entityManager->find(self::ENTITY, $id->toString());
    }

    public function search(): array
    {
        $limit = 100;

        $page = 1;

        $query = $this->entityManager->createQueryBuilder()
            ->select('i')
            ->from(self::ENTITY, 'i')
            ->orderBy('i.created_at', 'DESC');


        $querySentences = new DoctrineSentences($query, []);

        $query = $querySentences->getQuery();
        $paginator = new Paginator();
        $pagination = $paginator->paginate($query,
            $page,
            $limit);

        return [$pagination, $paginator->getCount()];
    }
}