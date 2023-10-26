<?php

namespace App\Controllers;

/**
 * Class SwaggerController
 * 
 * This class is responsible for handling requests related to Swagger documentation.
 * @author Guillaume Cornez
 */
class SwaggerController extends BaseController
{

    /**
     * Returns the view for the Swagger documentation.
     */
    public function index()
    {
        return view('swagger/index');
    }
}
