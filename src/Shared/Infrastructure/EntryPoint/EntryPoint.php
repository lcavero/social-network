<?php declare(strict_types=1);

namespace App\Shared\Infrastructure\EntryPoint;

enum EntryPoint
{
    case API;
    case GUI;
    case CLI;
    case INDETERMINATE;
}
