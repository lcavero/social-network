<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\EntryPoint\Api;

use App\Network\Story\Application\CreateStory\CreateStoryCommand;
use App\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Shared\Infrastructure\EntryPoint\Api\Controller\ApiController;
use App\Shared\Infrastructure\EntryPoint\Api\Controller\ControllerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

final readonly class CreateStoryApiAction implements ControllerInterface
{
    public function __construct(private ApiController $apiController, private CommandBusInterface $bus)
    {
    }

    public function __invoke(): JsonResponse
    {
        $this->bus->dispatch(CreateStoryCommand::create('hola', 'adios'));
        return $this->apiController->json('ok', 201);
    }
}
