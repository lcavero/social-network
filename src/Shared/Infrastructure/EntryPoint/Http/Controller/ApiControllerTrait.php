<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\EntryPoint\Http\Controller;

use App\Shared\Infrastructure\EntryPoint\Http\Exception\BadRequestHttpException;
use App\Shared\Infrastructure\EntryPoint\Http\Request\RequestValidator;
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
}
