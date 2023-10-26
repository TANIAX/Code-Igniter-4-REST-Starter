<?php

namespace App\DTO\Response\Auth;

/**
 * @OA\Schema(
 *     title="LoginResponseDTO",
 *     description="LoginResponseDTO",
 * )
 * @author: Guillaume cornez
 */
class LoginResponseDTO
{
    /**
     * @OA\Property(type="string", description="access token", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c")
     */
    public $access_token;

     /**
     * @OA\Property(type="string", description="decode me", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkVBU1RFUiBFR0cifQ.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyLCJtZXJjaSI6Ikdyw6JjZSBhdXggdXNhZ2VycyB2b3VzIGF2ZXogdW4gZW1wbG9pLCBkb25jIG4nb3VibGlleiBwYXMgZGUgbGV1cnMgZGlyZSBtZXJjaSAhIn0.drMDruzO5qlje12n6PR-0b2wWC9J8G_wxOyUKv3qs9k")
     */
    public $refresh_token;

    /**
     * @OA\Property(type="object", description="user")
     */
    public $user;

    public function __construct($access_token = "", $refresh_token = "", $user = null)
    {
        //Attribution des paramètres aux propriétés de la classe
        $this->access_token = $access_token;
        $this->refresh_token = $refresh_token;
        $this->user = $user;

        //Si paramètre vide, on efface les valeurs
        if ($access_token == "") 
            unset($this->access_token);

        if ($refresh_token == "")
            unset($this->refresh_token);

        if ($user == null)
            unset($this->user);
        
    }
}