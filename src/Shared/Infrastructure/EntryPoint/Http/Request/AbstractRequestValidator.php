<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\EntryPoint\Http\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractRequestValidator
{
    public function __construct(protected ValidatorInterface $validator)
    {
    }

    protected function queryConstraints(): Collection
    {
        return new Collection(['fields' => []]);
    }

    protected function requestConstraints(): Collection
    {
        return new Collection(['fields' => []]);
    }

    protected function routeParamConstraints(): Collection
    {
        return new Collection(['fields' => []]);
    }

    public function validate(Request $request): ConstraintViolationListInterface
    {
        $errors = $this->validator->validate($request->query->all(), $this->queryConstraints());
        $errors->addAll($this->validator->validate($request->request->all(), $this->requestConstraints()));
        $errors->addAll($this->validator->validate($request->attributes->get('_route_params'), $this->routeParamConstraints()));
        return $errors;
    }
}
