<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Search\Dbal;

use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;

final readonly class SearchDbalConnectionProvider
{
    const SEARCH_DBAL_CONNECTION_NAME = 'search';

    public function __construct(private ManagerRegistry $registry)
    {
    }

    public function getConnection(): Connection
    {
        $connection = $this->registry->getConnection(self::SEARCH_DBAL_CONNECTION_NAME);
        assert($connection instanceof Connection);
        return $connection;
    }
}
