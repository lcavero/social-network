<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\EntryPoint\Api\CreateStory;

use App\Network\Story\Application\CreateStory\CreateStoryCommand;
use App\Shared\Domain\Bus\Command\CommandBus;
use App\Shared\Domain\EntryPoint\Api\ApiController;
use App\Shared\Infrastructure\EntryPoint\Http\Controller\ApiControllerTrait;
use App\Shared\Infrastructure\EntryPoint\Http\Response\ApiCreatedResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

final readonly class CreateStoryApiAction implements ApiController
{
    use ApiControllerTrait;

    public function __construct(private CommandBus $bus, private CreateStoryApiRequestValidator $requestValidator)
    {
    }

    #[OA\Response(
        response: 201,
        description: 'Successful response',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'status', type: 'integer', example: 201),
                new OA\Property(property: 'message', type: 'string', example: 'ok')
            ],
            type: 'object'
        )
    )]
    public function __invoke(Request $request): JsonResponse
    {
        $this->validateRequest($request, $this->requestValidator);

        $body = $request->toArray();

        $this->bus->dispatch(CreateStoryCommand::create(
            $body['id'],
            $body['title'],
            $body['description']
        ));
        return ApiCreatedResponse::create();
    }
}
