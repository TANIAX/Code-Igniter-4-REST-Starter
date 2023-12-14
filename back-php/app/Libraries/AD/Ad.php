<?php

namespace App\Libraries\AD;

use Exception;
use LdapRecord\Connection;

/**
 * Class Ad
 * 
 * This class provides functionality to connect to an Active Directory server.
 * @author Guillaume cornez
 */
class Ad
{
    private $connection;

    /**
     * Ad constructor.
     * 
     * Initializes the Adldap instance with the configuration options.
     */
    public function __construct()
    {

        #region AD configuration
        $options = [
            'hosts' => array(getenv('AD_DOMAIN_CONTROLLER')),
            'base_dn' => getenv('AD_BASE_DN'),
            'username' => getenv('AD_ADMIN_USERNAME') . getenv('AD_ACCOUNT_SUFFIX'),
            'password' => getenv('AD_ADMIN_PASSWORD'),
        ];
    
        $this->InitAldap($options);
        #endregion
    }

    
    /**
     * Connect a user to the AD
     *
     * @param  string $username The username to connect with.
     * @param  string $password The password to connect with.
     * @return bool true if the connection is successful, false otherwise
     */
    public function connect(string $username, string $password)
    {
        if ($this->connection->auth()->attempt($username . getenv('AD_ACCOUNT_SUFFIX'), $password))
            return true;

        return false;    
    }

    /**
     * Initialize the connection to the AD
     * 
     * @return void
     */
    private function InitAldap($options)
    {
        $this->connection = new Connection($options);

        try {
            $this->connection->connect();
        } catch (\LdapRecord\Auth\BindException $e) {
            throw new Exception("Impossible de se connecter à l'Active Directory");
        }
        
    }
}
