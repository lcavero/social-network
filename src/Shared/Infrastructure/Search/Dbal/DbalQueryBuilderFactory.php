<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Search\Dbal;

final readonly class DbalQueryBuilderFactory
{
    public function __construct(private SearchDbalConnectionProvider $connectionProvider)
    {
    }

    public function create(): DbalQueryBuilder
    {
        return DbalQueryBuilder::create($this->connectionProvider->getConnection());
    }
}
