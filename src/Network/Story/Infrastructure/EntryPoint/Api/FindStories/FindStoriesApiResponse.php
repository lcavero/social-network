<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\EntryPoint\Api\FindStories;

use App\Shared\Infrastructure\EntryPoint\Http\Response\AbstractApiFindPaginatedResponse;

final readonly class FindStoriesApiResponse extends AbstractApiFindPaginatedResponse
{
    public function data(): array
    {
        return array_map([$this, 'renderData'], $this->data);
    }

    private function renderData(array $data): array
    {
        return [
            'id' => $data['id'],
            'title' => $data['title']
        ];
    }
}
