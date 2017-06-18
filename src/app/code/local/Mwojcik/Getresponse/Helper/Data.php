<?php

/**
 * Class Mwojcik_Getresponse_Helper_Data
 */
class Mwojcik_Getresponse_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * @param string $env
     * @return string
     */
    public function getApiUrlForEnvironment($env)
    {
        switch ($env) {
            case MWojcik_Getresponse_Model_Consts::ENV_SMB :
                return MWojcik_Getresponse_Model_Consts::URL_SMB;
            case MWojcik_Getresponse_Model_Consts::ENV_MXPL :
                return MWojcik_Getresponse_Model_Consts::URL_MXPL;
            case MWojcik_Getresponse_Model_Consts::ENV_MXUS :
                return MWojcik_Getresponse_Model_Consts::URL_MXUS;
            default :
                Mage::throwException('Invalid environment for GetResponse extension');
        }
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getConfigValue($key)
    {
        return Mage::getStoreConfig(MWojcik_Getresponse_Model_Consts::CONF_PREFIX . $key);
    }
}