<?php
namespace ClickMeterSDK;

use ClickMeterSDK\Traits\HttpClient;

class ClickMeter
{
    use HttpClient;
    
    protected $apiBase = 'http://apiv2.clickmeter.com';
    protected $apiKey;
    protected $endPoint;
    
    public function __construct($apiKey, $apiBase = false)
    {
        $this->apiKey = $apiKey;
        if ($apiBase){
            $this->apiBase = $apiBase;
        }
    }
    
    public function test()
    {
        $this->endPoint = '/account/plan';
        return $this->getCall();
    }
    
    
}