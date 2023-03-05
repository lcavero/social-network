<?php declare(strict_types=1);

namespace App\Tests\Network\Story\Application\FindStoryById;

use App\Network\Story\Application\FindStoryById\FindStoryByIdQuery;
use App\Network\Story\Application\FindStoryById\FindStoryByIdQueryHandler;
use App\Network\Story\Application\FindStoryById\FindStoryByIdResult;
use App\Network\Story\Domain\Exception\StoryNotFoundException;
use App\Network\Story\Domain\Search\StoryByIdSearcher;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertNull;

final class FindStoryByIdQueryHandlerTest extends TestCase
{
    public function testStoryNotFound(): void
    {
        $storyId = '0f7429bb-2242-4868-81d5-f140560b317a';
        $query = FindStoryByIdQuery::create($storyId);
        $storyByIdSearcherMock = \Mockery::mock(StoryByIdSearcher::class);
        $storyByIdSearcherMock
            ->shouldReceive('execute')
            ->with($storyId)
            ->once()
            ->andReturn(null)
        ;
        $queryHandler = new FindStoryByIdQueryHandler($storyByIdSearcherMock);

        assertNull(($queryHandler)($query));
    }

    public function testStoryFound(): void
    {
        $storyId = '0f7429bb-2242-4868-81d5-f140560b317a';
        $query = FindStoryByIdQuery::create($storyId);

        $expectedResult = [
            'id' => $storyId,
            'title' => 'Random title',
            'description' => 'Random description'
        ];

        $storyByIdSearcherMock = \Mockery::mock(StoryByIdSearcher::class);
        $storyByIdSearcherMock
            ->shouldReceive('execute')
            ->with($storyId)
            ->once()
            ->andReturn($expectedResult)
        ;
        $queryHandler = new FindStoryByIdQueryHandler($storyByIdSearcherMock);

        $result = ($queryHandler)($query);

        self::assertInstanceOf(FindStoryByIdResult::class, $result);
        self::assertSame($result->id, $expectedResult['id']);
        self::assertSame($result->title, $expectedResult['title']);
        self::assertSame($result->description, $expectedResult['description']);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        \Mockery::close();
    }
}
