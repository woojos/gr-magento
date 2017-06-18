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

    public function __construct()
    {
        $this->contactApi = Mage::getModel('mwojcik_getresponse/api_contact');
        $this->dataHelper = Mage::helper('mwojcik_getresponse');
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function addProductToCartHandler(Varien_Event_Observer $observer)
    {
        if (false === $this->canHandleCartEvent()) {
            return;
        }

        // pobierz koszyk z gra

        // get product from cart

    }


    private function canHandleCartEvent()
    {
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

}