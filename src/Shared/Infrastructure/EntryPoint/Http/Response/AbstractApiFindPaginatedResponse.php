<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\EntryPoint\Http\Response;

abstract readonly class AbstractApiFindPaginatedResponse extends AbstractApiFindResponse
{
    private function __construct(public array $data, public int $page, public int $perPage, public int $total)
    {
    }

    public static function create(array $data, int $page, int $perPage, int $total): static
    {
        return new static($data, $page, $perPage, $total);
    }

    public function metadata(): array
    {
        return [
            'pagination' => [
                'page' => $this->page,
                'perPage' => $this->perPage,
                'total' => $this->total
            ]
        ];
    }
}
