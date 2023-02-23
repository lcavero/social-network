<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\EntryPoint\Http\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;

interface RequestValidatorInterface
{
    public function validate(Request $request): ConstraintViolationListInterface;
}
