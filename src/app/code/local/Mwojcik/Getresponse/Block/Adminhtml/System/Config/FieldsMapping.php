<?php

/**
 * Class Mwojcik_Getresponse_Block_Adminhtml_System_Config_FieldsMapping
 */
class Mwojcik_Getresponse_Block_Adminhtml_System_Config_FieldsMapping extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    /** @var Mage_Core_Block_Abstract */
    protected $_itemRenderer;
    /** @var bool */
    protected $_showDeleteButton = false;
    /** @var array */
    protected $_defaultRows = [];
    /*
     * Set template
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_addAfter = false;
        $this->setTemplate('mwojcik/getresponse/system/config/array.phtml');
    }

    public function _prepareToRender()
    {
        $this->addColumn('magento', array(
            'label' => Mage::helper('mwojcik_getresponse')->__('Magento'),
            'style' => 'width:200px',
        ));
        $this->addColumn('gr_id', array(
            'label' => Mage::helper('mwojcik_getresponse')->__('GetResponse'),
            'renderer' => $this->_getRenderer(),
        ));

        $this->addDefaultRow([
            'magento' => 'Name',
            'gr_id' => 'Name'
        ]);

        $this->addDefaultRow([
            'magento' => 'Email',
            'gr_id' => 'Email'
        ]);

    }

    /**
     * @param array $row
     */
    protected function addDefaultRow($row)
    {
        $this->_defaultRows[] = $row;
    }

    /**
     * @return array
     */
    public function getDefaultRows()
    {
        return $this->_defaultRows;
    }

    /**
     * @return Mage_Core_Block_Abstract
     */
    protected function _getRenderer()
    {
        if (!$this->_itemRenderer) {
            $this->_itemRenderer = $this->getLayout()->createBlock(
                'mwojcik_getresponse/adminhtml_system_config_customField', '',
                array('is_render_to_js_template' => true)
            );
        }
        return $this->_itemRenderer;
    }

    protected function _prepareArrayRow(Varien_Object $row)
    {
        $row->setData(
            'option_extra_attr_' . $this->_getRenderer()
                ->calcOptionHash($row->getData('gr_id')),
            'selected="selected"'
        );
    }


}