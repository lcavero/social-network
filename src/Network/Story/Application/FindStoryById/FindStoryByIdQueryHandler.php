<?php declare(strict_types=1);

namespace App\Network\Story\Application\FindStoryById;

use App\Network\Story\Application\FindStoryById\DataQuery\StoryByIdDataQueryInterface;
use App\Shared\Domain\Bus\Query\QueryHandlerInterface;

final readonly class FindStoryByIdQueryHandler implements QueryHandlerInterface
{
    public function __construct(private StoryByIdDataQueryInterface $storyByIdDataQuery)
    {
    }

    public function __invoke(FindStoryByIdQuery $query): FindStoryByIdResult
    {
        $story = $this->storyByIdDataQuery->execute($query->id);
        assert(null !== $story);

        return FindStoryByIdResult::fromArray($story);
    }
}
