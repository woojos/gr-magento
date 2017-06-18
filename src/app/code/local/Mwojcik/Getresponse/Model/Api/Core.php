<?php

/**
 * Class Mwojcik_Getresponse_Model_Api_Core
 */
class Mwojcik_Getresponse_Model_Api_Core
{
    /** @var string */
    private $apiKey;
    /** @var string */
    private $apiUrl;
    /** @var string */
    private $domain;

    public function __construct()
    {
        /** @var Mwojcik_Getresponse_Helper_Data $dataHelper */
        $dataHelper = Mage::helper('mwojcik_getresponse');

        $this->apiKey = $dataHelper->getConfigValue(MWojcik_Getresponse_Model_Consts::CONF_API_KEY);
        $this->apiUrl = $dataHelper->getApiUrlForEnvironment(
            $dataHelper->getConfigValue(MWojcik_Getresponse_Model_Consts::CONF_API_ENV)
        );
        $this->domain = $dataHelper->getConfigValue(MWojcik_Getresponse_Model_Consts::CONF_API_DOMAIN);
    }

    /**
     * @param $api_method
     * @param $http_method
     * @param array $params
     * @return bool|object
     */
    public function call($api_method, $http_method, $params = array())
    {
        return $this->callWithCredentials(
            $this->apiKey,
            $this->apiUrl,
            $this->domain,
            $api_method,
            $http_method,
            $params
        );
    }

    /**
     * @param $api_key
     * @param $api_url
     * @param $domain
     * @param $api_method
     * @param $http_method
     * @param array $params
     * @return bool|object
     */
    public function callWithCredentials($api_key, $api_url, $domain, $api_method, $http_method, $params = array())
    {
        $params = json_encode($params);
        $url = $api_url . $api_method;

        $headers = array(
            'X-Auth-Token: api-key ' . $api_key,
            'Content-Type: application/json',
            'User-Agent: ' . MWojcik_Getresponse_Model_Consts::USER_AGENT,
            'X-APP-ID: ' . MWojcik_Getresponse_Model_Consts::X_APP_ID
        );

        // for GetResponse 360
        if (!empty($domain)) {
            $headers[] = 'X-Domain: ' . $domain;
        }

        //also as get method
        $options = array(
            CURLOPT_URL            => $url,
            CURLOPT_ENCODING       => 'gzip,deflate',
            CURLOPT_FRESH_CONNECT  => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT        => 10,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => $headers
        );

        if ($http_method == 'POST') {
            $options[CURLOPT_POST] = 1;
            $options[CURLOPT_POSTFIELDS] = $params;
        }
        else {
            if ($http_method == 'DELETE') {
                $options[CURLOPT_CUSTOMREQUEST] = 'DELETE';
            }
        }

        $curl = curl_init();
        curl_setopt_array($curl, $options);

        $response = json_decode(curl_exec($curl));

        $this->http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if (!empty($response->codeDescription)) {

            Mage::log(
                sprintf('API: %s method failed: %s (%s)', $api_method, $response->codeDescription, $response->code)
            );

            throw new Mwojcik_Getresponse_Model_Exception_ApiException($response->codeDescription, $response->code);

        } else {
            Mage::log(
                sprintf('API: %s method successed', $api_method)
            );
        }

        return (object)$response;

    }

}