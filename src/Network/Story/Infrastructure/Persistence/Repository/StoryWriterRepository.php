<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\Persistence\Repository;

use App\Network\Story\Domain\Exception\StoryNotFoundException;
use App\Network\Story\Domain\Repository\StoryWriterRepositoryInterface;
use App\Network\Story\Domain\Story;
use App\Network\Story\Domain\StoryId;
use App\Shared\Domain\Exception\LogicException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class StoryWriterRepository extends ServiceEntityRepository implements StoryWriterRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Story::class);
    }

    public function findById(StoryId $storyId): ?Story
    {
        $entity = $this->find($storyId->value);
        if (null !== $entity && !$entity instanceof Story) {
            throw LogicException::create(sprintf('Null or Story expected, %s received', gettype($entity)));
        }

        return $entity;
    }

    public function findByIdOrFail(StoryId $storyId): Story
    {
        $entity = $this->find($storyId->value);
        if (null === $entity) {
            throw StoryNotFoundException::fromId($storyId);
        }
        if (!$entity instanceof Story) {
            throw LogicException::create(sprintf('Null or Story expected, %s received', gettype($entity)));
        }

        return $entity;
    }

    public function save(Story $story): void
    {
        $this->getEntityManager()->persist($story);
        $this->getEntityManager()->flush();
    }
}
