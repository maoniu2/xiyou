<?php
error_reporting(0);
header("Content-type: text/html; charset=utf8");
	include'../../../common/main.php';
	$sj = base64_decode(file_get_contents('php://input')); 
	$arr = json_decode($sj);
	$username = $arr->account;
	$password = $arr->password;
	$uid = 0;
	if($username =="" || $password ==""){
		exit(base64_encode('{"status":0,"return_code":"fail","return_msg":"账号密码不能为空"}'));
	}
	if( mb_strlen($username) < "6" ||  mb_strlen($username) > "18" )exit(base64_encode('{"status":0,"return_code":"fail","return_msg":"注册失败,账号长度必须为6-18位!!"}'));
	if( mb_strlen($password) < "6" ||  mb_strlen($password) > "18" )exit(base64_encode('{"status":0,"return_code":"fail","return_msg":"注册失败,密码长度必须为6-18位!!"}'));
	if(!preg_match("/^[a-zA-Z0-9]*$/", $username))exit(base64_encode('{"status":0,"return_code":"fail","return_msg":"注册失败,账号必须是大小写字母或者数字"}');
	if(!preg_match("/^[a-zA-Z0-9]*$/", $password))exit(base64_encode('{"status":0,"return_code":"fail","return_msg":"注册失败,密码必须是大小写字母或者数字"}');
	$invite = $Admin->getAgentId($uid);
    if(empty($invite))exit(base64_encode('{"status":0,"return_code":"fail","return_msg":"代理信息不正确"}');
    if($invite['status'] != 1)exit(base64_encode('{"status":0,"return_code":"fail","return_msg":"代理信息非法"}');
	$adminData = $Admin->getUser($username);
    if(!empty($adminData))exit(base64_encode('{"status":0,"return_code":"fail","return_msg":"此账户已经存在"}');
	//IP限制
	$limitAccount=$DB->getRow("select * from `config` where `keys`='limitAccount' limit 1");
	if($limitAccount['values'] != 0){
		//判定IP
		$checkip = $DB->query("SELECT * FROM `reg_ip` WHERE `ip` = '$ip' limit 1")->fetch();
        if($checkip['times'] != NULL && $checkip['times'] >= $limitAccount['values'] )exit(base64_encode('{"status":0,"return_code":"fail","return_msg":"注册IP超过限制"}');
		if($checkip){
			$iplist = "UPDATE `reg_ip` SET `times` = `times` + '1' WHERE `ip` = '$ip'";
			$iplists = $DB->exec($iplist);
		}else{
			$DB->query("insert into `reg_ip` (`ip`,`times`) values ('" . $ip . "', '1')");
		}
	}
	$salt = $Admin->salt($username,$password);
	$pass = md5($salt.$password.$username);
	//写入数据库
	$addUser = $Admin->addUser($username,$pass,$salt,$invite['id'],$ip,$city);
	$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $username . "','成功注册账号，账号为：".$username."，密码为：".$password."', NOW(), '".$ip."', '".$city."')");
	exit(base64_encode('{"status":1,"return_code":"success","return_msg":"注册成功"}');
	
	
?>