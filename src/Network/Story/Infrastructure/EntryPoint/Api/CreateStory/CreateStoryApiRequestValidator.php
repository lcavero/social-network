<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\EntryPoint\Api\CreateStory;

use App\Network\Story\Domain\StoryDescription;
use App\Network\Story\Domain\StoryTitle;
use App\Shared\Domain\VO\Uuid\UuidValueObject;
use App\Shared\Infrastructure\EntryPoint\Http\Request\AbstractRequestValidator;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateStoryApiRequestValidator extends AbstractRequestValidator
{
    protected function requestConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'fields' => [
                'id' => new Assert\Sequentially([
                    new Assert\NotBlank(),
                    new Assert\Type('string'),
                    new Assert\Uuid(['versions' => [UuidValueObject::UUID_VERSION]])
                ]),
                'title' => new Assert\Sequentially([
                    new Assert\NotBlank(),
                    new Assert\Type('string'),
                    new Assert\Length([
                        'min' => StoryTitle::MIN,
                        'max' => StoryTitle::MAX
                    ])
                ]),
                'description' => new Assert\Sequentially([
                    new Assert\NotBlank(),
                    new Assert\Type('string'),
                    new Assert\Length([
                        'min' => StoryDescription::MIN,
                        'max' => StoryDescription::MAX
                    ])
                ]),
            ]
        ]);
    }
}
