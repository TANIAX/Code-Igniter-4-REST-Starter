<?php

namespace App\Entities;

/**
 * @OA\Schema(
 *     title="Todo",
 *     description="Todo entity",
 * )
 * 
 * Class Todo that represents a Todo entity.
 * @author: Guillaume cornez
 */
class Todo 
{
    /**
     * @OA\Property(type="int", description="id", example="1")
     */
    public int $id;

    /**
     * @OA\Property(type="string", description="name", example="Buy fruits")
     */
    public string $name;

    /**
     * @OA\Property(type="boolean", description="done", example="false")
     */
    public bool $done;
}