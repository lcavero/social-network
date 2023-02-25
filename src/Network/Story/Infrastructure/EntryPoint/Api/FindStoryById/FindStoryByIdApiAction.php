<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\EntryPoint\Api\FindStoryById;

use App\Network\Story\Application\FindStoryById\FindStoryByIdQuery;
use App\Network\Story\Application\FindStoryById\FindStoryByIdResult;
use App\Network\Story\Domain\Exception\StoryNotFoundException;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Domain\EntryPoint\Api\ApiController;
use App\Shared\Infrastructure\EntryPoint\Http\Controller\ApiControllerTrait;
use App\Shared\Infrastructure\EntryPoint\Http\Response\ApiFindResponse;
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

        try {
            $result = $this->bus->handle(FindStoryByIdQuery::create($storyId));
            assert( $result instanceof FindStoryByIdResult);
            return ApiFindResponse::create($result->render());
        } catch (StoryNotFoundException $e) {
            throw new NotFoundHttpException(sprintf('Story with id "%s" was not found', $storyId), $e);
        }

    }
}
