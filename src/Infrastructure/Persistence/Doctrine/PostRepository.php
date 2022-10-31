<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Post\Model\Post;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

class PostRepository implements \App\Domain\Post\PostRepository
{

    private const ENTITY = Post::class;
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }


    public function save(Post $post): void
    {

        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    public function find(UuidInterface $id): ?Post
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