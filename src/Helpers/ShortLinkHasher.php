<?php
namespace ClickMeterSDK\Helpers;

/**
 * Class ShortLinkHasher
 *
 */
class ShortLinkHasher {
    
    private static $base = 'cq4mklnhgjyxov783rp1swzb5f9t026d';
    private static $baseTime = 1572000000;
    
    public static function toBase($value = null,$baseTime = null)
    {
        $b = 32;
        if (!$value){
            $value = time() - (!empty($baseTime) ? $baseTime : static::$baseTime);
        }else{
            $value += 100;
        }
        
        $r = $value  % $b;
        $result = static::$base[$r];
        $q = floor($value / $b);
        while ($q)
        {
            $r = $q % $b;
            $q = floor($q / $b);
            $result = static::$base[$r].$result;
        }
        
        return strrev($result);
    }
}