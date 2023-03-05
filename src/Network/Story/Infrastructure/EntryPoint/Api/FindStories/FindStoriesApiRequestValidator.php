<?php declare(strict_types=1);

namespace App\Network\Story\Infrastructure\EntryPoint\Api\FindStories;

use App\Shared\Infrastructure\EntryPoint\Http\Request\AbstractRequestValidator;
use Symfony\Component\Validator\Constraints as Assert;

final class FindStoriesApiRequestValidator extends AbstractRequestValidator
{
    protected function queryConstraints(): Assert\Collection
    {
        return $this->addPaginationConstraints(new Assert\Collection([]));
    }
}
