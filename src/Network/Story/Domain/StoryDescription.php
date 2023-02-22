<?php declare(strict_types=1);

namespace App\Network\Story\Domain;

use App\Shared\Domain\VO\String\StringValueObject;

final readonly class StoryDescription extends StringValueObject
{
    const MIN = 10;
    const MAX = 40;
}
