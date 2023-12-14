<?php

namespace App\DTO\Request\Auth;

use App\DTO\Request\DTORequest;
use Symfony\Component\Validator\Constraints\Length;

/**
 * @OA\Schema(
 *     title="LoginRequestDTO",
 *     description="LoginRequestDTO",
 *     required={"username", "password"}
 * )
 * @author: Guillaume cornez
 */
class LoginRequestDTO extends DTORequest
{
    /**
     * @OA\Property(type="string", description="username", example="john.doe")
     */
    public string $username = '';

    /**
     * @OA\Property(type="string", description="Password", example="M0N_M0T_DE_P4SS3_leet")
     */
    public string $password = '';

    /**
     * Constructeur de la classe - initialise le contenu du DTO
     *
     * @return void
     */
    public function __construct($json = null)
    {
         parent::__construct($json);
    }
        
    /**
     * Méthode de validation du DTO
     *
     * @return iterable message d'erreurs
     */
    public function validate() : iterable
    {
        $this->errors = [];
        $this->violations[] = $this->validator->validate($this->username, [
            new Length(['min' => 3, 'minMessage'=> 'Le login doit contenir au moins 3 caractères']),
        ]); 

        $this->violations[] = $this->validator->validate($this->password, [
            new Length(['min' => 3, 'minMessage'=> 'Le mot de passe doit contenir au moins 3 caractères']),
        ]); 

        return $this->getErrors();
    }
}