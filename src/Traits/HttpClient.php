<?php
namespace ClickMeterSDK\Traits;

use GuzzleHttp\Client;

trait HttpClient{
    
    public $xRateLimitRemaining;
    public $xRateLimitReset;
    public $httpStatus;
    public $httpMsg;
    public $data = null;
    
    public function postCall($data)
    {
        $client = new Client();
        try{
            $response = $client->post($this->_buildUrl(),[
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                    'X-Clickmeter-Authkey' => $this->apiKey
                ],
                'body' => json_encode($data),
            ]);
            
            $this->xRateLimitRemaining = $response->getHeader('X-Rate-Limit-Remaining');
            $this->xRateLimitReset = $response->getHeader('X-Rate-Limit-Reset');
            $this->httpStatus = $response->getStatusCode();
            $this->httpMsg = $response->getReasonPhrase();
            $this->data = $response->getBody();
            $this->_formatBody();
        }catch (\Exception $e ){
            
            $this->httpStatus = 404;
            $this->httpMsg = $e->getMessage();
        }
        return $this->_sanitiseReturnResult();
    }
    
    public function patchCall($data)
    {
        $client = new Client();
        try{
            $response = $client->patch($this->_buildUrl(),[
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                    'X-Clickmeter-Authkey' => $this->apiKey
                ],
                'body' => json_encode($data),
            ]);
            
            $this->xRateLimitRemaining = $response->getHeader('X-Rate-Limit-Remaining');
            $this->xRateLimitReset = $response->getHeader('X-Rate-Limit-Reset');
            $this->httpStatus = $response->getStatusCode();
            $this->httpMsg = $response->getReasonPhrase();
            $this->data = $response->getBody();
            $this->_formatBody();
        }catch (\Exception $e ){
            
            $this->httpStatus = 404;
            $this->httpMsg = $e->getMessage();
        }
        return $this->_sanitiseReturnResult();
    }
    
    public function getCall($query = [])
    {
        $client = new Client();
        
        try{
            $response = $client->get($this->_buildUrl(),[
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                    'X-Clickmeter-Authkey' => $this->apiKey
                ],
                'query' => $query
            ]);
            $this->xRateLimitRemaining = $response->getHeader('X-Rate-Limit-Remaining');
            $this->xRateLimitReset = $response->getHeader('X-Rate-Limit-Reset');
            $this->httpStatus = $response->getStatusCode();
            $this->httpMsg = $response->getReasonPhrase();
            $this->data = $response->getBody();
            $this->_formatBody();
        }catch (\Exception $e ){
            
            $this->httpStatus = 404;
            $this->httpMsg = $e->getMessage();
        }
        return $this->_sanitiseReturnResult();
        
    }
    
    public function deleteCall()
    {
        $client = new Client();
        
        try{
            $response = $client->delete($this->_buildUrl(),[
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                    'X-Clickmeter-Authkey' => $this->apiKey
                ],
            ]);
            $this->xRateLimitRemaining = $response->getHeader('X-Rate-Limit-Remaining');
            $this->xRateLimitReset = $response->getHeader('X-Rate-Limit-Reset');
            $this->httpStatus = $response->getStatusCode();
            $this->httpMsg = $response->getReasonPhrase();
            $this->data = $response->getBody();
            $this->_formatBody();
        }catch (\Exception $e ){
            
            $this->httpStatus = 404;
            $this->httpMsg = $e->getMessage();
        }
        return $this->_sanitiseReturnResult();
        
    }
    
    
    protected function _formatBody(){
        if ($this->data){
            if ($this->_isJson($this->data)){
                $this->data = json_decode($this->data);
            }
            if ($this->data){
                $this->data = (array)$this->data;
            }
        }
        
    }
    
    protected function _isJson($string) {
        if (is_array($string)){
            return false;
        }
        json_decode($string,false);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    
    protected function _buildUrl()
    {
        return $this->apiBase.''.$this->endPoint;
    }
    
    public function _sanitiseReturnResult()
    {
        unset($this->apiKey);
        return $this;
        
    }
}