<?php declare(strict_types=1);

namespace App\Network\Story\Application\FindStoryById;

use App\Shared\Domain\Bus\Query\Query;

final readonly class FindStoryByIdQuery implements Query
{
    private function __construct(public string $id)
    {
    }

    public static function create(string $id): self
    {
        return new self($id);
    }
}
