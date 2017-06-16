<?php

class Mwojcik_Getresponse_Model_System_Config_Source_Environment
{

    public function toOptionArray()
    {
        return [
            ['value' => MWojcik_Getresponse_Model_Consts::ENV_MXUS, 'label' => 'MX-US'],
            ['value' => MWojcik_Getresponse_Model_Consts::ENV_MXPL, 'label' => 'MX-PL'],
        ];
    }

}