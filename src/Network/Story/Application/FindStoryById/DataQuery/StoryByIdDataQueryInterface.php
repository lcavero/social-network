<?php declare(strict_types=1);

namespace App\Network\Story\Application\FindStoryById\DataQuery;

interface StoryByIdDataQueryInterface
{
    public function execute(string $id): ?array;
}
