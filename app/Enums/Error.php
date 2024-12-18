<?php

namespace App\Enums;

/**
 * Enum used to map project error slugs.
 */
enum Error: string
{
    case REQUEST_VALIDATION_ERROR = 'REQUEST_VALIDATION_ERROR';
    case REQUEST_ACTION_FORBIDDEN = 'REQUEST_ACTION_FORBIDDEN';
}
