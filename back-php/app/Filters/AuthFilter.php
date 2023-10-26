<?php

namespace App\Filters;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use CodeIgniter\Config\Services;
use App\Libraries\HTTP\HttpResponse;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

/**
 * This class implements the FilterInterface and is responsible for authenticating requests.
 * 
 * @author: Guillaume cornez
 */
class AuthFilter implements FilterInterface
{
    private const error_message = 'Unauthorized';

    public function before(RequestInterface $request, $args = null)
    {
        $errorResponse = new HttpResponse(ResponseInterface::HTTP_FORBIDDEN,null,[self::error_message]);

        //Return 403 if no token is provided
        $authHeader = $request->getServer('HTTP_AUTHORIZATION');
        if(!$authHeader) {
            return Services::response()->setStatusCode(ResponseInterface::HTTP_FORBIDDEN)->setJSON($errorResponse);
        }
        
        //Get the token from the header
        $key        = getenv('JWT_SECRET');
		$arr        = explode(' ', $authHeader);
		$token      = $arr[1];
        
        //Decode the token
        try{
            JWT::decode($token, new Key($key, 'HS256'));
        } catch (\Exception $e) {
            return Services::response()->setStatusCode(ResponseInterface::HTTP_FORBIDDEN)->setJSON($errorResponse);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // You have nothing to see here, move along.
    }
}