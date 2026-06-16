<?php

declare(strict_types=1);

namespace App\Enums;

enum ResponseType: string
{
    case Success = 'success';
    case Info = 'info';
    case Warning = 'warning';
    case Error = 'error';
}
