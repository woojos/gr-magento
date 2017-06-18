<?php

/**
 * Class Mwojcik_Getresponse_Model_Api_Contact
 */
class Mwojcik_Getresponse_Model_Api_Contact
{
    const GET = 'GET';
    const POST = 'POST';
    const CACHE_KEY = 'getresponse_api';

    /** @var Mwojcik_Getresponse_Model_Api_Core */
    private $coreApi;
    /** @var Zend_Cache_Core */
    private $cache;

    public function __construct()
    {
        $this->coreApi = Mage::getModel('mwojcik_getresponse/api_core');
        $this->cache = Mage::app()->getCache();
    }

    /**
     * @param string $email
     * @param string $campaignId
     * @return bool|object
     */
    public function getContactByEmail($email, $campaignId)
    {
        $cacheKey = md5($email.$campaignId);
        $cachedContact = $this->cache->load($cacheKey);

        if (false !== $cachedContact) {
            return unserialize($cachedContact);
        }

        $query = ['query' => ['email' => urlencode($email), 'campaignId' => $campaignId]];

        $result = (array)$this->coreApi->call(
            'contacts?'.urldecode(http_build_query($query)),
            self::GET
        );

        $contact = array_pop($result);

        $this->cache->save(serialize($contact), $cacheKey, [self::CACHE_KEY], 5*60);
        return $contact;
    }

}