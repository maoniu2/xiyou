<?php
namespace lib;

class Gets
{
    public static function ip()
    {
        if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $ip = getenv('REMOTE_ADDR');
        } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
    }
    public static function get_city($ip)
    {
		$url   = 'http://'.$_SERVER['HTTP_HOST'].'/static/ip/ip.php?action=queryip&ip_url='.$ip;
        $htmls  = file_get_contents($url);
		$htmla  = iconv(  "gb2312" ,"UTF-8", $htmls);
		$citys = explode('所在地为：',$htmla);
        $city  = $citys[1];
        return $city;
    }
	public static function device()
    {
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		if(stristr($_SERVER['HTTP_USER_AGENT'],'Android')) {
			return 'Android';
		}else if(stristr($_SERVER['HTTP_USER_AGENT'],'IPhone')){
			return 'IPhone';
		}else if(stristr($_SERVER['HTTP_USER_AGENT'],'Linux')){
			return 'Linux';
		}else if(stristr($_SERVER['HTTP_USER_AGENT'],'Windows')){
			return 'Windows';
		}else{
			return 'Other';
		}
	}
	public static function my_ip()
    {
		$url   = 'curl '.$_SERVER['HTTP_HOST'].'/common/lib/my.php';
		exec($url,$out );
		return $out[0];
	}
	public static function get_rand($proArr)
	{
		$result = '';
		$proSum = array_sum($proArr);
		foreach ($proArr as $key => $proCur) {
		$randNum = mt_rand(1, $proSum);
		if ($randNum <= $proCur) {
		$result = $key;
		break;
		} else {
		$proSum -= $proCur;
		}
		}
		unset ($proArr);
		return $result;
	}
}