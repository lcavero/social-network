<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\EntryPoint\Http\Request;

use App\Shared\Infrastructure\EntryPoint\EntryPoint;
use Symfony\Component\HttpFoundation\Request;

final readonly class RequestEntrypointResolver
{
    public function resolve(Request $request): EntryPoint
    {
        if (str_starts_with($request->getPathInfo(), '/api/')) {
            return EntryPoint::API;
        }
        return EntryPoint::GUI;
    }
}
