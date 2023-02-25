<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Search\Dbal;

use Doctrine\DBAL\Statement;
use Doctrine\DBAL\Connection;

final class DbalQueryBuilder
{
    private ?Statement $statement = null;

    private function __construct(private readonly Connection $connection)
    {
    }

    public static function create(Connection $connection): self
    {
        return new self($connection);
    }

    public function prepare(string $sql): self
    {
        $this->reset();
        $this->statement = $this->connection->prepare($sql);
        return $this;
    }

    public function bindValue(string $param, mixed $value): self
    {
        if (null === $this->statement) {
            throw NotPreparedStatementException::create('Can\'t bind values before create a prepared statement');
        }
        $this->statement->bindValue($param, $value);
        return $this;
    }

    public function getSingleResult(): ?array
    {
        if (null === $this->statement) {
            throw NotPreparedStatementException::create('Can\'t get result before create a prepared statement');
        }

        $result = $this->statement->executeQuery()->fetchAssociative();

        $this->reset();

        if (false === $result) {
            return null;
        }

        return $result;
    }

    private function reset(): void
    {
        $this->statement = null;
    }
}
