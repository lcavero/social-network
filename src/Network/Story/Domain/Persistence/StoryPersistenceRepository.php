<?php declare(strict_types=1);

namespace App\Network\Story\Domain\Persistence;

use App\Network\Story\Domain\Story;
use App\Network\Story\Domain\StoryId;

interface StoryPersistenceRepository
{
    public function findById(StoryId $storyId): ?Story;
    public function findByIdOrFail(StoryId $storyId): Story;
    public function save(Story $story): void;
}
