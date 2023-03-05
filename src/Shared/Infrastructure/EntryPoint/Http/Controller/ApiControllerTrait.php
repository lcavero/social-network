<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\EntryPoint\Http\Controller;

use App\Shared\Infrastructure\EntryPoint\Http\Exception\BadRequestHttpException;
use App\Shared\Infrastructure\EntryPoint\Http\Request\RequestValidator;
use App\Shared\Infrastructure\EntryPoint\Http\Response\ApiJsonResponse;
use App\Shared\Infrastructure\EntryPoint\Http\Response\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

trait ApiControllerTrait
{
    private function validateRequest(Request $request, RequestValidator $validator): void
    {
        $errors = $validator->validate($request);

        if ($errors->count() > 0) {
            throw BadRequestHttpException::fromConstraintViolationList($errors);
        }
    }

    private function jsonResponse(ApiResponse $apiJsonResponse): JsonResponse
    {
        return ApiJsonResponse::fromApiResponse($apiJsonResponse);
    }

    private function requestPagination(Request $request): PaginationMapper
    {
        return PaginationMapper::map(
            null !== $request->query->get('page') ? (int) $request->query->get('page') : null,
            null !== $request->query->get('per_page') ? (int) $request->query->get('per_page') : null,
        );
    }
}
