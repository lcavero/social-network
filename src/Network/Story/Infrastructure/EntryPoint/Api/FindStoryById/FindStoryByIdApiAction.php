<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\EntryPoint\Api\FindStoryById;

use App\Network\Story\Application\FindStoryById\FindStoryByIdQuery;
use App\Network\Story\Application\FindStoryById\FindStoryByIdResult;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Domain\EntryPoint\Api\ApiController;
use App\Shared\Infrastructure\EntryPoint\Http\Controller\ApiControllerTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class FindStoryByIdApiAction implements ApiController
{
    use ApiControllerTrait;

    public function __construct(private QueryBus $bus, private FindStoryByIdApiRequestValidator $requestValidator)
    {
    }

    public function __invoke(string $storyId, Request $request): JsonResponse
    {
        $this->validateRequest($request, $this->requestValidator);

        $result = $this->bus->handle(FindStoryByIdQuery::create($storyId));

        if (null === $result) {
            throw new NotFoundHttpException(sprintf('Story with id "%s" was not found', $storyId));
        }

        assert( $result instanceof FindStoryByIdResult);

        $response = FindStoryByIdApiResponse::create(
            $result->id,
            $result->title,
            $result->description
        );

        return $this->jsonResponse($response);
    }
}
