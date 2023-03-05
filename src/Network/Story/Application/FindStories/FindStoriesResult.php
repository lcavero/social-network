<?php declare(strict_types=1);

namespace App\Network\Story\Application\FindStories;

final readonly class FindStoriesResult
{
    private function __construct(public array $data, public int $total)
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['data'],
            $data['total'],
        );
    }
}
