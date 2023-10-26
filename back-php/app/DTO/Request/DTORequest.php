<?php
namespace App\DTO\Request;

use App\Interfaces\IValidator;
use Symfony\Component\Validator\Validation;

/**
 * This class is used for request transfer object.
 * It contains the validator and the violations array.
 * It also contains the validate method that must be implemented in the child classes.
 * @author: Guillaume cornez
 */
class DTORequest implements IValidator
{
    protected $validator;
    protected $violations;
    protected $errors;
    
    /**
     * DTORequest constructor.
     * @param string|null $json The JSON string to be decoded and used to populate the DTO properties.
     */
    public function __construct($json = null)
    {
        $this->validator = Validation::createValidator();
        
        if($json != null)
        {
            $jsonArray = json_decode($json, true);
            foreach($jsonArray as $key=>$value)
                $this->$key = $value;
        }            
    }
        
    /**
     * This method is used to validate the DTORequest object.
     * It throws an exception if the method is not implemented in the child class.
     *
     * @throws \Exception
     * @return array of errors as string
     */
    public function validate()
    {
        throw new \Exception("Validate method must be implemented in child class.");
    }

    /**
     * Returns an array of error messages from the violations array.
     *
     * @return array The array of error messages.
     */
    protected function getErrors(){
        // Loop to feed the return array
        foreach($this->violations as $violation){
            if(count($violation) > 0)
            {
                foreach($violation as $error){
                    $this->errors[] = $error->getMessage();
                }
            }
        }
        
        return $this->errors;
    }

}