<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\EntryPoint\Http\Controller;

final readonly class PaginationMapper
{
    public const DEFAULT_ITEMS_PER_PAGE = 200;

    private function __construct(public int $limit, public int $offset)
    {}

    public static function map(?int $page, ?int $perPage): self
    {
        if (null === $perPage) {
            $perPage = self::DEFAULT_ITEMS_PER_PAGE;
        }

        if (null === $page) {
            $page = 1;
        }

        $offset = $perPage * ($page - 1);

        return new self($perPage, $offset);
    }

    public function perPage(): int
    {
        return $this->limit;
    }

    public function page(): int
    {
        return 1 + $this->offset / $this->limit;
    }
}
