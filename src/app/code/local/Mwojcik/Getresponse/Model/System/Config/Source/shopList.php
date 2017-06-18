<?php

class Mwojcik_Getresponse_Model_System_Config_Source_ShopList
{

    public function toOptionArray()
    {
        try {
            $shopList = (array)Mage::getModel('mwojcik_getresponse/api_configuration')->getShopList();
        } catch (Mwojcik_Getresponse_Model_Exception_ApiException $e) {
            return [
                ['value' => 'error', 'label' => 'Couldn\'t get shops']
            ];
        }

        $simpleList = [];

        foreach ($shopList as $shop) {
            $simpleList[] = ['value' => $shop->shopId, 'label' => $shop->name];
        }

        return $simpleList;
    }

}
