<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Search\Dbal;

use Doctrine\DBAL\Statement;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

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

    public function addPagination(int $limit, int $offset): self
    {
        if (null === $this->statement) {
            throw NotPreparedStatementException::create('Can\'t bind values before create a prepared statement');
        }
        $this->bindValue('limit', $limit);
        $this->bindValue('offset', $offset);
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

    public function getArrayResult(): array
    {
        if (null === $this->statement) {
            throw NotPreparedStatementException::create('Can\'t get result before create a prepared statement');
        }

        $result = $this->statement->executeQuery()->fetchAllAssociative();

        $this->reset();

        return $result;
    }

    public function getScalarResult(): mixed
    {
        if (null === $this->statement) {
            throw NotPreparedStatementException::create('Can\'t get result before create a prepared statement');
        }

        $data    = $this->statement->executeQuery()->fetchAllAssociative();
        $numRows = count($data);

        if ($numRows === 0) {
            throw new NoResultException();
        }

        if ($numRows > 1) {
            throw new NonUniqueResultException('The query returned multiple rows. Change the query or use a different result function like getScalarResult().');
        }

        $result = $data[0];

        if (count($result) > 1) {
            throw new NonUniqueResultException('The query returned a row containing multiple columns. Change the query or use a different result function like getScalarResult().');
        }

        return array_shift($result);
    }

    private function reset(): void
    {
        $this->statement = null;
    }
}
