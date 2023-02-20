<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\EntryPoint\Http\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ApiCreatedResponse extends JsonResponse
{
    public static function create(): self
    {
        return new self(['status' => Response::HTTP_CREATED, 'message' => 'ok'], Response::HTTP_CREATED);
    }
}
