<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\EntryPoint\Http\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface;

final class BadRequestHttpException extends HttpException
{
    private function __construct(public readonly ConstraintViolationListInterface $constraintViolationList)
    {
        parent::__construct(Response::HTTP_BAD_REQUEST, 'Bad Request.');
    }

    public static function fromConstraintViolationList(ConstraintViolationListInterface $constraintViolationList): self
    {
        return new self($constraintViolationList);
    }

    public function errors(): array
    {
        $errors = [];
        foreach ($this->constraintViolationList as $constraintViolation) {
            $errors[] = [
                'property' => $constraintViolation->getPropertyPath(),
                'message' => $constraintViolation->getMessage()
            ];
        }

        return $errors;
    }
}
