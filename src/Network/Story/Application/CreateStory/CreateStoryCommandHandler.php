<?php declare(strict_types=1);

namespace App\Network\Story\Application\CreateStory;

use App\Shared\Domain\Bus\Command\CommandHandlerInterface;

final readonly class CreateStoryCommandHandler implements CommandHandlerInterface
{
    public function __invoke(CreateStoryCommand $command): void
    {
    }
}
