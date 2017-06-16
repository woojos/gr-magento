<?php

/**
 * Class Mwojcik_Getresponse_ConfigurationController
 */
class Mwojcik_Getresponse_ConfigurationController extends Mage_Adminhtml_Controller_Action
{

    public function checkAction()
    {
        try {
            $this->validate();
        } catch (Mwojcik_Getresponse_Model_Exception_ValidationException $e) {
            return $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($e->getMessage()));
        }

        $apiKey = Mage::app()->getRequest()->getParam('api_key');
        $isEnterprise = Mage::app()->getRequest()->getParam('is_enterprise');
        $env = Mage::app()->getRequest()->getParam('env');
        $domain = Mage::app()->getRequest()->getParam('domain');


        if (0 == $isEnterprise) {
            $env = MWojcik_Getresponse_Model_Consts::ENV_SMB;
        }

        $response = Mage::getModel('mwojcik_getresponse/api_configuration')->checkConnection($apiKey, $env, $domain);

        //print_r($response);

    }

    /**
     * @throws Mwojcik_Getresponse_Model_Exception_ValidationException
     */
    private function validate()
    {
        $apiKey = Mage::app()->getRequest()->getParam('api_key');
        $isEnterprise = Mage::app()->getRequest()->getParam('is_enterprise');
        $domain = Mage::app()->getRequest()->getParam('domain');

        if (empty($apiKey)) {
            throw new Mwojcik_Getresponse_Model_Exception_ValidationException('Api key cannot be empty.');
        }

        if (1 == $isEnterprise && empty($domain)) {
            throw new Mwojcik_Getresponse_Model_Exception_ValidationException(
                'Domain cannot be empty for enterprise.'
            );
        }

    }
}