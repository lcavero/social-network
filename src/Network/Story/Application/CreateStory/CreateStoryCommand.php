<?php declare(strict_types=1);

namespace App\Network\Story\Application\CreateStory;

use App\Shared\Domain\Bus\Command\Command;

final readonly class CreateStoryCommand implements Command
{
    private function __construct(public string $id, public string $title, public string $description)
    {
    }

    public static function create(string $id, string $title, string $description): self
    {
        return new self($id, $title, $description);
    }
}
