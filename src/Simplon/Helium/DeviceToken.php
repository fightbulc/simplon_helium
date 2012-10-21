<?php

  namespace Simplon\Helium;

  class DeviceToken
  {
    /** @var DeviceToken */
    private static $_instance;

    /** @var array */
    private $data = array();

    // ##########################################

    /**
     * @return DeviceToken
     */
    public static function init()
    {
      if(! isset(DeviceToken::$_instance))
      {
        DeviceToken::$_instance = new DeviceToken();
      }

      // reset data
      DeviceToken::$_instance->resetData();

      return DeviceToken::$_instance;
    }

    // ##########################################

    /**
     * @return DeviceToken
     */
    protected function resetData()
    {
      $this->data = array();

      return $this;
    }

    // ##########################################

    /**
     * @param $key
     * @param $value
     * @return DeviceToken
     */
    protected function setByKey($key, $value)
    {
      if(! empty($value))
      {
        $this->data[$key] = $value;
      }

      return $this;
    }

    // ##########################################

    /**
     * @param $key
     * @return bool
     */
    protected function getByKey($key)
    {
      if(! isset($this->data[$key]))
      {
        return FALSE;
      }

      return $this->data[$key];
    }

    // ##########################################

    /**
     * @param $jsonData
     * @return DeviceToken
     */
    public function setData($jsonData)
    {
      $this->data = json_decode($jsonData, TRUE);

      return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    public function getData()
    {
      return $this->data;
    }

    // ##########################################

    /**
     * @param $token
     * @return DeviceToken
     */
    public function setToken($token)
    {
      $this->setByKey('token', $token);

      return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    public function getToken()
    {
      return $this->getByKey('token');
    }

    // ##########################################

    /**
     * @param $alias
     * @return DeviceToken
     */
    public function setAlias($alias)
    {
      $this->setByKey('alias', $alias);

      return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    public function getAlias()
    {
      return $this->getByKey('alias');
    }

    // ##########################################

    /**
     * @param $badge
     * @return DeviceToken
     */
    public function setBadge($badge)
    {
      $this->setByKey('badge', $badge);

      return $this;
    }

    // ##########################################

    /**
     * @return int
     */
    public function getBadge()
    {
      return $this->getByKey('badge');
    }

    // ##########################################

    /**
     * @param $start
     * @param $end
     * @return DeviceToken
     */
    public function setQuietTime($start, $end)
    {
      $value = array(
        'start' => $start,
        'end'   => $end
      );

      $this->setByKey('quiettime', $value);

      return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    public function getQuietTime()
    {
      return $this->getByKey('quiettime');
    }

    // ##########################################

    /**
     * @param array $tags
     * @return DeviceToken
     */
    public function setTags(array $tags)
    {
      $this->setByKey('tags', $tags);

      return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    public function getTags()
    {
      return $this->getByKey('tags');
    }

    // ##########################################

    /**
     * @param $timezone
     * @return DeviceToken
     */
    public function setTimezone($timezone)
    {
      $this->setByKey('tz', $timezone);

      return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    public function getTimezone()
    {
      return $this->getByKey('tz');
    }

    // ##########################################

    /**
     * @return string
     */
    public function getLastRegistrationDate()
    {
      return $this->getByKey('last_registration_date');
    }

    // ##########################################

    /**
     * @return bool
     */
    public function getActiveState()
    {
      return $this->getByKey('active');
    }
  }
