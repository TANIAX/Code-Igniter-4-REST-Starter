<?php

namespace App\Controllers\API\V1;

use App\Helpers\JWTHelper;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use App\DTO\Request\Auth\LoginRequestDTO;
use App\DTO\Response\Auth\LoginResponseDTO;
use App\Libraries\AD\Ad;

class AuthController extends ApiController
{
    use ResponseTrait;

    private $ad;
    private $serializer;
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->ad = new Ad();
    }

    /**
     *     @OA\Post(
     *     path="/api/v1/auth/login",
     *     tags={"Authentification"},
     *     summary="Authentification",
     *     description="Authentification",
     *     operationId="login",
     *     @OA\RequestBody(
     *         description="Authentification",
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequestDTO")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/LoginResponseDTO")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Empty login or password",
     *         @OA\JsonContent(type="object", @OA\Property(property="status", type="int", example=400),
     *                                        @OA\Property(property="success", type="bool", example="false"), 
     *                                        @OA\Property(property="messages", type="array", @OA\Items(type="string", example="Login or password empty"))),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Incorrect login or password",
     *         @OA\JsonContent(type="object", @OA\Property(property="status", type="int", example=401),
     *                                        @OA\Property(property="success", type="bool", example="false"), 
     *                                        @OA\Property(property="messages", type="array", @OA\Items(type="string", example="Login or password incorrect"))),
     *     ),
     * )
     *
     * Return JWT if user is authenticated
     * @author: Guillaume cornez
     * @return Object
     */
    public function Login()
    {
        $body = new LoginRequestDTO($this->getRequestInput($this->request));

        $errors = $body->validate();
        if ($errors)
            return $this->error(400,$errors);

        if (!$this->ad->connect($body->username, $body->password))
            return $this->error(ResponseInterface::HTTP_UNAUTHORIZED,"Login or password incorrect");

        return $this->success(new LoginResponseDTO(JWTHelper::create_jwt()));
    }
}
