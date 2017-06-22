<?php

/**
 * Class Mwojcik_Getresponse_Model_ObserverTest
 */
class Mwojcik_Getresponse_Model_ObserverTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function shouldSendCustomerToGR()
    {
        $customerModelMock = $this->getMockBuilder(Mage_Customer_Model_Customer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $customerModelMock
            ->expects(self::once())
            ->method('getName')
            ->will(self::returnValue('name'));

        $customerModelMock
            ->expects(self::once())
            ->method('__call')
            ->with('getEmail')
            ->will(self::returnValue('email@gmail.com'));


        $varienEventMock = $this->getMockBuilder(Varien_Event::class)
            ->disableOriginalConstructor()
            ->getMock();

        $varienEventMock
            ->expects(self::once())
            ->method('__call')
            ->with('getCustomer')
            ->willReturn($customerModelMock);

        $varienEventObserverMock = $this->getMockBuilder(Varien_Event_Observer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $varienEventObserverMock
            ->expects(self::once())
            ->method('getEvent')
            ->willReturn($varienEventMock);


        $apiMock = $this->getMockBuilder(Mwojcik_Getresponse_Model_Api_Contact::class)
            ->disableOriginalConstructor()
            ->getMock();

        $apiMock
            ->expects(self::once())
            ->method('createContact');


        $observer = Mage::getModel('mwojcik_getresponse/observer', ['contactApi' => $apiMock]);
        $observer->customerRegisterSuccessHandler($varienEventObserverMock);

    }

}