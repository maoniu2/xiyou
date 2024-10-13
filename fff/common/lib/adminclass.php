<?php
namespace lib;

class AdminClass
{
    public static function getAdmin($username)
    {
        global $DB;
        return $DB->query("SELECT * FROM `admin` WHERE `username` = '$username' ")->fetch();
    }
    public static function salt($username,$password)
    {
		$a = substr($username,0,3);
		$b = substr($password,1,3);
		$salt = substr(md5($a.$b),16,8);
		return $salt;
    }
    public static function delAdmin($id)
    {
        global $DB;
        return $DB->exec("DELETE FROM `admin` WHERE `id` = '$id'");
    }
    public static function addAdmin($username,$password,$salt,$type,$lastuid,$fencheng,$invite,$lv)
    {
         global $DB;
        return $DB->exec("INSERT INTO `admin`(`username`,`password`,`salt`,`type`,`lastuid`,`fencheng`,`invite`,`ip`,`city`,`lv`)VALUES('".$username."','".$password."','".$salt."','".$type."','".$lastuid."','".$fencheng."','".$invite."','127.0.0.1','系统添加','".$lv."')");
    }
    public static function getUser($username)
    {
        global $DB;
        return $DB->query("SELECT * FROM `account` WHERE `username` = '$username' ")->fetch();
    }
    public static function getUserId($id)
    {
        global $DB;
        return $DB->query("SELECT * FROM `account` WHERE `id` = '$id' ")->fetch();
    }
	public static function getServer($id)
    {
        global $DB;
        return $DB->query("SELECT * FROM `servers` WHERE `id` = '$id' ")->fetch();
    }
	public static function getBind($userid,$bindid)
    {
        global $DB;
        return $DB->query("SELECT * FROM `binds` WHERE `userid` = '$userid' and `id` = '$bindid' ")->fetch();
    }
    public static function getAdminId($id)
    {
        global $DB;
        return $DB->query("SELECT * FROM `admin` WHERE `id` = '$id' limit 1")->fetch();
    }
    public static function getAgentId($invite)
    {
        global $DB;
        return $DB->query("SELECT * FROM `admin` WHERE `invite` = '$invite' limit 1")->fetch();
    }
    public static function addUser($username,$pass,$salt,$invite,$ip,$city)
    {
         global $DB;
        return $DB->exec("INSERT INTO `account`(`username`,`password`,`salt`,`agentid`,`ip`,`city`)VALUES('".$username."','".$pass."','".$salt."','".$invite."','$ip','$city')");
    }
    public static function get_os()
    {
        if (!empty($_SERVER['HTTP_USER_AGENT'])){
            $os = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/win/i', $os)) {
                $os = 'Windows';
            } else if (preg_match('/mac/i', $os)) {
                $os = 'MAC';
            } else if (preg_match('/linux/i', $os)) {
                $os = 'Android';
            } else if (preg_match('/unix/i', $os)) {
                $os = 'Unix';
            } else if (preg_match('/bsd/i', $os)) {
                $os = 'BSD';
            } else {
                $os = 'Other';
            }
            return $os;
        } else {
            return 'unknow';
        }
    }
    public static function browse_info()
    {
        if (!empty($_SERVER['HTTP_USER_AGENT'])){
            $br = $_SERVER['HTTP_USER_AGENT'];
            if (preg_match('/MSIE/i', $br)) {
                $br = 'MSIE';
            } else if (preg_match('/Firefox/i', $br)) {
                $br = 'Firefox';
            } else if (preg_match('/Chrome/i', $br)) {
                $br = 'Chrome';
            } else if (preg_match('/Safari/i', $br)) {
                $br = 'Safari';
            } else if (preg_match('/Opera/i', $br)) {
                $br = 'Opera';
            } else {
                $br = 'Other';
            }
            return $br;
        } else {
            return 'unknow';
        }
    }
    public static function detect_encoding($file='./login.php')
    {
        $list = array('GBK', 'UTF-8', 'UTF-16LE', 'UTF-16BE', 'ISO-8859-1');
        $str = file_get_contents($file);
        foreach ($list as $item) {
            $tmp = mb_convert_encoding($str, $item, $item);
            if (md5($tmp) == md5($str)) {
                return $item;
            }
        }
        return null;
    }
}

