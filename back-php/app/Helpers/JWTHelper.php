<?php

namespace App\Helpers;

use Exception;
use Firebase\JWT\JWT;


/**
 * A helper class for handling jwt operations.
 *
 * @author Guillaume cornez
 */
class JWTHelper
{

    public static function create_jwt()
    {
        //Variable(s) declaration
        $token  = "";
        $key    = getenv('JWT_SECRET');
        $iat    = time();                // current timestamp value
        $exp    = $iat + 3600;           //1h

        //Create the token
        try{
            $payload = array(
                "iss" => "Issuer of the JWT",
                "aud" => "Audience that the JWT",
                "sub" => "Subject of the JWT",
                "iat" => $iat,            //Time the JWT issued at
                "exp" => $exp,            // Expiration time of token
            );
    
            $token = JWT::encode($payload, $key, 'HS256');
        }catch(Exception $e){
            throw new Exception("Error has appenned during the token creation process" . $e->getMessage());
        }
       
        //Return the token
        return $token;
    }
}
