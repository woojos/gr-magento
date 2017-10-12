<?php

/**
 * Class Mwojcik_Getresponse_Model_Api_Configuration
 */
class Mwojcik_Getresponse_Model_Api_Configuration
{

    const GET = 'GET';
    const POST = 'POST';

    /** @var Mwojcik_Getresponse_Model_Api_Core */
    private $coreApi;
    /** @var Mwojcik_Getresponse_Helper_Data */
    private $dataHelper;

    public function __construct()
    {
        $this->coreApi = Mage::getModel('mwojcik_getresponse/api_core');
        $this->dataHelper = Mage::getModel('mwojcik_getresponse/api_core');
    }

    public function checkConnection($apiKey, $env, $domain = '')
    {
        return $this->coreApi->callWithCredentials(
            $apiKey,
            $this->dataHelper->getApiUrlForEnvironment($env),
            $domain,
            'accounts',
            self::GET
        );
    }

    public function getCampaignList()
    {
        return $this->coreApi->call('campaigns', self::GET);
    }

    public function getShopList()
    {
        return $this->coreApi->call('shops', self::GET);
    }

    public function getCustomFields()
    {
        return $this->coreApi->call('custom-fields', self::GET);
    }

}