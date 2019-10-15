<?php
namespace ClickMeterSDK;

use ClickMeterSDK\Traits\HttpClient;

class ClickMeter
{
    use HttpClient;
    
    private $apiBase = 'http://apiv2.clickmeter.com';
    private $apiKey;
    private $endPoint;
    
    public function __construct($apiKey, $apiBase = false)
    {
        $this->apiKey = $apiKey;
        if ($apiBase){
            $this->apiBase = $apiBase;
        }
    }
    
    public function test()
    {
        $this->endPoint = '/account';
        return $this->getCall($this->_buildUrl(),$this->apiKey);
        
    }
    
    //private function ===========================================
    private function _buildUrl()
    {
        return $this->apiBase.''.$this->endPoint;
    }

}