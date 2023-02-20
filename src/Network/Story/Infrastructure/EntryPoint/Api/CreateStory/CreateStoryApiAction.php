<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\EntryPoint\Api\CreateStory;

use App\Network\Story\Application\CreateStory\CreateStoryCommand;
use App\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Shared\Infrastructure\EntryPoint\Http\Controller\ControllerInterface;
use App\Shared\Infrastructure\EntryPoint\Http\Response\ApiCreatedResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

final readonly class CreateStoryApiAction implements ControllerInterface
{
    public function __construct(private CommandBusInterface $bus)
    {
    }

    public function __invoke(): JsonResponse
    {
        $this->bus->dispatch(CreateStoryCommand::create('hola', 'adios'));
        return ApiCreatedResponse::create();
    }
}
