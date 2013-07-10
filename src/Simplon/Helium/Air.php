<?php

namespace Simplon\Helium;

class Air
{
    /** @var Air */
    private static $_instance;

    /** @var array */
    private $notifications = array();

    /** @var string */
    private $applicationKey;

    /** @var string */
    private $applicationSecret;

    /** @var string */
    private $applicationMasterSecret;

    /** @var string */
    private $apiDomain = 'https://go.urbanairship.com';

    /** @var string */
    private $apiSinglePushUrl = '/api/push/';

    /** @var string */
    private $apiBatchPushUrl = '/api/push/batch/';

    /** @var string */
    private $apiBroadcastUrl = '/api/push/broadcast/';

    /** @var string */
    private $apiDeviceTokenUrl = '/api/device_tokens/';

    // ##########################################

    /**
     * @return Air
     */
    public static function init()
    {
        return new Air();
    }

    // ##########################################

    /**
     * @param $url
     * @return string
     */
    private function _prepareApiUrl($url)
    {
        return trim($url, '/');
    }

    // ##########################################

    /**
     * @param $url
     * @return string
     */
    private function _getCompleteApiUrl($url)
    {
        return $this->getApiDomain() . '/' . $url . '/';
    }

    // ##########################################

    /**
     * @param array $data
     * @return string
     */
    private function _jsonEncodeData(array $data)
    {
        return json_encode($data);
    }

    // ##########################################

    /**
     * @param $domain
     * @return Air
     */
    public function setApiDomain($domain)
    {
        $this->apiDomain = $domain;

        return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    protected function getApiDomain()
    {
        return $this->_prepareApiUrl($this->apiDomain);
    }

    // ##########################################

    /**
     * @param $key
     * @return Air
     */
    public function setApplicationKey($key)
    {
        $this->applicationKey = $key;

        return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    protected function getApplicationKey()
    {
        return $this->applicationKey;
    }

    // ##########################################

    /**
     * @param $secret
     * @return Air
     */
    public function setApplicationSecret($secret)
    {
        $this->applicationSecret = $secret;

        return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    protected function getApplicationSecret()
    {
        return $this->applicationSecret;
    }

    // ##########################################

    /**
     * @param $masterSecret
     * @return Air
     */
    public function setApplicationMasterSecret($masterSecret)
    {
        $this->applicationMasterSecret = $masterSecret;

        return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    protected function getApplicationMasterSecret()
    {
        return $this->applicationMasterSecret;
    }

    // ##########################################

    /**
     * @return string
     */
    private function _getApplicationKeyAndSecretBundled()
    {
        return $this->getApplicationKey() . ':' . $this->getApplicationSecret();
    }

    // ##########################################

    /**
     * @return string
     */
    private function _getApplicationKeyAndMasterSecretBundled()
    {
        return $this->getApplicationKey() . ':' . $this->getApplicationMasterSecret();
    }

    // ##########################################

    /**
     * @param $notifications
     * @return Air
     */
    public function setNotifications($notifications)
    {
        $this->notifications = $notifications;

        return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    protected function getNotifications()
    {
        return $this->notifications;
    }

    // ##########################################

    /**
     * @return array
     */
    protected function getFirstNotification()
    {
        return array_shift($this->notifications);
    }

    // ##########################################

    /**
     * @return Air
     */
    protected function resetNotifications()
    {
        $this->notifications = array();

        return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    public function getApiSinglePushUrl()
    {
        return $this->_prepareApiUrl($this->apiSinglePushUrl);
    }

    // ##########################################

    /**
     * Single push
     */
    public function sendSinglePush()
    {
        return $this->sendPushToApiService($this->getApiSinglePushUrl(), $this->getFirstNotification());
    }

    // ##########################################

    /**
     * @return string
     */
    public function getApiBatchPushUrl()
    {
        return $this->_prepareApiUrl($this->apiBatchPushUrl);
    }

    // ##########################################

    /**
     * Multiple notifications in one request
     */
    public function sendBatchPush()
    {
        return $this->sendPushToApiService($this->getApiBatchPushUrl(), $this->getNotifications());
    }

    // ##########################################

    /**
     * @return string
     */
    public function getApiBroadcastUrl()
    {
        return $this->_prepareApiUrl($this->apiBroadcastUrl);
    }

    // ##########################################

    /**
     * Sends the notification to all device tokens listed remote
     */
    public function sendBroadcastPush()
    {
        return $this->sendPushToApiService($this->getApiBroadcastUrl(), $this->getFirstNotification());
    }

    // ##########################################

    /**
     * @param $serviceUrl
     * @param $data
     * @return mixed
     */
    protected function sendPushToApiService($serviceUrl, $data)
    {
        // reset notifcations
        $this->resetNotifications();

        // prepare data
        $url = $this->_getCompleteApiUrl($serviceUrl);
        $authString = $this->_getApplicationKeyAndMasterSecretBundled();
        $jsonData = $this->_jsonEncodeData($data);

        // echo "$url\n";
        // echo $authString . "\n";
        // echo "$jsonData\n\n";

        // send to api service
        $response = \CURL::init($url)
            ->setUserPwd($authString)
            ->addHttpHeader('Content-type', 'application/json')
            ->setPost(TRUE)
            ->setPostFields($jsonData)
            ->setReturnTransfer(TRUE)
            ->execute();

        return $response;
    }

    // ##########################################

    /**
     * @return string
     */
    public function getApiDeviceTokenUrl()
    {
        return $this->_prepareApiUrl($this->apiDeviceTokenUrl);
    }

    // ##########################################

    /**
     * @param DeviceToken $deviceToken
     * @return mixed
     */
    public function registerDeviceToken(DeviceToken $deviceToken)
    {
        // prepare data
        $serviceUrl = $this->getApiDeviceTokenUrl() . '/' . $deviceToken->getToken();
        $url = $this->_getCompleteApiUrl($serviceUrl);
        $authString = $this->_getApplicationKeyAndSecretBundled();
        $jsonData = $this->_jsonEncodeData($deviceToken->getData());

        // send to api service
        $response = \CURL::init($url)
            ->setUserPwd($authString)
            ->addHttpHeader('Content-type', 'application/json')
            ->setCustomRequest('PUT')
            ->setPostFields($jsonData)
            ->setReturnTransfer(TRUE)
            ->execute();

        return $response;
    }

    // ##########################################

    /**
     * @param $deviceToken
     * @return mixed
     */
    public function getDeviceTokenData($deviceToken)
    {
        // prepare data
        $serviceUrl = $this->getApiDeviceTokenUrl() . '/' . $deviceToken;
        $url = $this->_getCompleteApiUrl($serviceUrl);
        $authString = $this->_getApplicationKeyAndSecretBundled();

        // send to api service
        $response = \CURL::init($url)
            ->setUserPwd($authString)
            ->setReturnTransfer(TRUE)
            ->execute();

        return $response;
    }

    // ##########################################

    /**
     * @return mixed
     */
    public function getDeviceTokensList()
    {
        // prepare data
        $serviceUrl = $this->getApiDeviceTokenUrl();
        $url = $this->_getCompleteApiUrl($serviceUrl);
        $authString = $this->_getApplicationKeyAndSecretBundled();

        // send to api service
        $response = \CURL::init($url)
            ->setUserPwd($authString)
            ->setReturnTransfer(TRUE)
            ->execute();

        return $response;
    }

    // ##########################################

    /**
     * @param $dateSince
     * @return mixed
     */
    public function getDeviceTokensFailed($dateSince)
    {
        // ?since=2009-06-01+13:00:00

        // prepare data
        $serviceUrl = $this->getApiDeviceTokenUrl();
        $url = $this->_getCompleteApiUrl($serviceUrl) . '/feedback/?since=' . $dateSince;
        $authString = $this->_getApplicationKeyAndMasterSecretBundled();

        // send to api service
        $response = \CURL::init($url)
            ->setUserPwd($authString)
            ->setReturnTransfer(TRUE)
            ->execute();

        return $response;
    }

    // ##########################################

    /**
     * @param $deviceToken
     * @return mixed
     */
    public function deleteDeviceToken($deviceToken)
    {
        // prepare data
        $serviceUrl = $this->getApiDeviceTokenUrl() . '/' . $deviceToken;
        $url = $this->_getCompleteApiUrl($serviceUrl);
        $authString = $this->_getApplicationKeyAndSecretBundled();

        // send to api service
        $response = \CURL::init($url)
            ->setUserPwd($authString)
            ->setReturnTransfer(TRUE)
            ->setCustomRequest('DELETE')
            ->execute();

        return $response;
    }
}