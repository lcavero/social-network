<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\Search\Dbal;

use App\Network\Story\Domain\Search\StoriesPaginatedSearcher;
use App\Shared\Infrastructure\Search\Dbal\DbalQueryBuilderFactory;

final readonly class DbalStoriesPaginatedSearcher implements StoriesPaginatedSearcher
{
    public function __construct(private DbalQueryBuilderFactory $dbalQueryBuilderFactory)
    {
    }

    public function execute(int $limit, int $offset): array
    {
        $sql = "SELECT uuid as id, title, description FROM network_story LIMIT :limit OFFSET :offset";
        $totalSql = "SELECT count(*) FROM network_story";


        $data = $this->dbalQueryBuilderFactory
            ->create()
            ->prepare($sql)
            ->addPagination($limit, $offset)
            ->getArrayResult()
        ;

        $total = $this->dbalQueryBuilderFactory
            ->create()
            ->prepare($totalSql)
            ->getScalarResult()
        ;

        return [
            'data' => $data,
            'total' => $total
        ];

    }
}
