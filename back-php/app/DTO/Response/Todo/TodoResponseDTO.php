<?php

namespace App\DTO\Response\Todo;

/**
 * @OA\Schema(
 *     title="TodoResponseDTO",
 *     description="TodoResponseDTO",
 * )
 * @author: Guillaume cornez
 */
class TodoResponseDTO 
{
    /**
     * @OA\Property(type="int", description="id", example="1")
     */
    public int $id;

    /**
     * @OA\Property(type="string", description="name", example="Buy fruits")
     */
    public ?string $name;

    /**
     * @OA\Property(type="boolean", description="done", example="false")
     */
    public ?bool $done;
}