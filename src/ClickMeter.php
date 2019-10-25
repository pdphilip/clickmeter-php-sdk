<?php
namespace ClickMeterSDK;

use ClickMeterSDK\Traits\HttpClient;
use ClickMeterSDK\Helpers\ShortLinkHasher;

class ClickMeter
{
    use HttpClient;
    
    protected $apiBase = 'https://apiv2.clickmeter.com';
    protected $apiKey;
    public $endPoint;
    public $meta;
    public $body;
    
    public function __construct($apiKey, $apiBase = false)
    {
        $this->apiKey = $apiKey;
        if ($apiBase){
            $this->apiBase = $apiBase;
        }
    }
    
    /*****************************************
     ********   Dedicated  Domains   *********
     *****************************************/
    public function countDomains($options = [])
    {
        $this->endPoint = '/domains/count';
        $this->getCall($options);
        $count = !empty($this->data['count']) ? $this->data['count'] : null;
        return $this->_returnResult($count);
    }
    
    public function getDedicatedDomainIds($options = [])
    {
        $options['type'] = 'dedicated';
        $this->endPoint = '/domains';
        $this->getCall($options);
        $data = isset($this->data['entities']) ? $this->data['entities'] : null;
        return $this->_returnResult($data);
    }
    
    public function createDedicatedDomain($domain, $options = [])
    {
        $this->endPoint = '/domains';
        $options['name'] = $domain;
        $options['type'] = 'dedicated';
        $this->postCall($options);
        return $this->_returnResult();
    }
    
    public function getDomain($domainId, $options = [])
    {
        $this->endPoint = '/domains/'.$domainId;
        $this->getCall($options);
        return $this->_returnResult();
    }
    
    public function updateDedicatedDomain($domainId, $custom404 = false, $customHomepage = false)
    {
        $options['id'] = $domainId;
        $options['name'] = $domainId; // required but does not update
        $options['type'] = 'dedicated';
        
        $custom404 ? $options['custom404'] = $custom404 : false;
        $customHomepage ? $options['customHomepage'] = $customHomepage : false;
        $this->endPoint = '/domains/'.$domainId;
        $this->postCall($options);
        return $this->_returnResult();
    }
    
    public function deleteDomain($domainId)
    {
        $this->endPoint = '/domains/'.$domainId;
        $this->deleteCall();
        return $this->_returnResult();
    }
    
    /*******************************
     ********     Groups    ********
     ******************************/
    
    
    public function countCampaigns($options = [])
    {
        $this->endPoint = '/groups/count';
        $this->getCall($options);
        $count = !empty($this->data['count']) ? $this->data['count'] : null;
        return $this->_returnResult($count);
    }
    
    public function getCampaignIds($options = [])
    {
        $this->endPoint = '/groups';
        $this->getCall($options);
        $data = isset($this->data['entities']) ? $this->data['entities'] : null;
        return $this->_returnResult($data);
    }
    
    public function getCampaign($campaignId, $options = [])
    {
        $this->endPoint = '/groups/'.$campaignId;
        $this->getCall($options);
        return $this->_returnResult();
    }
    
    public function createCampaign($name,$notes = null,$tags = [], $options = [])
    {
        $options['name'] = $name;
        if ($notes){
            $options['notes'] = $notes;
        }
        if ($tags){
            $options['tags'] = [];
            if (is_array($tags)){
                foreach ($tags as $tag){
                    $options['tags'][] = ['name' => $tag];
                }
            }else{
                $options['tags'][] = ['name' => $tags];
            }
        }
        
        
        $this->endPoint = '/groups/';
        $this->postCall($options);
        return $this->_returnResult();
    }
    
    public function updateCampaign($campaignId, $name,$notes = null,$tags = [], $options = [])
    {
        $options['name'] = $name;
        if ($notes){
            $options['notes'] = $notes;
        }
        if ($tags){
            $options['tags'] = [];
            if (is_array($tags)){
                foreach ($tags as $tag){
                    $options['tags'][] = ['name' => $tag];
                }
            }else{
                $options['tags'][] = ['name' => $tags];
            }
        }
        $this->endPoint = '/groups/'.$campaignId;
        $this->postCall($options);
        return $this->_returnResult();
    }
    
    public function deleteCampaign($campaignId)
    {
        $this->endPoint = '/groups/'.$campaignId;
        $this->deleteCall();
        return $this->_returnResult();
    }
    
    public function getCampaignLinks($campaignId, $options = [])
    {
        $this->endPoint = '/groups/'.$campaignId.'/datapoints';
        $this->getCall($options);
        $data = isset($this->data['entities']) ? $this->data['entities'] : null;
        return $this->_returnResult($data);
    }
    
    
    
    
    
    /*******************************
     ********  Data Points  ********
     ******************************/
    
    public function countDataPoints($options = [])
    {
        $this->endPoint = '/datapoints/count';
        $this->getCall($options);
        $count = !empty($this->data['count']) ? $this->data['count'] : null;
        return $this->_returnResult($count);
        
    }
    
    public function getDataPoints($options = [])
    {
        $this->endPoint = '/datapoints';
        $this->getCall($options);
        $data = isset($this->data['entities']) ? $this->data['entities'] : null;
        return $this->_returnResult($data);
    }
    
    public function getDataPoint($id)
    {
        $this->endPoint = '/datapoints/'.$id;
        return $this->getCall();
    }
    
    public function createCampaignLink($campaignId, $domainId, $url, $nameOrInt = null, $title = null, $tags = [], $redirectType = 307,  $options = [])
    {
        $options['type'] = 0; // for tracking link
        $options['groupId'] = $campaignId; // for tracking link
        
        if (!$nameOrInt){
            $options['name'] = ShortLinkHasher::toBase(); //generate
        } elseif (is_int($nameOrInt)){
            $options['name'] = ShortLinkHasher::toBase($nameOrInt);
        }else{
            $options['name'] = $nameOrInt;
        }
        
        if ($title){
            $options['title'] = $title;
        }else{
            $options['title'] = $options['name'];
        }
        if ($tags){
            $options['tags'] = [];
            if (is_array($tags)){
                foreach ($tags as $tag){
                    $options['tags'][] = ['name' => $tag];
                }
            }else{
                $options['tags'][] = ['name' => $tags];
            }
        }
        empty($options['typeTL']['domainId']) ? $options['typeTL']['domainId'] = $domainId : null;
        empty($options['typeTL']['redirectType']) ? $options['typeTL']['redirectType'] = $redirectType : null;
        empty($options['typeTL']['url']) ? $options['typeTL']['url'] = $url : null;
        
        $this->endPoint = '/datapoints';
        $this->postCall($options);
        if ($this->httpStatus == 200){
            $this->data['shortLink'] = '/'.$options['name'] ;
        }
        return $this->_returnResult();
    }
    
    //Not working
    public function getLinkClickData($linkId,$timeFrame = 'beginning',$query = [])
    {
        $query['type'] = 'browsers';
        $query['timeframe'] = $timeFrame;
        $this->endPoint = '/datapoints/'.$linkId.'/reports/';
        $this->getCall($query);
        return $this->_returnResult();
    }
    
    public function deleteLink($linkId)
    {
        $this->endPoint = '/datapoints/'.$linkId;
        $this->deleteCall();
        return $this->_returnResult();
    }
    
    /*******************************
     ********  Reports  ********
     ******************************/
    
    
    
    public function _returnResult($data = false)
    {
        if ($data === false){
            $data = $this->data;
        }
        $result['meta']['status'] = $this->httpStatus;
        $result['meta']['msg'] = $this->httpMsg;
        $result['meta']['date'] = date('Y-m-d H:i:s');
        $result['body'] = $data;
        return $result;
    }
    
}