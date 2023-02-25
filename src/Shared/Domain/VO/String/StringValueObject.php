<?php declare(strict_types=1);

namespace App\Shared\Domain\VO\String;

readonly class StringValueObject
{
    const MIN = 0;
    const MAX = 255;

    const TRIM_MASK = " \t\n\r\0\x0B";

    protected function __construct(public string $value)
    {
    }

    public final static function fromString(string $value): static
    {
        $value = static::normalize($value);
        static::validate($value);
        return new static($value);
    }

    protected static function normalize(string $value): string
    {
        return trim($value, static::TRIM_MASK);
    }

    public static function validate(string $value): void
    {
        if (!self::meetsMinLength($value)) {
            throw InvalidStringException::fromLengthNotReached($value, static::MIN);
        }

        if (!self::meetsMaxLength($value)) {
            throw InvalidStringException::fromLengthExceeded($value, static::MAX);
        }
    }

    public final static function meetsMaxLength(string $value): bool
    {
        return mb_strlen($value) <= static::MAX;
    }

    public final static function meetsMinLength(string $value): bool
    {
        return mb_strlen($value) >= static::MIN;
    }

    public final function __toString(): string
    {
        return $this->value;
    }
}
