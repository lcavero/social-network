<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\EntryPoint\Http\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractRequestValidator implements RequestValidator
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
        if ('' !== $request->getContent()) {
            $errors->addAll($this->validator->validate($request->toArray(), $this->requestConstraints()));
        }
        $errors->addAll($this->validator->validate($request->attributes->get('_route_params'), $this->routeParamConstraints()));
        return $errors;
    }

    protected function addPaginationConstraints(Collection $collection): Collection
    {
        return new Collection([
            'fields' => [
                ...[
                    'page' => new Assert\Optional(
                        new Assert\Sequentially([
                            new Assert\Type('integer'),
                            new Assert\Positive()
                        ]),
                    ),
                    'per_page' => new Assert\Optional(
                        new Assert\Sequentially([
                            new Assert\Type('integer'),
                            new Assert\Positive()
                        ]),
                    ),
                ],
                ...$collection->fields
            ]
        ]);
    }
}
