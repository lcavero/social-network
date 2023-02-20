<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\EntryPoint\Http\Response;

use App\Shared\Infrastructure\EntryPoint\Http\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

final class ApiErrorResponse extends JsonResponse
{
    public static function create(): self
    {
        return new self(['status' => Response::HTTP_INTERNAL_SERVER_ERROR, 'message' => 'Unexpected error. Please try again later.'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public static function fromHttpException(HttpExceptionInterface $exception): self
    {
        return new self(['status' => $exception->getStatusCode(), 'message' => $exception->getMessage()], $exception->getStatusCode(), $exception->getHeaders());
    }

    public static function fromBadRequestHttpException(BadRequestHttpException $exception): self
    {
        return new self(['status' => $exception->getStatusCode(), 'message' => $exception->getMessage(), 'errors' => $exception->errors()], $exception->getStatusCode(), $exception->getHeaders());
    }
}
