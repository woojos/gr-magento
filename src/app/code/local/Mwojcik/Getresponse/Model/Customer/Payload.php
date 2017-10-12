<?php

class Mwojcik_Getresponse_Model_Customer_Payload
{

    const CUSTOM_ID = 'gr_id';
    const FIELD_NAME = 'magento';

    const F_FIRST_NAME = 'First Name';
    const F_LAST_NAME = 'Last Name';
    const F_MIDDLE_NAME = 'Middle Name';
    const F_DOB = 'Date Of Birth';
    const F_BILLING_STREET = 'Billing Street';
    const F_BILLING_CITY = 'Billing City';
    const F_BILLING_POST_CODE = 'Billing Post Code';
    const F_BILLING_COUNTRY = 'Billing Country';


    /** @var Mwojcik_Getresponse_Helper_Data */
    private $dataHelper;

    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->dataHelper = isset($params['dataHelper']) ? $params['dataHelper'] : Mage::helper('mwojcik_getresponse');
    }

    /**
     * @param Mage_Customer_Model_Customer $customer
     * @return array
     */
    public function createFromCustomer($customer)
    {
        $payload = [
            'name' => $customer->getName(),
            'email' => $customer->getEmail(),
            'campaign' => [
                'campaignId' => $this->dataHelper->getConfigValue(MWojcik_Getresponse_Model_Consts::CONF_CAMPAIGN_ID),
            ]
        ];

        $customFieldValues = [];
        $fieldsMapping = unserialize($this->dataHelper->getConfigValue(MWojcik_Getresponse_Model_Consts:: CONF_FIELDS_MAPPING));

        foreach ($fieldsMapping as $index => $map) {

            if (empty($map[self::CUSTOM_ID])) {
                continue;
            }

            $customFieldValues[] = [
                "customFieldId" => $map[self::CUSTOM_ID],
                "value" => [$this->getFieldValueFromCustomer($customer, $map[self::FIELD_NAME])]
            ];
        }

        if (!empty($customFieldValues)) {
            $payload['customFieldValues'] = $customFieldValues;
        }

        return $payload;
    }

    /**
     * @param Mage_Customer_Model_Customer $customer
     * @param string $fieldName
     * @return string
     */
    private function getFieldValueFromCustomer(Mage_Customer_Model_Customer $customer, $fieldName)
    {
        switch ($fieldName) {
            case self::F_FIRST_NAME :
                return $customer->getFirstname();
            case self::F_LAST_NAME :
                return $customer->getLastname();
            case self::F_MIDDLE_NAME :
                return $customer->getMiddlename();
            case self::F_DOB :
                return $customer->getDob();
            default:
                return '';

            /*
            case self::F_BILLING_CITY :
                return $customer->getDefaultBilling()->getData();
            case self::F_BILLING_STREET :
                return $customer->getDob();
            case self::F_BILLING_COUNTRY :
                return $customer->getDob();
            case self::F_BILLING_POST_CODE :
                return $customer->getDob();
            */
        }
    }



}