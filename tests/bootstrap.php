<?php

require_once('/Users/mwojcik/Sites/platforms/magento_1.9/app/Mage.php');
Mage::app('default');
//Avoid issues "Headers already send"
session_start();