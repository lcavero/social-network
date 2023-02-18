<?php declare(strict_types=1);

namespace App\Network\Story\Application\CreateStory;

use App\Shared\Domain\Bus\Command\CommandInterface;

final readonly class CreateStoryCommand implements CommandInterface
{
    private function __construct(public string $title, public string $description)
    {}

    public static function create(string $title, string $description): self
    {
        return new self($title, $description);
    }
}
