<?php

namespace App\Libraries\AD;

use Exception;
use Adldap\Adldap;

/**
 * Class Ad
 * 
 * This class provides functionality to connect to an Active Directory server.
 * @author Guillaume cornez
 */
class Ad
{
    private $adldap;
    private $adProvider;

    /**
     * Ad constructor.
     * 
     * Initializes the Adldap instance with the configuration options.
     */
    public function __construct()
    {
        #region AD configuration
        $options = array(
            'account_suffix'        => getenv('AD_ACCOUNT_SUFFIX'),
            'base_dn'               => getenv('AD_BASE_DN'),
            'domain_controllers'    => array(getenv('AD_DOMAIN_CONTROLLER')),
            'admin_username'        => getenv('AD_ADMIN_USERNAME'),
            'admin_password'        => getenv('AD_ADMIN_PASSWORD')
        );
        $this->InitAldap();
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
        try {
            $ad = new Adldap();
            $ad->addProvider([
                'hosts'             => array(getenv('AD_DOMAIN_CONTROLLER')),
                'base_dn'           => getenv('AD_BASE_DN'),
                'account_suffix'    => getenv('AD_ACCOUNT_SUFFIX'),
                'username'          => $username . getenv('AD_ACCOUNT_SUFFIX'),
                'password'          => $password,
            ]);
            $provider = $ad->connect();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Initialize the connection to the AD
     * 
     * @return void
     */
    private function InitAldap()
    {
        $this->adldap = new Adldap();
        $config  = array(
            'hosts'             => array(getenv('AD_DOMAIN_CONTROLLER')),
            'base_dn'           => getenv('AD_BASE_DN'),
            'account_suffix'    => getenv('AD_ACCOUNT_SUFFIX'),
            'username'          => getenv('AD_ADMIN_USERNAME') . getenv('AD_ACCOUNT_SUFFIX'),
            'password'          => getenv('AD_ADMIN_PASSWORD')
        );
        $this->adldap->addProvider($config);
        $this->adProvider = $this->adldap->connect();
    }
}
