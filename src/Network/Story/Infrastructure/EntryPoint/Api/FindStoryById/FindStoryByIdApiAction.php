<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\EntryPoint\Api\FindStoryById;

use App\Network\Story\Application\FindStoryById\FindStoryByIdQuery;
use App\Network\Story\Application\FindStoryById\FindStoryByIdResult;
use App\Shared\Domain\Bus\Query\QueryBusInterface;
use App\Shared\Infrastructure\EntryPoint\Http\Controller\ControllerInterface;
use App\Shared\Infrastructure\EntryPoint\Http\Exception\BadRequestHttpException;
use App\Shared\Infrastructure\EntryPoint\Http\Response\ApiFindResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final readonly class FindStoryByIdApiAction implements ControllerInterface
{
    public function __construct(private QueryBusInterface $bus, private FindStoryByIdApiRequestValidator $requestValidator)
    {
    }

    public function __invoke(string $storyId, Request $request): JsonResponse
    {
        $errors = $this->requestValidator->validate($request);

        if ($errors->count() > 0) {
            throw BadRequestHttpException::fromConstraintViolationList($errors);
        }

        $result = $this->bus->handle(FindStoryByIdQuery::create($storyId));
        assert( $result instanceof FindStoryByIdResult);
        return ApiFindResponse::create($result->render());
    }
}
