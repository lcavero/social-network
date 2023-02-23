<?php declare(strict_types=1);

namespace App\Network\Story\Application\CreateStory;

use App\Network\Story\Domain\Repository\StoryWriterRepositoryInterface;
use App\Network\Story\Domain\Story;
use App\Network\Story\Domain\StoryDescription;
use App\Network\Story\Domain\StoryId;
use App\Network\Story\Domain\StoryTitle;
use App\Shared\Domain\Bus\Command\CommandHandlerInterface;

final readonly class CreateStoryCommandHandler implements CommandHandlerInterface
{
    public function __construct(private StoryWriterRepositoryInterface $storyWriterRepository)
    {
    }

    public function __invoke(CreateStoryCommand $command): void
    {
        $story = Story::create(
            StoryId::fromString($command->id),
            StoryTitle::fromString($command->title),
            StoryDescription::fromString($command->description)
        );

        $this->storyWriterRepository->save($story);
    }
}
