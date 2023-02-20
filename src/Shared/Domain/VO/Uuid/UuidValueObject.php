<?php declare(strict_types=1);

namespace App\Shared\Domain\VO\Uuid;

use Symfony\Component\Uid\Uuid;

final readonly class UuidValueObject
{
    const UUID_PATTERN = '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i';
    const UUID_VERSION = 4;

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
