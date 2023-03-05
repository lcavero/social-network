<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\EntryPoint\Http\Response;

use Symfony\Component\HttpFoundation\Response;

abstract readonly class AbstractApiFindResponse implements ApiResponse
{
    final public function status(): int
    {
       return Response::HTTP_OK;
    }

    public function metadata(): array
    {
        return [];
    }

    public function headers(): array
    {
        return [];
    }

    final public function message(): string
    {
        return 'ok';
    }

    final public function errors(): array
    {
        return [];
    }
}
