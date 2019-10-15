<?php
namespace ClickMeterSDK\Traits;

use GuzzleHttp\Client;

trait HttpClient{
    
    public $httpStatus;
    public $httpMsg;
    public $httpBody = null;
    
    public function postCall($url,$key,$data)
    {
        $client = new Client();
        try{
            $response = $client->post($url,[
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                    'X-Clickmeter-Authkey' => $key
                ],
                'body' => \GuzzleHttp\json_encode($data),
            ]);
            
            $this->httpStatus = $response->getStatusCode();
            $this->httpMsg = $response->getReasonPhrase();
            $this->httpBody = $response->getBody();
            $this->_formatBody();
        }catch (\Exception $e ){
            
            $this->httpStatus = 404;
            $this->httpMsg = $e->getMessage();
        }
        return $this;
    }
    
    public function getCall($url,$key,$query = false)
    {
        $client = new Client();
        
        try{
            $response = $client->get($url,[
                'headers' => [
                    'Content-Type' => 'application/json; charset=utf-8',
                    'X-Clickmeter-Authkey' => $key
                ],
                'query' => $query
            ]);
            $this->httpStatus = $response->getStatusCode();
            $this->httpMsg = $response->getReasonPhrase();
            $this->httpBody = $response->getBody();
            $this->_formatBody();
        }catch (\Exception $e ){
            
            $this->httpStatus = 404;
            $this->httpMsg = $e->getMessage();
        }
        return $this;
        
    }
    
    protected function _formatBody(){
        if ($this->httpBody){
            if (isJson($this->httpBody)){
                $this->httpBody = \GuzzleHttp\json_decode($this->httpBody);
            }
            if ($this->httpBody){
                $this->httpBody = objectToArray($this->httpBody);
            }
        }
        
    }

}


