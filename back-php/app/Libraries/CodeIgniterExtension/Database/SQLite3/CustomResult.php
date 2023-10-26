<?php

namespace App\Libraries\CodeigniterExtension\Database\SQLite3;

use Closure;
use CodeIgniter\Database\SQLite3\Result;

/**
 * Create a custom result class that extends CodeIgniter\Database\{Your sql driver}\Result is important in case you want to use the getResultAs with a custom result class
 * If you don't do this, you will receive an object who's not a perfectly mapped 
 * 
 * @author Guillaume cornez
 */
class CustomResult extends Result
{

    public function __construct(){}


    /**
     * Fetches the next row and returns it as an object of the specified class.
     * 
     * @param string $className The name of the class to instantiate.
     * @return false|object Returns the fetched row as an object of the specified class or false if there are no more rows.
     */
    protected function fetchObject(string $className = 'stdClass')
    {
        // No native support for fetching rows as objects
        if (($row = $this->fetchAssoc()) === false) {
            return false;
        }

        if ($className === 'stdClass') {
            return (object) $row;
        }

        $classObj = new $className();

        if (is_subclass_of($className, Entity::class)) {
            return $classObj->setAttributes($row);
        }

        $classSet = Closure::bind(function ($key, $value, $classObj) {
            //If $classObj has a $key property, then set it to $value, otherwise ignore it
            if(property_exists($classObj, $key)){
                $this->{$key} = $value;
            }
        }, $classObj, $className);

        foreach (array_keys($row) as $key) {
            $classSet($key, $row[$key],$classObj);
        }

        return $classObj;
    }
}


