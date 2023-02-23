<?php declare(strict_types=1);

namespace App\Network\Story\Domain\Exception;

use App\Network\Story\Domain\StoryId;
use App\Shared\Domain\Exception\DomainException;

final class StoryNotFoundException extends DomainException
{
    public static function fromStoryId(StoryId $storyId): self
    {
        return new self(sprintf('Story with id %s was not found', $storyId->value));
    }

    public static function fromId(string $id): self
    {
        return new self(sprintf('Story with id %s was not found', $id));
    }
}
