<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
error_reporting(0);
header("Content-type: text/html; charset=utf8");
	include'../../../common/main.php';
	$sj = base64_decode(file_get_contents('php://input')); 
	$arr = json_decode($sj);
	$account = $arr->account;
	$password = $arr->password;
	$md5_sign = $arr->md5_sign;
	$game_id = $arr->game_id;
	if($account =="" || $password ==""){
		exit;
	}
	$CheckMysql = $DB->getRow("select * from `account` where `username`='$account' ");
	if(!$CheckMysql){
		$msg = base64_encode('{"status":-1,"return_code":"fail","return_msg":"登录失败，帐号不存在"}');
	}else{
		$salt = $Admin->salt($account,$password);
		$pass = md5($salt.$password.$account);
	if($salt != $CheckMysql['salt'] || $pass != $CheckMysql['password']){
		$msg = base64_encode('{"status":-1,"return_code":"fail","return_msg":"登录失败，密码错误！"}');
	}else{
        $loginSql = "UPDATE `account` SET `device` = '$device',`lsatlogin` = '$Atime' WHERE `username` = '$account'";
		$login = $DB->exec($loginSql);
		$msg = base64_encode('{"status":1,"return_code":"success","return_msg":"登录成功","user_id":"'.$CheckMysql['id'].'","token":"'.$CheckMysql['username'].'|'.$password.'","user_account":"'.$CheckMysql['username'].'"}');
	}
	}
	echo $msg;
?>
