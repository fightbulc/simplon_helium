<?php

  namespace Simplon\Helium;

  class DeviceToken
  {
    /** @var string */
    private $token = NULL;

    /** @var string */
    private $alias = NULL;

    /** @var int */
    private $badge = 0;

    /** @var array */
    private $tags = array();

    /** @var array */
    private $quietTime = array();

    /** @var string */
    private $timezone = NULL;

    /** @var bool */
    private $activeState = FALSE;

    /** @var string */
    private $lastRegistrationDate;

    // ##########################################

    /**
     * @param $alias
     * @return DeviceToken
     */
    public function setAlias($alias)
    {
      $this->alias = $alias;

      return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    public function getAlias()
    {
      return $this->alias;
    }

    // ##########################################

    /**
     * @param $badge
     * @return DeviceToken
     */
    public function setBadge($badge)
    {
      $this->badge = $badge;

      return $this;
    }

    // ##########################################

    /**
     * @return int
     */
    public function getBadge()
    {
      return $this->badge;
    }

    // ##########################################

    /**
     * @param $start
     * @param $end
     * @return DeviceToken
     */
    public function setQuietTime($start, $end)
    {
      $this->quietTime = array(
        'start' => $start,
        'end'   => $end
      );

      return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    public function getQuietTime()
    {
      return $this->quietTime;
    }

    // ##########################################

    /**
     * @param array $tags
     * @return DeviceToken
     */
    public function setTags(array $tags)
    {
      $this->tags = $tags;

      return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    public function getTags()
    {
      return $this->tags;
    }

    // ##########################################

    /**
     * @param $token
     * @return DeviceToken
     */
    public function setToken($token)
    {
      $this->token = $token;

      return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    public function getToken()
    {
      return $this->token;
    }

    // ##########################################

    /**
     * @param $timezone
     * @return DeviceToken
     */
    public function setTimezone($timezone)
    {
      $this->timezone = $timezone;

      return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    public function getTimezone()
    {
      return $this->timezone;
    }

    // ##########################################

    /**
     * @param $date
     * @return DeviceToken
     */
    public function setLastRegistrationDate($date)
    {
      $this->lastRegistrationDate = $date;

      return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    public function getLastRegistrationDate()
    {
      return $this->lastRegistrationDate;
    }

    // ##########################################

    /**
     * @param $state
     * @return DeviceToken
     */
    public function setActiveState($state)
    {
      $this->activeState = $state;

      return $this;
    }

    // ##########################################

    /**
     * @return bool
     */
    public function getActiveState()
    {
      return $this->activeState;
    }

    // ##########################################

    /**
     * @param $jsonData
     * @return DeviceToken
     */
    public function setData($jsonData)
    {
      $data = json_decode($jsonData, TRUE);

      // set token
      if(! is_null($data['device_token']))
      {
        $this->setToken($data['device_token']);
      }

      // set alias
      if(! is_null($data['alias']))
      {
        $this->setAlias($data['alias']);
      }

      // set tags
      if(! empty($data['tags']))
      {
        $this->setTags($data['tags']);
      }

      // set badge
      $this->setBadge($data['badge']);

      // set quietTime
      if(! is_null($data['quiettime']['start']))
      {
        $this->setQuietTime($data['quiettime']['start'], $data['quiettime']['end']);
      }

      // set timezone
      if(! is_null($data['tz']))
      {
        $this->setTimezone($data['tz']);
      }

      // set lastRegistration
      if(isset($data['last_registration']))
      {
        $this->setLastRegistrationDate($data['last_registration']);
      }

      // set active state
      $this->setActiveState($data['active']);

      return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    public function getData()
    {
      $data = array();

      // alias
      $alias = $this->getAlias();

      if(! empty($alias))
      {
        $data['alias'] = $alias;
      }

      // tags
      $tags = $this->getTags();

      if(! empty($tags))
      {
        $data['tags'] = $tags;
      }

      // badge
      $badge = $this->getBadge();

      if($badge > 0)
      {
        $data['badge'] = $badge;
      }

      // quiet time
      $quietTime = $this->getQuietTime();

      if(! empty($quietTime))
      {
        $data['quietTime'] = $quietTime;
      }

      // timezone
      $timezone = $this->getTimezone();

      if(! empty($timezone))
      {
        $data['tz'] = $timezone;
      }

      return $data;
    }
  }
