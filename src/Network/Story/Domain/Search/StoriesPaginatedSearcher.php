<?php declare(strict_types=1);

namespace App\Network\Story\Domain\Search;

interface StoriesPaginatedSearcher
{
    public function execute(int $limit, int $offset): array;
}
