<?php

  namespace Simplon\Helium;

  class PushNotification
  {
    /** @var array */
    protected $deviceTokens = array();

    /** @var array */
    protected $excludedDeviceTokens = array();

    /** @var array */
    protected $tags = array();

    /** @var array */
    protected $aliases = array();

    /** @var array */
    protected $datesScheduled = array();

    /** @var string */
    protected $badge;

    /** @var string */
    protected $sound;

    /** @var string */
    protected $message;

    /** @var array */
    protected $extraData = array();

    // ##########################################

    /**
     * @param $deviceTokens
     * @return PushNotification
     */
    public function setDeviceTokens($deviceTokens)
    {
      $this->deviceTokens = $deviceTokens;

      return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    protected function getDeviceTokens()
    {
      return $this->deviceTokens;
    }

    // ##########################################

    /**
     * @param $deviceTokens
     * @return PushNotification
     */
    public function setExcludedDeviceTokens($deviceTokens)
    {
      $this->excludedDeviceTokens = $deviceTokens;

      return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    protected function getExcludedDeviceTokens()
    {
      return $this->excludedDeviceTokens;
    }

    // ##########################################

    /**
     * @param $aliases
     * @return PushNotification
     */
    public function setAliases($aliases)
    {
      $this->aliases = $aliases;

      return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    protected function getAliases()
    {
      return $this->aliases;
    }

    // ##########################################

    /**
     * @param $tags
     * @return PushNotification
     */
    public function setTags($tags)
    {
      $this->tags = $tags;

      return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    protected function getTags()
    {
      return $this->tags;
    }

    // ##########################################

    /**
     * @param $date
     * @return PushNotification
     */
    public function setScheduleDate($date)
    {
      // 2009-06-01+13:00:00
      $this->datesScheduled[] = $date;

      return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    protected function getScheduledDates()
    {
      return $this->datesScheduled;
    }

    // ##########################################

    /**
     * @param $badge
     * @return PushNotification
     */
    public function setBadge($badge)
    {
      $this->badge = $badge;

      return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    protected function getBadge()
    {
      return $this->badge;
    }

    // ##########################################

    /**
     * @param $sound
     * @return PushNotification
     */
    public function setSound($sound)
    {
      $this->sound = $sound;

      return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    protected function getSound()
    {
      return $this->sound;
    }

    // ##########################################

    /**
     * @param $message
     * @return PushNotification
     */
    public function setMessage($message)
    {
      $this->message = (string)$message;

      return $this;
    }

    // ##########################################

    /**
     * @return string
     */
    protected function getMessage()
    {
      return $this->message;
    }

    // ##########################################

    /**
     * @param $key
     * @param $value
     * @return PushNotification
     */
    public function setExtraData($key, $value)
    {
      $this->extraData[$key] = $value;

      return $this;
    }

    // ##########################################

    /**
     * @return array
     */
    protected function getExtraData()
    {
      return $this->extraData;
    }

    // ##########################################

    /**
     * @param $key
     * @return PushNotification
     */
    public function removeExtraData($key)
    {
      if(isset($this->extraData[$key]))
      {
        unset($this->extraData[$key]);
      }

      return $this;
    }

    // ##########################################

    /**
     * @return bool
     */
    protected function hasExtraData()
    {
      return empty($this->extraData) ? FALSE : TRUE;
    }

    // ##########################################

    /**
     * @return array
     */
    public function getData()
    {
      $data = array();

      // set device tokens
      $tokens = $this->getDeviceTokens();

      if(! empty($tokens))
      {
        $data['device_tokens'] = $tokens;
      }

      // set excluded device tokens
      $tokens = $this->getExcludedDeviceTokens();

      if(! empty($tokens))
      {
        $data['exclude_tokens'] = $tokens;
      }

      // set aliases
      $aliases = $this->getAliases();

      if(! empty($aliases))
      {
        $data['aliases'] = $aliases;
      }

      // set tags
      $tags = $this->getTags();

      if(! empty($tags))
      {
        $data['tags'] = $tags;
      }

      // set scheduled dates
      $scheduledDates = $this->getScheduledDates();

      if(! empty($scheduledDates))
      {
        $data['scheduled_for'] = $scheduledDates;
      }

      // handle badge
      $badge = $this->getBadge();

      if(! empty($badge))
      {
        $data['aps']['badge'] = $badge;
      }

      // handle sound
      $sound = $this->getSound();

      if(! empty($sound))
      {
        $data['aps']['sound'] = $sound;
      }

      // handle extraData
      if($this->hasExtraData())
      {
        $data['extra'] = $this->getExtraData();
      }

      // set alert message
      $data['aps']['alert'] = $this->getMessage();

      return $data;
    }
  }
