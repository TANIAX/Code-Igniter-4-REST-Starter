<?php

namespace App\Helpers;

use DateTime;
use Exception;

/**
 * A helper class for handling date and time operations.
 *
 * @author Guillaume cornez
 */
class DateHelper
{
    /**
     * Validates a date and time string against a given format.
     *
     * @param string $dateStr The date and time string to validate.
     * @param string $format  The format to validate the date and time string against.
     *
     * @return bool Returns true if the date and time string is valid, false otherwise.
     */
    public static function validateDateTime($dateStr, $format)
    {
        date_default_timezone_set('UTC');
        $date = DateTime::createFromFormat($format, $dateStr);
        return $date && ($date->format($format) === $dateStr);
    }

    /**
     * Formats a date and time string from one format to another.
     *
     * @param string $dateStr   The date and time string to format.
     * @param string $format    The format of the input date and time string.
     * @param string $formatTo  The format to convert the date and time string to.
     *
     * @return string The formatted date and time string.
     */
    public static function formatDate($dateStr, $format, $formatTo)
    {
        date_default_timezone_set('UTC');
        $date = DateTime::createFromFormat($format, $dateStr);
        return $date->format($formatTo);
    }
}
