<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Query;

use App\Shared\Domain\Bus\Query\QueryBusInterface;
use App\Shared\Domain\Bus\Query\QueryInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class QueryBus implements QueryBusInterface
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(private readonly MessageBusInterface $queryBus)
    {
        $this->messageBus = $this->queryBus;
    }

    public function handle(QueryInterface $query): mixed
    {
        return $this->handleQuery($query);
    }
}