<?php declare(strict_types=1);

namespace App\Network\Story\Domain;

use App\Shared\Domain\VO\String\StringValueObject;

final readonly class StoryTitle extends StringValueObject
{
    const MIN = 3;
    const MAX = 60;
}
