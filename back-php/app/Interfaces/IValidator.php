<?php

namespace App\Interfaces;

/**
 * Interface for validator classes.
 * @author Guillaume Cornez
 */
interface IValidator
{
    /**
     * Validates the input data.
     */
    public function validate();
}