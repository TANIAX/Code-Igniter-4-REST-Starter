<?php

namespace App\Interfaces;
/**
 * Interface IRepository
 * @author Guillaume cornez
 */
interface IRepository
{
    /**
     * Get all records from the repository.
     *
     * @param int $result_type
     * @param null $result_class
     * @return mixed
     */
    public function getAll($result_type = 1, $result_class = null);

    /**
     * Get a record by its ID from the repository.
     *
     * @param $id
     * @param int $result_type
     * @param null $result_class
     * @return mixed
     */
    public function getById($id,$result_type = 1, $result_class = null);

    /**
     * Insert a new record into the repository.
     *
     * @param $data
     * @param int $result_type
     * @param null $result_class
     * @return bool whether the insert was successful or not
     */
    public function insert($data,$result_type = 1, $result_class = null);

    /**
     * Update a record in the repository.
     *
     * @param $id
     * @param $data
     * @param int $result_type
     * @param null $result_class
     * @return bool whether the update was successful or not
     */
    public function update($id, $data,$result_type = 1, $result_class = null);

    /**
     * Delete a record from the repository by its ID.
     *
     * @param $id
     * @param int $result_type
     * @param null $result_class
     * @return bool whether the delete was successful or not
     */
    public function delete($id,$result_type = 1, $result_class = null);

    /**
     * Delete a range of records from the repository by their IDs.
     *
     * @param $ids
     * @param int $result_type
     * @param null $result_class
     * @return bool whether the delete was successful or not
     */
    public function deleteRange($ids,$result_type = 1, $result_class = null);
}