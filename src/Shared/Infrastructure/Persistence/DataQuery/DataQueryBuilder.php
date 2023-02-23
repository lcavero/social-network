<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\Persistence\DataQuery;

use Doctrine\DBAL\Statement;
use Doctrine\ORM\EntityManagerInterface;

final class DataQueryBuilder
{
    private ?Statement $statement;
    private ?EntityManagerInterface $manager;

    private function __construct(EntityManagerInterface $manager)
    {
        $this->reset();
        $this->manager = $manager;
    }

    public static function create(EntityManagerInterface $manager): self
    {
       return new self($manager);
    }

    public function prepare(string $sql): self
    {
        assert(null !== $this->manager);
        $this->statement = $this->manager->getConnection()->prepare($sql);
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
        $this->manager = null;
    }
}
