<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\EntryPoint\Http\EventListener;

use App\Shared\Infrastructure\EntryPoint\EntryPoint;
use App\Shared\Infrastructure\EntryPoint\Http\Exception\BadRequestHttpException;
use App\Shared\Infrastructure\EntryPoint\Http\Request\RequestEntrypointResolver;
use App\Shared\Infrastructure\EntryPoint\Http\Response\ApiErrorResponse;
use App\Shared\Infrastructure\EntryPoint\Http\Response\ApiErrorResponseFactory;
use App\Shared\Infrastructure\EntryPoint\Http\Response\ApiJsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

final readonly class ApiExceptionListener
{
    public function __construct(private bool $debug, private RequestEntrypointResolver $requestEntrypointResolver)
    {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        if (EntryPoint::API !== $this->requestEntrypointResolver->resolve($event->getRequest())) {
            return;
        }

        $exception = $event->getThrowable();

        if ($this->debug && !$exception instanceof HttpExceptionInterface) {
            return;
        }

        if ($exception instanceof BadRequestHttpException) {
            $response = ApiErrorResponse::fromBadRequestHttpException($exception);
        } else if ($exception instanceof HttpExceptionInterface) {
            $response = ApiErrorResponse::fromHttpException($exception);
        } else {
            $response = ApiErrorResponse::create();
        }
        $event->setResponse(ApiJsonResponse::fromApiResponse($response));
    }
}
