<?php

/**
 * Class Mwojcik_Getresponse_Model_Api_Configuration
 */
class Mwojcik_Getresponse_Model_Api_Configuration
{

    public function checkConnection($apiKey, $env, $domain = '')
    {
        return Mage::getModel('mwojcik_getresponse/api_core')->call(
            $apiKey,
            Mage::helper('mwojcik_getresponse')->getApiUrlForEnvironment($env),
            $domain,
            'accounts',
            'GET'
        );

    }

}