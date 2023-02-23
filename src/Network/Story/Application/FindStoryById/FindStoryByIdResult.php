<?php declare(strict_types=1);

namespace App\Network\Story\Application\FindStoryById;

final readonly class FindStoryByIdResult
{
    private function __construct(public string $id, public string $title, public string $description)
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['title'],
            $data['description']
        );
    }

    public function render(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description
        ];
    }
}
