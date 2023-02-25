<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\EntryPoint\Cli\FindStory;

use App\Network\Story\Application\FindStoryById\FindStoryByIdQuery;
use App\Shared\Domain\Bus\Query\QueryBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class FindStoryCommand extends Command
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
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $result = $this->bus->handle(FindStoryByIdQuery::create('12344'));
        var_dump($result);
        // ... put here the code to create the user

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}
