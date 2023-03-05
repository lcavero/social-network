<?php declare(strict_types=1);

namespace App\Network\Story\Application\FindStories;

use App\Shared\Domain\Bus\Query\Query;

final readonly class FindStoriesQuery implements Query
{
    private function __construct(public int $limit, public int $offset)
    {
    }

    public static function create(int $limit, int $offset): self
    {
        return new self($limit, $offset);
    }
}
