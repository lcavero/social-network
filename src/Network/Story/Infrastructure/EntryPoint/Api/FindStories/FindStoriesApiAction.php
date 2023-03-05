<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\EntryPoint\Api\FindStories;

use App\Network\Story\Application\FindStories\FindStoriesQuery;
use App\Network\Story\Application\FindStories\FindStoriesResult;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Domain\EntryPoint\Api\ApiController;
use App\Shared\Infrastructure\EntryPoint\Http\Controller\ApiControllerTrait;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final readonly class FindStoriesApiAction implements ApiController
{
    use ApiControllerTrait;

    public function __construct(private QueryBus $bus, private FindStoriesApiRequestValidator $requestValidator)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->validateRequest($request, $this->requestValidator);

        $pagination = $this->requestPagination($request);

        $result = $this->bus->handle(FindStoriesQuery::create(
            $pagination->limit,
            $pagination->offset
        ));

        assert($result instanceof FindStoriesResult);

        $response = FindStoriesApiResponse::create(
            $result->data,
            $pagination->page(),
            $pagination->perPage(),
            $result->total
        );

        return $this->jsonResponse($response);
    }
}
