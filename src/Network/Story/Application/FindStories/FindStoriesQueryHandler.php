<?php declare(strict_types=1);

namespace App\Network\Story\Application\FindStories;

use App\Network\Story\Domain\Search\StoriesPaginatedSearcher;
use App\Shared\Domain\Bus\Query\QueryHandler;

final readonly class FindStoriesQueryHandler implements QueryHandler
{
    public function __construct(private StoriesPaginatedSearcher $storiesPaginatedSearcher)
    {
    }

    public function __invoke(FindStoriesQuery $query): FindStoriesResult
    {
        $stories = $this->storiesPaginatedSearcher->execute($query->limit, $query->offset);

        return FindStoriesResult::fromArray($stories);
    }
}
