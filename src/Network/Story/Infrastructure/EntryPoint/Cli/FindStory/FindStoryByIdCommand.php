<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\EntryPoint\Cli\FindStory;

use App\Network\Story\Application\FindStoryById\FindStoryByIdQuery;
use App\Network\Story\Application\FindStoryById\FindStoryByIdResult;
use App\Network\Story\Domain\Exception\StoryNotFoundException;
use App\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class FindStoryByIdCommand extends Command
{
    public function __construct(private readonly QueryBus $bus)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('app:network:story:find')
            ->setHelp('This command allows you find a story')
            ->addArgument('storyId', InputArgument::REQUIRED, 'Story id (ej: 0f7429bb-2242-4868-81d5-f140560b317a)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $storyId = $input->getArgument('storyId');
        assert(is_string($storyId));

        try {
            $result = $this->bus->handle(FindStoryByIdQuery::create($storyId));
            assert($result instanceof FindStoryByIdResult);
            $output->writeln('ID: ' . $result->id);
            $output->writeln('Title: ' . $result->title);
            $output->writeln('Description: ' . $result->description);

            return Command::SUCCESS;

        } catch (StoryNotFoundException) {
            $output->writeln(sprintf('Story with id "%s" was not found', $storyId));
            return Command::FAILURE;
        }
    }
}
