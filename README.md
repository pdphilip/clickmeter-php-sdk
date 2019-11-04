# clickmeter-php-sdk
PHP SDK for the Clickmeter.com API

Install
--------------
    $ composer require pdphilip/clickmeter-php-sdk dev-master




Basics & generic calls
--------------
    
```php
use ClickMeterSDK\ClickMeter;

// Instantiate Clickmeter Object
$clickMeter = new ClickMeter('CLICKMETER_API_KEY');

//Sample Post (create a tracking link)
$options['type'] = 0; // 0 => tracking link
$options['groupId'] = '{campaignId}';
$options['name'] = 'my-short-link';
$options['title'] = 'My Tracking link';
$options['typeTL']['domainId'] = '{domainId}';
$options['typeTL']['url'] = 'https://my-domain.com/come-here';
$clickMeter->endPoint = '/datapoints';
$clickMeter->postCall($options);

//Sample Get (get tracking links)
$clickMeter->endPoint = '/datapoints';
$clickMeter->getCall(['limit' => 20]);

//Sample Patch
$optipon = ['stuff'];
$clickMeter->endPoint = '/datapoints/batch';
$clickMeter->patchCall($data);

//Sample Delete
$clickMeter->endPoint = 'datapoints/{ID}';
$clickMeter->deleteCall();
```


Built in helper methods 
> These will be updated over time
--------------
```php

use ClickMeterSDK\ClickMeter;

$clickMeter = new ClickMeter('CLICKMETER_API_KEY');

//Domains
$clickMeter->countDomains($options = []);
$clickMeter->getDedicatedDomainIds($options = []);
$clickMeter->createDedicatedDomain($domain, $options = []);
$clickMeter->getDomain($domainId, $options = []);
$clickMeter->updateDedicatedDomain($domainId, $custom404 = false, $customHomepage = false);
$clickMeter->deleteDomain($domainId);

//Campaigns (groups)
$clickMeter->countCampaigns($options = []);
$clickMeter->getCampaignIds($options = []);
$clickMeter->getCampaign($campaignId, $options = []);
$clickMeter->createCampaign($name, $notes = null, $tags = [], $options = []);
$clickMeter->updateCampaign($campaignId, $name, $notes = null, $tags = [], $options = []);
$clickMeter->deleteCampaign($campaignId);
$clickMeter->getCampaignLinks($campaignId,$options = []);

//Links (Data points)
$clickMeter->countDataPoints($options = []);
$clickMeter->getDataPoints($options = []);
$clickMeter->getDataPoint($id);
$clickMeter->createCampaignLink($campaignId, $domainId, $url, $nameOrInt = null, $title = null, $tags = [], $redirectType = 307,  $options = []);
$clickMeter->getLinkClickSteam($linkId,$filter = 'uniques',$pageSize = 500,$query = []);
$clickMeter->deleteLink($linkId);

//Reports (to come)

```


