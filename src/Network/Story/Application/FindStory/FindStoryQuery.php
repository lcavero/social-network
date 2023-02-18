<?php declare(strict_types=1);

namespace App\Network\Story\Application\FindStory;

use App\Shared\Domain\Bus\Query\QueryInterface;

final readonly class FindStoryQuery implements QueryInterface
{
    private function __construct(public string $id)
    {
    }

    public static function create(string $id): self
    {
        return new self($id);
    }
}
