<?php

namespace App\Controllers;

use App\Dto\Response\HttpResponse;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

        
    /**
     * Contournement du problème de requête JSON stockée dans le champs "body" et du contenu de la requête "form-data" 
     * stocké dans le champ "post". 
     *
     * @param  IncomingRequest $request
     * @param  bool $jsonFormat
     * @return string|bool
     */
    public function getRequestInput(IncomingRequest $request, $jsonFormat = true)
    {
        $input = $request->getPost();

        if (empty($input)) {

            if ($jsonFormat) {
                $input = $this->request->getBody();
            } else {
                // Convertit le corps de la requête en tableau associatif 
                $input = json_decode($request->getBody(), true);
            }
        }
        return $input;
    }
}
