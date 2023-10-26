<?php

namespace App\DTO\Response\Todo;

/**
 * @OA\Schema(
 *     title="TodoWithOutIdResponseDTO",
 *     description="TodoWithOutIdResponseDTO",
 * )
 * @author: Guillaume cornez
 */
class TodoWithOutIdResponseDTO 
{
    /**
     * @OA\Property(type="string", description="name", example="Buy fruits")
     */
    public ?string $name = "";

    /**
     * @OA\Property(type="boolean", description="done", example="false")
     */
    public ?bool $done = false; 
}