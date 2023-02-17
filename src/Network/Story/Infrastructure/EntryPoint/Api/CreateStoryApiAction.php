<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\EntryPoint\Api;

use App\Shared\Infrastructure\EntryPoint\Api\Controller\ApiController;
use App\Shared\Infrastructure\EntryPoint\Api\Controller\ControllerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

final readonly class CreateStoryApiAction implements ControllerInterface
{
    public function __construct(private ApiController $apiController)
    {
    }

    public function __invoke(): JsonResponse
    {
        return $this->apiController->json('hi!');
    }
}
