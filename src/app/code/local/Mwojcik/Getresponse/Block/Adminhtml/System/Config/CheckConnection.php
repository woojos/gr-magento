<?php

/**
 * Class Mwojcik_Getresponse_Block_Adminhtml_System_Config_CheckConnection
 */
class Mwojcik_Getresponse_Block_Adminhtml_System_Config_CheckConnection extends Mage_Adminhtml_Block_System_Config_Form_Field
{

    /*
     * Set template
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('mwojcik/getresponse/system/config/check_connection_button.phtml');
    }

    /**
     * @param Varien_Data_Form_Element_Abstract $element
     * @return mixed
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return $this->_toHtml();
    }

    /**
     * Return ajax url for button
     *
     * @return string
     */
    public function getAjaxCheckUrl()
    {
        return Mage::helper('adminhtml')->getUrl('mw-getresponse/configuration/check');
    }

    public function getButtonHtml()
    {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'id'        => 'atwixtweaks_button',
                'label'     => $this->helper('adminhtml')->__('Check Connection'),
                'onclick'   => 'javascript:check(); return false;'
            ));

        return $button->toHtml();
    }
}