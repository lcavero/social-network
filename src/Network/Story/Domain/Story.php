<?php declare(strict_types=1);

namespace App\Network\Story\Domain;

final readonly class Story
{
    private string $id;

    private function __construct(
        StoryId $id,
        private StoryTitle $title,
        private StoryDescription $description
    ) {
        $this->id = $id->value;
    }

    public static function create(
        StoryId $id,
        StoryTitle $title,
        StoryDescription $description
    ): self {
        return new self($id, $title, $description);
    }

    public function id(): StoryId
    {
        return StoryId::fromString($this->id);
    }

    public function title(): StoryTitle
    {
        return $this->title;
    }

    public function description(): StoryDescription
    {
        return $this->description;
    }
}
