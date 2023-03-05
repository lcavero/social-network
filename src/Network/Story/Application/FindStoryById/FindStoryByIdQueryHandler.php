<?php declare(strict_types=1);

namespace App\Network\Story\Application\FindStoryById;

use App\Network\Story\Domain\Search\StoryByIdSearcher;
use App\Shared\Domain\Bus\Query\QueryHandler;

final readonly class FindStoryByIdQueryHandler implements QueryHandler
{
    public function __construct(private StoryByIdSearcher $storyByIdDataQuery)
    {
    }

    public function __invoke(FindStoryByIdQuery $query): ?FindStoryByIdResult
    {
        $story = $this->storyByIdDataQuery->execute($query->id);

        if (null === $story) {
            return null;
        }

        return FindStoryByIdResult::fromArray($story);
    }
}
