<?php declare(strict_types=1);

namespace App\Network\Story\Application\CreateStory;

use App\Network\Story\Domain\Persistence\StoryPersistenceRepository;
use App\Network\Story\Domain\Story;
use App\Network\Story\Domain\StoryDescription;
use App\Network\Story\Domain\StoryId;
use App\Network\Story\Domain\StoryTitle;
use App\Shared\Domain\Bus\Command\CommandHandler;

final readonly class CreateStoryCommandHandler implements CommandHandler
{
    public function __construct(private StoryPersistenceRepository $storyWriterRepository)
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
