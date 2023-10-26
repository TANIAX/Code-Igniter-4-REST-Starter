<?php

namespace App\Controllers\API\V1;

use stdClass;
use AutoMapperPlus\AutoMapper;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Libraries\HTTP\HttpResponse;
use AutoMapperPlus\Configuration\AutoMapperConfig;
use CodeIgniter\HTTP\ResponseInterface;

class ApiController extends BaseController
{
    private $config;
    protected $mapper;

    use ResponseTrait;

    public function __construct()
    {
        #region AutoMapper
        $this->config = new AutoMapperConfig();

        //Mapping for stdClass
        // $this->config->registerMapping(stdClass::class, MyResponseDTO::class)->useCustomMapper(new LowerCaseMapper());

        $this->mapper = new AutoMapper($this->config);
        #endregion
    }

    /**
     * Respond to a failed request with specified status code and error messages.
     * 
     * @param int $status HTTP status code.
     * @param mixed $errors Error message(s) to be returned in the response. Can be either a string or an array of strings.
     * @throws \Exception If the $errors parameter is neither a string nor an array.
     * @return HttpResponse The generated HTTP response.
     */
    protected function error($status, $errors = null)
    {
        $response = null;

        if ($errors != null) {
            if (!is_array($errors) && !is_string($errors)) {
                throw new \Exception("Errors parameter need to be a string or an array of strings.");
            }

            if (!is_array($errors)) {
                $errors = [$errors];
            }

            $response = new HttpResponse($status, null, $errors);
            return $this->respond($response, $response->status);
        } else {
            $response = new HttpResponse($status);
            return $this->respond($response, $response->status);
        }
    }

    /**
     * Respond to a successful request with specified status code, data, and message.
     * 
     * @param int $status HTTP status code.
     * @param object $data Data to be returned in the response.
     * @param string $message Message to be returned in the response.
     * @return HttpResponse The generated HTTP response.
     */
    protected function success($data = null, $status = 200, $message = "")
    {
        //No content
        if ($status == 204) {
            $response = new HttpResponse($status, [], $message);
            return $this->respond($response, 200);
        }

        //Check if data is an object or an array of objects
        if ($data != null) {
            if (is_array($data)) {
                foreach ($data as $item) {
                    if (!is_object($item)) {
                        throw new \Exception("Data parameter need to be an object.");
                    }
                }
            } else if (!is_object($data)) {
                throw new \Exception("Data parameter need to be an object.");
            }
        }
        
        $response = new HttpResponse($status, $data, $message);
        return $this->respond($response, $response->status);
    }
}
