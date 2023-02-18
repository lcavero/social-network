<?php declare(strict_types=1);

namespace App\Network\Story\Application\FindStory;

use App\Shared\Domain\Bus\Query\QueryHandlerInterface;

final readonly class FindStoryQueryHandler implements QueryHandlerInterface
{
    public function __invoke(FindStoryQuery $query): string
    {
        return 'eeey';
    }
}
