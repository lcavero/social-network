<?php declare(strict_types=1);

namespace App\Shared\Domain\VO\Uuid;

use Symfony\Component\Uid\Uuid;

final readonly class UuidValueObject
{
    const UUID_PATTERN = '/^[0-9A-F]{8}-[0-9A-F]{4}-[4][0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

    private function __construct(public string $value)
    {
    }

    public static function generate(): self
    {
        return new self(Uuid::v4()->toRfc4122());
    }

    public static function fromString(string $value): self
    {
        if (!self::isValid($value)) {
            throw InvalidUuidException::fromValue($value);
        }
        return new self($value);
    }

    public static function isValid(string $value): bool
    {
        return 1 === preg_match(self::UUID_PATTERN, $value);
    }
}
