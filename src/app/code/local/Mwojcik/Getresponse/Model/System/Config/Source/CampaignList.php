<?php

class Mwojcik_Getresponse_Model_System_Config_Source_CampaignList
{

    public function toOptionArray()
    {
        try {
            $campaignList = (array)Mage::getModel('mwojcik_getresponse/api_configuration')->getCampaignList();
        } catch (Mwojcik_Getresponse_Model_Exception_ApiException $e) {
            return [
                ['value' => 'error', 'label' => 'Couldn\'t get lists']
            ];
        }

        $simpleList = [];

        foreach ($campaignList as $campaign) {
            $simpleList[] = ['value' => $campaign->campaignId, 'label' => $campaign->description];
        }

        return $simpleList;
    }

}