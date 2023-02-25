<?php declare(strict_types=1);

namespace App\Network\Story\Domain\Search;

interface StoryByIdSearcher
{
    public function execute(string $id): ?array;
}
