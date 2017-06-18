<?php

/**
 * Class Mwojcik_Getresponse_ConfigurationController
 */
class Mwojcik_Getresponse_ConfigurationController extends Mage_Adminhtml_Controller_Action
{

    const RESPONSE_STATUS_FAILED = 'failed';
    const RESPONSE_STATUS_OK = 'ok';

    public function checkAction()
    {
        try {
            $this->validate();

            $apiKey = Mage::app()->getRequest()->getParam('api_key');
            $isEnterprise = Mage::app()->getRequest()->getParam('is_enterprise');
            $env = Mage::app()->getRequest()->getParam('env');
            $domain = Mage::app()->getRequest()->getParam('domain');

            if (0 == $isEnterprise) {
                $env = MWojcik_Getresponse_Model_Consts::ENV_SMB;
            }

            Mage::getModel('mwojcik_getresponse/api_configuration')->checkConnection($apiKey, $env, $domain);
            $this->sendResponse('Connected!', self::RESPONSE_STATUS_OK);

        } catch (Mwojcik_Getresponse_Model_Exception_ValidationException $e) {
            $this->sendResponse($e->getMessage(), self::RESPONSE_STATUS_FAILED);
        } catch (Mwojcik_Getresponse_Model_Exception_ApiException $e) {
            $this->sendResponse($e->getMessage(), self::RESPONSE_STATUS_FAILED);
        }

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

    /**
     * @param string $message
     * @param string $responseStatus
     * @return Zend_Controller_Response_Abstract
     */
    private function sendResponse($message, $responseStatus)
    {
        return $this->getResponse()
            ->setBody(Mage::helper('core')->jsonEncode(
                array(
                    'status' => $responseStatus,
                    'message' => $message
                )));
    }
}