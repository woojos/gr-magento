<?php

/**
 * Class Mwojcik_Getresponse_Model_Observer
 */
class Mwojcik_Getresponse_Model_Observer
{
    /** @var Mwojcik_Getresponse_Model_Api_Contact */
    private $contactApi;
    /** @var Mwojcik_Getresponse_Helper_Data */
    private $dataHelper;

    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->contactApi = isset($params['contactApi']) ? $params['contactApi'] : Mage::getModel('mwojcik_getresponse/api_contact');
        $this->dataHelper = isset($params['dataHelper']) ? $params['dataHelper'] : Mage::helper('mwojcik_getresponse');
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function addProductToCartHandler(Varien_Event_Observer $observer)
    {
        if (false === $this->canHandleCartEvent()) {
            return;
        }
    }


    private function canHandleCartEvent()
    {
        return false;

        /* Is customer logged in ? */
        if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
            return false;
        }

        /* Is plugin and e-commerce active ? */
        if (1 != (int)Mage::helper('mwojcik_getresponse')->getConfigValue(MWojcik_Getresponse_Model_Consts::CONF_IS_ACTIVE) ||
            1 != (int)Mage::helper('mwojcik_getresponse')->getConfigValue(MWojcik_Getresponse_Model_Consts::CONF_ECOMMERCE_IS_ACTIVE)) {
            return false;
        }

        /** @var Mage_Customer_Model_Customer $customer */
        $customer = Mage::getSingleton('customer/session')->getCustomer();

        $response = $this->contactApi->getContactByEmail(
            $customer->getEmail(),
            $this->dataHelper->getConfigValue(MWojcik_Getresponse_Model_Consts::CONF_CAMPAIGN_ID)
        );

        if (!isset($response->contactId)) {
            return false;
        }
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function customerRegisterSuccessHandler(Varien_Event_Observer $observer)
    {
        $payload = Mage::getModel('mwojcik_getresponse/customer_payload')
            ->createFromCustomer($observer->getEvent()->getCustomer());


        $this->contactApi->createContact($payload);
    }

}