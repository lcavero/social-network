<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\Search\Dbal;

use App\Network\Story\Domain\Search\StoryByIdSearcher;
use App\Shared\Infrastructure\Search\Dbal\DbalQueryBuilderFactory;

final readonly class DbalStoryByIdSearcher implements StoryByIdSearcher
{
    public function __construct(private DbalQueryBuilderFactory $dbalQueryBuilderFactory)
    {
    }

    public function execute(string $id): ?array
    {
        $sql = "SELECT uuid as id, title, description FROM network_story where uuid = :id";

        return
            $this->dbalQueryBuilderFactory
                ->create()
                ->prepare($sql)
                ->bindValue('id', $id)
                ->getSingleResult()
            ;
    }
}
