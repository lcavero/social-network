<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\Persistence\ORM\Repository;

use App\Network\Story\Domain\Exception\StoryNotFoundException;
use App\Network\Story\Domain\Persistence\StoryPersistenceRepository;
use App\Network\Story\Domain\Story;
use App\Network\Story\Domain\StoryId;
use App\Shared\Domain\Exception\LogicException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ORMStoryPersistenceRepository extends ServiceEntityRepository implements StoryPersistenceRepository
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
            throw StoryNotFoundException::fromId($storyId->value);
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
