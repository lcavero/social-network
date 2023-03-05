<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\EntryPoint\Api\CreateStory;

use App\Network\Story\Application\CreateStory\CreateStoryCommand;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\EntryPoint\Api\ApiController;
use App\Shared\Infrastructure\EntryPoint\Http\Controller\ApiControllerTrait;
use App\Shared\Infrastructure\EntryPoint\Http\Response\ApiCreatedResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final readonly class CreateStoryApiAction implements ApiController
{
    use ApiControllerTrait;

    public function __construct(private CommandBus $bus, private CreateStoryApiRequestValidator $requestValidator)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->validateRequest($request, $this->requestValidator);

        $body = $request->toArray();

        $this->bus->dispatch(CreateStoryCommand::create(
            $body['id'],
            $body['title'],
            $body['description']
        ));

        return $this->jsonResponse(ApiCreatedResponse::create());
    }
}
