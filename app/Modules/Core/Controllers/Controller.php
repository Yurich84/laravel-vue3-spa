<?php

namespace App\Modules\Core\Controllers;

abstract class Controller
{
    const RESPONSE_TYPE_SUCCESS = 'success';
    const RESPONSE_TYPE_INFO = 'info';
    const RESPONSE_TYPE_WARNING = 'warning';
    const RESPONSE_TYPE_ERROR = 'error';
}
