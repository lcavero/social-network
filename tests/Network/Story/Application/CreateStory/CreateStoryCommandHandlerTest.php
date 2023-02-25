<?php declare(strict_types=1);

namespace App\Tests\Network\Story\Application\CreateStory;

use App\Network\Story\Application\CreateStory\CreateStoryCommand;
use App\Network\Story\Application\CreateStory\CreateStoryCommandHandler;
use App\Network\Story\Domain\Persistence\StoryPersistenceRepository;
use App\Network\Story\Domain\Story;
use App\Shared\Domain\VO\String\InvalidStringException;
use App\Shared\Domain\VO\Uuid\InvalidUuidException;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;

final class CreateStoryCommandHandlerTest extends TestCase
{
    /** @dataProvider createdSuccessfullyDataProvider */
    public function testCreatedSuccessfully(array $fields, array $expectedFields): void
    {
        $storyPersistenceRepositoryMock = \Mockery::mock(StoryPersistenceRepository::class);
        $storyPersistenceRepositoryMock
            ->shouldReceive('save')
            ->with(Mockery::capture($story))
            ->once()
        ;

        $command = CreateStoryCommand::create($fields['storyId'], $fields['storyTitle'], $fields['storyDescription']);
        $commandHandler = new CreateStoryCommandHandler($storyPersistenceRepositoryMock);

        ($commandHandler)($command);

        self::assertInstanceOf(Story::class, $story);
        self::assertSame($expectedFields['storyId'], $story->id()->value);
        self::assertSame($expectedFields['storyTitle'], $story->title()->value);
        self::assertSame($expectedFields['storyDescription'], $story->description()->value);
    }


    /** @dataProvider failuresWithInvalidStoryIdDataProvider */
    public function testFailuresWithInvalidStoryId(string $storyId, string $expectedErrorMessage): void
    {
        $storyPersistenceRepositoryMock = \Mockery::mock(StoryPersistenceRepository::class);
        $storyPersistenceRepositoryMock->shouldNotReceive('save');

        $command = CreateStoryCommand::create($storyId, 'test', 'test');
        $commandHandler = new CreateStoryCommandHandler($storyPersistenceRepositoryMock);
        $this->expectException(InvalidUuidException::class);
        $this->expectExceptionMessage($expectedErrorMessage);

        ($commandHandler)($command);
    }

    /** @dataProvider failuresWithInvalidStoryTitleDataProvider */
    public function testFailuresWithInvalidStoryTitle(string $storyTitle, string $expectedErrorMessage): void
    {
        $storyPersistenceRepositoryMock = \Mockery::mock(StoryPersistenceRepository::class);
        $storyPersistenceRepositoryMock->shouldNotReceive('save');

        $command = CreateStoryCommand::create(Uuid::v4()->toRfc4122(), $storyTitle, 'test');
        $commandHandler = new CreateStoryCommandHandler($storyPersistenceRepositoryMock);
        $this->expectException(InvalidStringException::class);
        $this->expectExceptionMessage($expectedErrorMessage);

        ($commandHandler)($command);
    }

    /** @dataProvider failuresWithInvalidStoryDescriptionDataProvider */
    public function testFailuresWithInvalidStoryDescription(string $storyDescription, string $expectedErrorMessage): void
    {
        $storyPersistenceRepositoryMock = \Mockery::mock(StoryPersistenceRepository::class);
        $storyPersistenceRepositoryMock->shouldNotReceive('save');

        $command = CreateStoryCommand::create(Uuid::v4()->toRfc4122(), 'test', $storyDescription);
        $commandHandler = new CreateStoryCommandHandler($storyPersistenceRepositoryMock);
        $this->expectException(InvalidStringException::class);
        $this->expectExceptionMessage($expectedErrorMessage);

        ($commandHandler)($command);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    protected function createdSuccessfullyDataProvider(): array
    {
        return [
            'Valid Story #1' => [
                'fields' => [
                    'storyId' => 'c2c7b77f-49d7-428d-af44-7b2248218d9c',
                    'storyTitle' => 'A nice title!',
                    'storyDescription' => 'A nice description!'
                ],
                'expectedFields' => [
                    'storyId' => 'c2c7b77f-49d7-428d-af44-7b2248218d9c',
                    'storyTitle' => 'A nice title!',
                    'storyDescription' => 'A nice description!'
                ]
            ],
            'Valid Story #2' => [
                'fields' => [
                    'storyId' => '2e39961f-c052-4823-9ce0-d1f12e1ffd17',
                    'storyTitle' => ' Another title with spaces ',
                    'storyDescription' => " A description that  should be trimmed\n"
                ],
                'expectedFields' => [
                    'storyId' => '2e39961f-c052-4823-9ce0-d1f12e1ffd17',
                    'storyTitle' => 'Another title with spaces',
                    'storyDescription' => 'A description that  should be trimmed'
                ]
            ],
        ];
    }

    protected function failuresWithInvalidStoryIdDataProvider(): array
    {
        return [
            'Blank' => [
                'storyId' => '',
                'errorMessage' => 'The value "" is not a valid Uuid.'
            ],
            'Invalid' => [
                'storyId' => '555',
                'errorMessage' => 'The value "555" is not a valid Uuid.'
            ]
        ];
    }

    protected function failuresWithInvalidStoryTitleDataProvider(): array
    {
        return [
            'Blank' => [
                'storyTitle' => '',
                'errorMessage' => 'The value "" does not meet the minimum length of 3.'
            ],
            'Lower than min' => [
                'storyTitle' => 'A',
                'errorMessage' => 'The value "A" does not meet the minimum length of 3.'
            ],
            'Lower than min (postTrimmed)' => [
                'storyTitle' => ' Ey',
                'errorMessage' => 'The value "Ey" does not meet the minimum length of 3.'
            ],
            'Higher than max' => [
                'storyTitle' => 'A very large title with more than 60 characters is not allowed',
                'errorMessage' => 'The value "A very large title with more than 60 characters is not allowed" exceeds the maximum length of 60.'
            ],
        ];
    }

    protected function failuresWithInvalidStoryDescriptionDataProvider(): array
    {
        return [
            'Blank' => [
                'storyDescription' => '',
                'errorMessage' => 'The value "" does not meet the minimum length of 10.'
            ],
            'Lower than min' => [
                'storyDescription' => 'Sort desc',
                'errorMessage' => 'The value "Sort desc" does not meet the minimum length of 10.'
            ],
            'Lower than min (postTrimmed)' => [
                'storyDescription' => 'Sort desc',
                'errorMessage' => 'The value "Sort desc" does not meet the minimum length of 10.'
            ],
            'Higher than max' => [
                'storyDescription' => 'A very large description with more than 140 characters is not allowed. This is a really large description, so it should not be passed, and an exception will be thrown',
                'errorMessage' => 'The value "A very large description with more than 140 characters is not allowed. This is a really large description, so it should not be passed, and an exception will be thrown" exceeds the maximum length of 140.'
            ],
        ];
    }
}
