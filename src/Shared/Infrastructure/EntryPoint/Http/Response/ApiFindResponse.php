<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\EntryPoint\Http\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ApiFindResponse extends JsonResponse
{
    public static function create(array $data): self
    {
        return new self(['status' => Response::HTTP_OK, 'message' => 'ok', 'data' => $data], Response::HTTP_OK);
    }
}
