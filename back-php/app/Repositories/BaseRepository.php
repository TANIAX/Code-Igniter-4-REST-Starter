<?php

namespace App\Repositories;

use Exception;
use Config\Database;
use ReflectionObject;
use App\Interfaces\IRepository;
use App\Libraries\CodeigniterExtension\Database\SQLite3\CustomResult;
/**
 * Base class for all repositories.
 * @author Guillaume Cornez
 */
abstract class BaseRepository implements IRepository
{
    public const RESULT_AS_OBJECT  = 1;
    public const RESULT_AS_ARRAY   = 2;
    public const RESULT_AS_CUSTOM  = 3;

    /**
     * Get all records from the repository.
     *
     * @param int $result_type The type of result to return (self::RESULT_AS_OBJECT or self::RESULT_AS_ARRAY).
     * @param string|null $result_class The class to use for each result object (only used if $result_type is self::RESULT_AS_OBJECT).
     *
     * @throws Exception if the method is not implemented.
     *
     * @return array|object[] The list of records.
     */
    public function getAll($result_type = self::RESULT_AS_OBJECT, $result_class = null)
    {
        throw new Exception('Not implemented');
    }

    /**
     * Get an entity by its ID.
     *
     * @param int $id The ID of the entity to retrieve.
     * @param int $result_type The type of result to return (default: self::RESULT_AS_OBJECT).
     * @param string|null $result_class The class name to use for the result (default: null).
     * @return mixed The result of the query.
     * @throws Exception If the method is not implemented.
     */
    public function getById($id, $result_type = self::RESULT_AS_OBJECT, $result_class = null)
    {
        throw new Exception('Not implemented');
    }

    /**
     * Insert data into the repository.
     *
     * @param mixed $data The data to be inserted.
     * @param int $result_type The type of result to be returned. Default is RESULT_AS_OBJECT.
     * @param string|null $result_class The class to be used for the result. Default is null.
     * @throws Exception If the method is not implemented.
     * @return mixed The result of the insertion.
     */
    public function insert($data, $result_type = self::RESULT_AS_OBJECT, $result_class = null)
    {
        throw new Exception('Not implemented');
    }

    /**
     * Update a record in the database.
     *
     * @param int $id The ID of the record to update.
     * @param array $data The data to update the record with.
     * @param int $result_type The type of result to return (object or array).
     * @param string|null $result_class The class to use for the returned object.
     * @throws Exception If the method is not implemented.
     * @return mixed The updated record.
     */
    public function update($id, $data, $result_type = self::RESULT_AS_OBJECT, $result_class = null)
    {
        throw new Exception('Not implemented');
    }

    /**
     * Delete a record from the database by ID.
     *
     * @param int $id The ID of the record to delete.
     * @param int $result_type The type of result to return (default: self::RESULT_AS_OBJECT).
     * @param string|null $result_class The class to use for the returned result (default: null).
     * @throws Exception If the method is not implemented.
     * @return mixed The result of the delete operation.
     */
    public function delete($id, $result_type = self::RESULT_AS_OBJECT, $result_class = null)
    {
        throw new Exception('Not implemented');
    }

    /**
     * Deletes a range of records from the database.
     *
     * @param array $ids The IDs of the records to delete.
     * @param int $result_type The type of result to return (object or array).
     * @param string|null $result_class The class to use for the returned object(s).
     * @throws Exception
     */
    public function deleteRange($ids, $result_type = self::RESULT_AS_OBJECT, $result_class = null)
    {
        throw new Exception('Not implemented');
    }

    public function getResultAs($query, $result_type, $result_class = null)
    {
        $data = null;
        switch ($result_type) {
            case self::RESULT_AS_ARRAY:
                $data = $query->getResultArray();
                break;
            case self::RESULT_AS_OBJECT:
                $data = $query->getResultObject();
                break;
            case self::RESULT_AS_CUSTOM:
                // We need to cast $query from a result class to a custom result class because we want to set a custom fetchObject method
                //! You need to create a custom result class that extends CodeIgniter\Database\{Your sql driver}\Result
                //For this example we created a child class from CodeIgniter\Database\SQLite3\Result
                $query = $this->cast(CustomResult::class,$query); 
                $data = $query->getCustomResultObject($result_class);
                break;
            default:
                $data = $query->getResultObject();
                break;
        }

        return $data;
    }

    /**
     * Casts the properties of a source object to a destination object.
     *
     * @param string|object $destination The destination object or its class name.
     * @param object $sourceObject The source object.
     * @return object The destination object with the properties of the source object.
     */
    private function cast($destination, $sourceObject)
    {
        if(!is_object($sourceObject))
            return $sourceObject;

        if (is_string($destination)) 
            $destination = new $destination();
        
        $sourceReflection = new ReflectionObject($sourceObject);
        $destinationReflection = new ReflectionObject($destination);
        $sourceProperties = $sourceReflection->getProperties();
        foreach ($sourceProperties as $sourceProperty) {
            $sourceProperty->setAccessible(true);
            $name = $sourceProperty->getName();
            $value = $sourceProperty->getValue($sourceObject);
            if ($destinationReflection->hasProperty($name)) {
                $propDest = $destinationReflection->getProperty($name);
                $propDest->setAccessible(true);
                $propDest->setValue($destination, $value);
            } else {
                $destination->$name = $value;
            }
        }
        return $destination;
    }
}
