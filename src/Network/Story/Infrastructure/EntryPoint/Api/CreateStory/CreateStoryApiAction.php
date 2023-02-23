<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\EntryPoint\Api\CreateStory;

use App\Network\Story\Application\CreateStory\CreateStoryCommand;
use App\Shared\Domain\Bus\Command\CommandBusInterface;
use App\Shared\Infrastructure\EntryPoint\Http\Controller\ControllerInterface;
use App\Shared\Infrastructure\EntryPoint\Http\Exception\BadRequestHttpException;
use App\Shared\Infrastructure\EntryPoint\Http\Response\ApiCreatedResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final readonly class CreateStoryApiAction implements ControllerInterface
{
    public function __construct(private CommandBusInterface $bus, private CreateStoryApiRequestValidator $createStoryApiRequestValidator)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $errors = $this->createStoryApiRequestValidator->validate($request);

        if ($errors->count() > 0) {
            throw BadRequestHttpException::fromConstraintViolationList($errors);
        }

        $body = $request->toArray();

        $this->bus->dispatch(CreateStoryCommand::create(
            $body['id'],
            $body['title'],
            $body['description']
        ));
        return ApiCreatedResponse::create();
    }
}
