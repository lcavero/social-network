<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\EntryPoint\Api;

use App\Network\Story\Application\FindStory\FindStoryQuery;
use App\Network\Story\Application\FindStory\FindStoryResult;
use App\Shared\Domain\Bus\Query\QueryBusInterface;
use App\Shared\Infrastructure\EntryPoint\Api\Controller\ApiController;
use App\Shared\Infrastructure\EntryPoint\Api\Controller\ControllerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

final readonly class FindStoryApiAction implements ControllerInterface
{
    public function __construct(private ApiController $apiController, private QueryBusInterface $bus)
    {
    }

    public function __invoke(): JsonResponse
    {
        $result = $this->bus->handle(FindStoryQuery::create('1234'));
        assert( $result instanceof FindStoryResult);
        return $this->apiController->json($result);
    }
}
