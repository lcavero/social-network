<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\EntryPoint\Api\FindStoryById;

use App\Shared\Domain\VO\Uuid\UuidValueObject;
use App\Shared\Infrastructure\EntryPoint\Http\Request\AbstractRequestValidator;
use Symfony\Component\Validator\Constraints as Assert;

final class FindStoryByIdApiRequestValidator extends AbstractRequestValidator
{
    protected function routeParamConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'fields' => [
                'storyId' => new Assert\Sequentially([
                    new Assert\NotBlank(),
                    new Assert\Type('string'),
                    new Assert\Uuid(['versions' => [UuidValueObject::UUID_VERSION]])
                ])
            ]
        ]);
    }
}
