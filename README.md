<pre>
     _                 _               _          _ _
 ___(_)_ __ ___  _ __ | | ___  _ __   | |__   ___| (_)_   _ _ __ ___
/ __| | '_ ` _ \| '_ \| |/ _ \| '_ \  | '_ \ / _ \ | | | | | '_ ` _ \
\__ \ | | | | | | |_) | | (_) | | | | | | | |  __/ | | |_| | | | | | |
|___/_|_| |_| |_| .__/|_|\___/|_| |_| |_| |_|\___|_|_|\__,_|_| |_| |_|
                |_|
</pre>

# Simplon/Helium

For one of my projects I had the need to talk to Urbain Airship's [Push API](https://docs.urbanairship.com/display/DOCS/Server%3A+iOS+Push+API).  
So, I took today off to write an abstract project as composer package so that its easy to implement in other projects too.

### Setup
Since its a composer package all you need to to do is require it within your composer package definitions:

```json
"require": {
   "simplon/helium": "dev-master"
}
```

If you dont know what ```composer``` is you should have a look at [Composer's Webpage](http://getcomposer.org/doc/00-intro.md).

### Anything else needed?

Since we're relying here on Urban Airship's Push API you should have registered yourself to receive:

- 1x Key
- 1x Secret Key
- 1x Master Secret Key

If you did not register yourself yet just [head over here](https://go.urbanairship.com/accounts/register/) and register for Urbain Airship's.  
The basic plan is free and offers 1,000,000 free notifications / month. That gets us started. Sweet!

## A Simple Example

### 1. Add Device Token
The simplest creation of a device token would be as followed:

```php
// API keys
$key = '12345';
$secret = '12345';

// device token entity
$deviceToken = '111111222233344455AAABBBCCCDDDD';
$deviceToken = new \Simplon\Helium\DeviceToken();
$deviceToken->setToken($deviceToken);

// remote register device token
$response = \Simplon\Helium\Air::getInstance()
     ->setApplicationKey($key)
     ->setApplicationSecret($secret)
     ->registerDeviceToken($ndk);
```

You're cool if your response results in "OK". If not, dont worry you're still cool but your token didn't get registered unfortunately.  
Make sure that you used the correct authentication keys.

### 2. Send Push Notification
Based on the device token we just registered we can now send a notification to the device via:

```php
// API keys
$key = '12345';
$secret = '12345';
$master = '12345';

// push notification entity
$pushNotifications = array();
$pn = new \Simplon\Helium\PushNotification();
$pushNotifications[] = $pn
     ->setDeviceTokens(array('111111222233344455AAABBBCCCDDDD'))
     ->setMessage("Howdy!")
     ->getData();

// send push to UA's API
$response = \Simplon\Helium\Air::getInstance()
     ->setApplicationKey($key)
     ->setApplicationSecret($secret)
     ->setApplicationMasterSecret($master)
     ->setNotifications($pushNotifications)
     ->sendSinglePush();
```

If all went through your response should result in something like:  
```json
{ "push_id": "12345-1ad5-11e2-b16d-001b21ce3d90" }
```

Meanwhile you also should have received your push notification on your device.

## An Example with more options
Well, as always there is more. Registering/managing a device token offers the following other options:

```php
$deviceToken = new \Simplon\Helium\DeviceToken();
$deviceToken
     ->setToken('111111222233344455AAABBBCCCDDDD')
     ->setAlias('USER_ID')
     ->setTags(array('tag1', 'tag2'))
     ->setBadge(5)
     ->setQuietTime('22:00', '8:00')
     ->setTimezone('Europe/Berlin');
```

Now, if we come back to sending a push notification to our device we can use the ```alias``` instead of the ```deviceToken```:

```php
// API keys
$key = '12345';
$secret = '12345';
$master = '12345';

// push notification entity
$pushNotifications = array();
$pn = new \Simplon\Helium\PushNotification();
$pushNotifications[] = $pn
     ->setAliases(array('USER_ID'))
     ->setMessage("Howdy again!")
     ->getData();

// send push to UA's API
$response = \Simplon\Helium\Air::getInstance()
     ->setApplicationKey($key)
     ->setApplicationSecret($secret)
     ->setApplicationMasterSecret($master)
     ->setNotifications($pushNotifications)
     ->sendSinglePush();
```

We also could have used ```setTags(array('tag1'))``` to define our notification recipients.

## Manage a Device Token
### Get device data from remote (UA)
Explanation comes soon. If you cannot wait have a look in to the code.

### Update device data
Explanation comes soon. If you cannot wait have a look in to the code.

### Unregister a device
Explanation comes soon. If you cannot wait have a look in to the code.

### Get all device tokens
Explanation comes soon. If you cannot wait have a look in to the code.

### Get inactive device tokens
Explanation comes soon. If you cannot wait have a look in to the code.

## Send/Manage a Push Notification
Explanation comes soon. If you cannot wait have a look in to the code.

# License
Simplon/Helium is freely distributable under the terms of the MIT license.

Copyright (c) 2012 Tino Ehrich

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.