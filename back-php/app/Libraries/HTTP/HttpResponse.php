<?php

namespace App\Libraries\HTTP;

/**
 * @OA\Schema(
 *     title="HttpResponse",
 *     description="Class for handling HTTP responses"
 * )
 * Represents an HTTP response squelettong
 * @author Guillaume Cornez
 */
class HttpResponse
{
    /**
     * @OA\Property(
     *     property="success",
     *     type="boolean",
     *     description="Indicates whether the response was successful or not",
     *     default=false
     * )
     */
    public bool $success = false;

     /**
     * @OA\Property(
     *     property="status",
     *     type="integer",
     *     description="The HTTP status code for the response",
     *     default=500
     * )
     */
    public int $status = 500;

    /**
     * @OA\Property(
     *     property="messages",
     *     type="array",
     *     @OA\Items(
     *         type="string",
     *         description="An array of strings representing messages for the response"
     *     )
     * )
     */
    public $messages;

    /**
     * @OA\Property(
     *     property="data",
     *     type="array",
     *     type="object",
     *     description="The data returned by the response. Could be an anonymous object or an array of anonymous objects"
     * )
     */
    public $data;
    
    /**
     * Constructor method for the class
     *
     * @param  int $status The HTTP status code for the response
     * @param  mixed $data Object or array of objects to be returned by the response, could be null
     * @param  Array $messages Array of strings representing messages for the response, could be null
     * @return void
     */
    public function __construct($status, $data = null, $messages = null)
    {
        $this->status = $status;
        $this->data = $data;
        $this->messages = $messages;

        if ($status >= 200 && $status < 300)
            $this->success = true;

        if ($messages == null) {
            switch ($status) {
                case 400:
                    $messages = ["Requête incorrecte"];
                    break;
                case 401:
                    $messages = ["Non autorisé"];
                    break;
                case 403:
                    $messages = ["Interdit"];
                    break;
                case 404:
                    $messages = ["Non trouvé"];
                    break;
                case 500:
                    $messages = ["Erreur interne du serveur"];
                    break;
                default:
                    $messages = [];
                    break;
            }

            $this->messages = $messages;
        }
    }
}
