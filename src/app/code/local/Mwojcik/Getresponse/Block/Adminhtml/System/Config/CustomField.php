<?php

/**
 * Class Mwojcik_Getresponse_Block_Adminhtml_System_Config_CustomField
 */
class Mwojcik_Getresponse_Block_Adminhtml_System_Config_CustomField extends Mage_Core_Block_Html_Select
{

    public function _toHtml()
    {
        $customFields = $this->getCustomFields();

        foreach ($customFields as $customField) {
            $this->addOption($customField['id'], $customField['name']);
        }

        $this->setExtraParams('style="width:200px;"');

        return parent::_toHtml();
    }

    public function setInputName($value)
    {
        return $this->setName($value);
    }

    private function getCustomFields()
    {
        $api = Mage::getModel('mwojcik_getresponse/api_configuration');
        $customFields = $api->getCustomFields();
        $flatCustomFields = [];

        $flatCustomFields[] = [
            'id' => '',
            'name' => '-- none --'
        ];

        foreach ($customFields as $customField) {
            $flatCustomFields[] = [
                'id' => $customField->customFieldId,
                'name' => $customField->name,
            ];
        }

        return $flatCustomFields;
    }


}