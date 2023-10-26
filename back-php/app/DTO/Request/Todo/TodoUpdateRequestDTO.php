<?php

namespace App\DTO\Request\Todo;

use App\DTO\Request\DTORequest;
use App\DTO\Request\Todo\TodoConstraint;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @OA\Schema(
 *     title="TodoUpdateRequestDTO",
 *     description="TodoUpdateRequestDTO",
 *     required={"id","name"}
 * )
 * This class represents the data transfer object for updating a new todo item.
 * @author: Guillaume cornez
 */
class TodoUpdateRequestDTO extends DTORequest
{
    /**
     * @OA\Property(type="int", description="id", example="1")
     */
    public int $id = 0;

    /**
     * @OA\Property(type="string", description="name", example="Buy fruits")
     */
    public ?string $name = "";

    /**
     * @OA\Property(type="boolean", description="done", example="false")
     */
    public ?bool $done = false;

    
    public function __construct($json = null)
    {
        parent::__construct($json);
    }

    public function validate()
    {
        $this->errors = [];
        
        $this->violations[] = $this->validator->validate($this->id, [
            new NotBlank(["message" => "Id is required."]),
        ]);

        $this->violations[] = $this->validator->validate($this->name, [
            new NotBlank(["message" => "Name is required."]),
            new Length([
                "min" => TodoConstraint::NAME_MIN_LENGTH,
                "max" => TodoConstraint::NAME_MAX_LENGTH,
                "minMessage" => "Votre email doit être de minimum " . TodoConstraint::NAME_MIN_LENGTH . " caractères.",
                "maxMessage" => "Votre email doit être de maximum " . TodoConstraint::NAME_MAX_LENGTH. " caractères",
            ]),
        ]);

        return $this->getErrors();
    }
}