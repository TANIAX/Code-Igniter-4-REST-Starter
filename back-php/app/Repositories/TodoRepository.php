<?php

namespace App\Repositories;

use Config\Database;
use App\Interfaces\IRepository;
use App\Repositories\BaseRepository;

/**
 * TodoRepository class represents a repository for the Todo model.
 * It implements the IRepository interface and extends the BaseRepository class.
 * It provides methods to interact with the todo table in the database.
 *
 * @author Guillaume Cornez
 */
class TodoRepository extends BaseRepository implements IRepository
{
    private $db;
    private $builder;

    public function __construct()
    {
        $this->db = Database::connect();
        $this->builder = $this->db->table('todo');
    }

        
    /**
     * getAll
     *
     * @param  int $result_type
     * @param  object $result_class
     * @return array of objects
     */
    public function getAll($result_type = self::RESULT_AS_OBJECT, $result_class = null)
    {
        $query = $this->builder->get();
        return $this->getResultAs($query, $result_type, $result_class);
    }
    
    /**
     * getById
     *
     * @param  int $id
     * @param  int $result_type
     * @param  object $result_class
     * @return array|object
     */
    public function getById($id,$result_type = self::RESULT_AS_OBJECT, $result_class = null)
    {
        $query = $this->builder->where('id', $id)->get();
        return $this->getResultAs($query, $result_type, $result_class);
    }
    
    /**
     * insert
     *
     * @param  object $data
     * @param  int $result_type
     * @param  object $result_class
     * @return bool whether the insert was successful or not
     */
    public function insert($data,$result_type = 1, $result_class = null)
    {
        return $this->builder->insert($data);
    }
    
    /**
     * update
     *
     * @param  int $id
     * @param  object $data
     * @param  int $result_type
     * @param  object $result_class
     * @return bool whether the update was successful or not
     */
    public function update($id, $data,$result_type = 1, $result_class = null)
    {
        return $this->builder->where('id', $id)->update($data);
    }
    
    /**
     * delete
     * @param  int $id
     * @param  int $result_type
     * @param  object $result_class
     * @return boolean
     */
    public function delete($id,$result_type = 1, $result_class = null)
    {
        return $this->builder->where('id', $id)->delete();
    }

    /**
     * deleteRange
     * @param  array $ids
     * @param  int $result_type
     * @param  object $result_class
     * @return boolean
     */
    public function deleteRange($ids,$result_type = 1, $result_class = null)
    {
        return $this->builder->whereIn('id', $ids)->delete();
    }
}