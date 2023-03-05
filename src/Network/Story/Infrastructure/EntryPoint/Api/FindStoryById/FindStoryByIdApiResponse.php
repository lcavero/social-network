<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\EntryPoint\Api\FindStoryById;

use App\Shared\Infrastructure\EntryPoint\Http\Response\AbstractApiFindResponse;

final readonly class FindStoryByIdApiResponse extends AbstractApiFindResponse
{
    private function __construct(public string $id, public string $title, public string $description)
    {
    }

    public static function create(string $id, string $title, string $description): self
    {
        return new self($id, $title, $description);
    }

    public function data(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description
        ];
    }
}
