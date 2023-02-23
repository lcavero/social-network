<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\EntryPoint\Http\EventListener;

use App\Shared\Infrastructure\EntryPoint\EntryPoint;
use App\Shared\Infrastructure\EntryPoint\Http\Exception\BadRequestHttpException;
use App\Shared\Infrastructure\EntryPoint\Http\Request\RequestEntrypointResolver;
use App\Shared\Infrastructure\EntryPoint\Http\Response\ApiErrorResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

final readonly class ApiExceptionListener
{
    public function __construct(private RequestEntrypointResolver $requestEntrypointResolver, private bool $debug)
    {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        if (EntryPoint::API !== $this->requestEntrypointResolver->resolve($event->getRequest())) {
            return;
        }

        $exception = $event->getThrowable();

        if ($exception instanceof BadRequestHttpException) {
            $response = ApiErrorResponse::fromBadRequestHttpException($exception);
        } else if ($exception instanceof HttpExceptionInterface) {
            $response = ApiErrorResponse::fromHttpException($exception);
        } else {
            $response = ApiErrorResponse::create();
        }

        if ($this->debug) {
            $content = $response->getContent();
            assert(false !== $content);
            $content = json_decode($content, true);
            assert(is_array($content));

            $content['exception'] = get_class($exception);
            $content['exceptionMessage'] = $exception->getMessage();
            $content['exceptionFile'] = $exception->getFile();
            $content['exceptionLine'] = $exception->getLine();
            $content['trace'] = $exception->getTrace();

            $content = json_encode($content, $response->getEncodingOptions());
            assert(false !== $content);
            $response->setContent($content);
        }

        $event->setResponse($response);
    }
}
