<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\Persistence\DataQuery;

use App\Network\Story\Application\FindStoryById\DataQuery\StoryByIdDataQueryInterface;
use App\Shared\Infrastructure\Persistence\DataQuery\DataQueryBuilder;
use Doctrine\ORM\EntityManagerInterface;

final readonly class StoryByIdDataQuery implements StoryByIdDataQueryInterface
{
    public function __construct(private EntityManagerInterface $manager)
    {
    }

    public function execute(string $id): ?array
    {
        $sql = "SELECT uuid as id, title, description FROM network_story where uuid = :id";

        return
            DataQueryBuilder::create($this->manager)
                ->prepare($sql)
                ->bindValue('id', $id)
                ->getSingleResult()
            ;
    }
}
