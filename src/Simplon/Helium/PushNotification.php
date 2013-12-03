<?php

namespace Simplon\Helium;

class PushNotification
{
    /** @var PushNotification */
    protected static $_instance;

    /** @var array */
    protected $_data = array();

    protected $_android = false;
    protected $_aps = false;
    protected $_alert = NULL;
    protected $_extra = NULL;

    // ##########################################

    /**
     * @return PushNotification
     */
    public static function init()
    {
        return new PushNotification();
    }

    // ##########################################

    /**
     * @param $key
     * @param $value
     * @return PushNotification
     */
    protected function _setByKey($key, $value)
    {
        $this->_data[$key] = $value;

        return $this;
    }

    // ##########################################

    /**
     * @param $key
     * @return bool|mixed
     */
    protected function _getByKey($key)
    {
        if (!isset($this->_data[$key])) {
            return FALSE;
        }

        return $this->_data[$key];
    }

    // ##########################################

    /**
     * @param $key
     * @return array
     */
    protected function _getByKeyArrayElement($key)
    {
        $cached = $this->_getByKey($key);

        if (!is_array($cached)) {
            $cached = array();
        }

        return $cached;
    }

    // ##########################################

    /**
     * @param $jsonData
     * @return PushNotification
     */
    public function setData($jsonData)
    {
        $this->_data = json_decode($jsonData, TRUE);

        return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    public function getData()
    {
        if ($this->_aps)
        {
            $this->_setApsElementByKey('alert', $this->_getAlert());
            if ($this->_getExtra() !== NULL)
            {
                $this->_setApsElementByKey('extra', $this->_getExtra());
            }
        }
        if ($this->_android)
        {
            $this->_setAndroidElementByKey('alert', $this->_getAlert());
            if ($this->_getExtra() !== NULL)
            {
                $this->_setAndroidElementByKey('extra', $this->_getExtra());
            }
        }

        return $this->_data;
    }

    // ##########################################

    /**
     * @param array $deviceTokens
     * @return PushNotification
     */
    public function setDeviceTokens(array $deviceTokens)
    {
        $this->_aps = true;
        $this->_setByKey('device_tokens', $deviceTokens);

        return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    protected function _getDeviceTokens()
    {
        return $this->_getByKey('device_tokens');
    }

    // ##########################################

    /**
     * @param array $apids
     * @return $this
     */
    public function setApids(array $apids)
    {
        $this->_android = true;
        $this->_setByKey('apids', $apids);

        return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    protected function _getApids()
    {
        return $this->_getByKey('apids');
    }

    // ##########################################

    /**
     * @param array $deviceTokens
     * @return PushNotification
     */
    public function setExcludedDeviceTokens(array $deviceTokens)
    {
        $this->_setByKey('exclude_tokens', $deviceTokens);

        return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    protected function _getExcludedDeviceTokens()
    {
        return $this->_getByKey('exclude_tokens');
    }

    // ##########################################

    /**
     * @param array $aliases
     * @return PushNotification
     */
    public function setAliases(array $aliases)
    {
        $this->_setByKey('aliases', $aliases);

        return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    protected function _getAliases()
    {
        return $this->_getByKey('aliases');
    }

    // ##########################################

    /**
     * @param $tags
     * @return PushNotification
     */
    public function setTags(array $tags)
    {
        $this->_setByKey('tags', $tags);

        return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    protected function _getTags()
    {
        return $this->_getByKey('tags');
    }

    // ##########################################

    /**
     * @param $date
     * @return PushNotification
     */
    public function setScheduledFor($date)
    {
        $cached = $this->_getByKey('scheduled_for');

        // catch empty value
        if (!is_array($cached)) {
            $cached = array();
        }

        // 2009-06-01+13:00:00
        $cached[] = $date;

        $this->_setByKey('scheduled_for', $cached);

        return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    protected function _getScheduledFor()
    {
        return $this->_getByKey('scheduled_for');
    }

    // ##########################################

    /**
     * @param $key
     * @param $value
     * @return PushNotification
     */
    protected function _setApsElementByKey($key, $value)
    {
        $cached = $this->_getByKeyArrayElement('aps');

        $cached[$key] = $value;

        $this->_setByKey('aps', $cached);

        return $this;
    }

    // ##########################################

    /**
     * @param $key
     * @return bool
     */
    protected function _getApsElementByKey($key)
    {
        $cached = $this->_getByKeyArrayElement('aps');

        if (!isset($cached[$key])) {
            return FALSE;
        }

        return $cached[$key];
    }

    // ##########################################

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    protected function _setAndroidElementByKey($key, $value)
    {
        $cached = $this->_getByKeyArrayElement('android');

        $cached[$key] = $value;

        $this->_setByKey('android', $cached);

        return $this;
    }

    // ##########################################

    /**
     * @param $key
     * @return bool
     */
    protected function _getAndroidElementByKey($key)
    {
        $cached = $this->_getByKeyArrayElement('android');

        if (!isset($cached[$key])) {
            return FALSE;
        }

        return $cached[$key];
    }

    // ##########################################

    /**
     * @param $badge
     * @return PushNotification
     */
    public function setBadge($badge)
    {
        $this->_setApsElementByKey('badge', $badge);

        return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    protected function _getBadge()
    {
        return $this->_getApsElementByKey('badge');
    }

    // ##########################################

    /**
     * @param $sound
     * @return PushNotification
     */
    public function setSound($sound)
    {
        $this->_setApsElementByKey('sound', $sound);

        return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    protected function _getSound()
    {
        return $this->_getApsElementByKey('badge');
    }

    // ##########################################

    /**
     * @param $alert
     * @return PushNotification
     */
    public function setAlert($alert)
    {
        $this->_alert = $alert;

        return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    protected function _getAlert()
    {
        return $this->_alert;
    }

    // ##########################################

    /**
     * @param array|null $extra
     *
     * @return $this
     */
    public function setExtra($extra)
    {
        if (is_array($extra))
        {
            $this->_extra = $extra;
        }

        else
        {
            $this->_extra = NULL;
        }

        return $this;
    }

    // ##########################################

    protected function _getExtra()
    {
        return $this->_extra;
    }

    // ##########################################

    /**
     * @param $key
     * @param $value
     * @return PushNotification
     */
    protected function _setMetadataElementByKey($key, $value)
    {
        $cached = $this->_getByKeyArrayElement('metadata');

        $cached[$key] = $value;

        $this->_setByKey('metadata', $cached);

        return $this;
    }

    // ##########################################

    /**
     * @param $key
     * @return PushNotification
     */
    protected function _removeMetadataElementByKey($key)
    {
        $cached = $this->_getByKeyArrayElement('metadata');

        if (isset($cached[$key])) {
            unset($cached[$key]);
        }

        $this->_setByKey('metadata', $cached);

        return $this;
    }

    // ##########################################

    /**
     * @param $key
     * @return bool
     */
    protected function _getMetadataElementByKey($key)
    {
        $cached = $this->_getByKeyArrayElement('metadata');

        if (!isset($cached[$key])) {
            return FALSE;
        }

        return $cached[$key];
    }

    // ##########################################

    /**
     * @param $key
     * @param $value
     * @return PushNotification
     */
    public function setMetadata($key, $value)
    {
        $this->_setMetadataElementByKey($key, $value);

        return $this;
    }

    // ##########################################

    /**
     * @param $key
     * @return mixed
     */
    protected function _getMetadataByKey($key)
    {
        return $this->_getMetadataByKey($key);
    }

    // ##########################################

    /**
     * @param $key
     * @return PushNotification
     */
    public function removeMetadataByKey($key)
    {
        $this->_removeMetadataElementByKey($key);

        return $this;
    }
}
