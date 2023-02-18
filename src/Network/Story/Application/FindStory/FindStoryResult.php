<?php declare(strict_types=1);

namespace App\Network\Story\Application\FindStory;

final readonly class FindStoryResult
{
    private function __construct(public string $title, public string $description)
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['title'],
            $data['description']
        );
    }
}
