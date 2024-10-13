<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
	header('Content-type:text/html;charset=utf-8');
	if(defined('IN_CRONLITE'))return;
	define('IN_CRONLITE', true);
	define('SYSTEM_ROOT', dirname(__FILE__).'/');
	define('SYS_KEY', 'samo2023mt3qdd666');
	define('ROOT', dirname(SYSTEM_ROOT).'/');
	date_default_timezone_set('PRC');
	exec('date +"%Y-%m-%d %H:%M:%S"',$out);	
	$today = $out[0];
	$Atime = strtotime($out[0]);
	$date = date("Y-m-d",$time);
	$time = date("H:m:s",$time);
	$Btime = $Atime + 300; 
	if(!is_file(__DIR__.'/number.php')){
		exit('核心文件缺失，请立即处理');
	}
	include_once(SYSTEM_ROOT."autoloader.php");
	Autoloader::register();
	//防注入脚本
	require_once('samo.php');
	//检测数据库
	require SYSTEM_ROOT.'config.php';
	try {
		$DB = new PDO("mysql:host={$dbconfig['host']};dbname={$dbconfig['dbname']};port={$dbconfig['port']}",$dbconfig['user'],$dbconfig['pwd']);
	}catch(Exception $e){
		exit('数据库链接失败！');
	}
//引入类
	$DB = new \lib\pdoHelper($dbconfig);
	$Admin = new \lib\adminclass();
	$Gets = new \lib\gets();
//检测版权
	$CheckMysql = $DB->getRow("select * from `config` where `keys`='quyoumao' ");
	if($CheckMysql['values'] != '366067876' ){
		header('Content-type:text/html;charset=utf-8');echo "请先导入数据库";exit();
	}
//引入方法
	include_once(SYSTEM_ROOT."functions.php");
//检测IP
	$onlineip = $Gets->my_ip();
	session_start();
	$ip = $Gets->ip();
	$city = $Gets->get_city($ip);
	$device = $Gets->device();
	$ipblackData = $DB->getRow("select * from `black_ip` where `ip`='".$ip."' ");
	if($ipblackData)exit('</b>此IP禁止访问！</b><br>');
	$qqwxjump=$DB->getRow("select * from `config` where `keys`='qqwxjump' limit 1");
	if($qqwxjump['values'] == 1){
		require_once(ROOT.'/static/qqwxjump/qqwxjump.php');
	}
?>