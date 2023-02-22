<?php declare(strict_types=1);

namespace App\Network\Story\Application\FindStory;

use App\Shared\Domain\Bus\Query\QueryHandlerInterface;
use App\Shared\Domain\VO\Uuid\Uuid2;
use App\Shared\Domain\VO\Uuid\UuidValueObject;
use Symfony\Component\HttpFoundation\Request;

final readonly class FindStoryQueryHandler implements QueryHandlerInterface
{
    public function __construct()
    {
    }

    public function __invoke(FindStoryQuery $query): FindStoryResult
    {
        $q = UuidValueObject::generate()->value;
        $a = Uuid2::fromString($q);

        var_dump(get_class($a));

        return FindStoryResult::fromArray([
            'title' => 'dummyTitle',
            'description' => 'dummyDescription'
        ]);
    }
}
