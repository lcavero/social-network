<?php declare(strict_types=1);

namespace App\Network\Story\Application\FindStory;

use App\Shared\Domain\Bus\Query\QueryHandlerInterface;
use Symfony\Component\HttpFoundation\Request;

final readonly class FindStoryQueryHandler implements QueryHandlerInterface
{
    public function __construct()
    {
    }

    public function __invoke(FindStoryQuery $query): FindStoryResult
    {
        return FindStoryResult::fromArray([
            'title' => 'dummyTitle',
            'description' => 'dummyDescription'
        ]);
    }
}
