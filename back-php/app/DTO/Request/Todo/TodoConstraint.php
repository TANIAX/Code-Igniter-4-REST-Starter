<?php

namespace App\DTO\Request\Todo;

/**
 * Class TodoConstraint
 * Contains constants for Todo request validation constraints.
 * @author: Guillaume cornez
 */
class TodoConstraint
{
    /**
     * Minimum length for Todo name.
     */
    public const NAME_MIN_LENGTH = 3;
    
    /**
     * Maximum length for Todo name.
     */
    public const NAME_MAX_LENGTH = 255;
}