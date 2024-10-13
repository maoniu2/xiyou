<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
include './common/main.php';
$act=isset($get['act'])?daddslashes($get['act']):null;
switch($act){
    case 'login':
		$username = addslashes($post['username']);
		$password = addslashes($post['password']);
        if ($username=='' || $password=='') {
            exit('{"code":0,"msg":"请确保账号密码都不为空"}');
        }
		//验证
		$userData = $Admin->getUser($username);
        if(empty($userData))exit('{"code":0,"msg":"此账户不存在"}');
		$salt = $Admin->salt($username,$password);
		if($salt != $userData['salt'])exit('{"code":0,"msg":"验证失败"}');
		$pass = md5($salt.$password.$username);
		//var_dump($pass);exit();
        if($pass != $userData['password'])exit('{"code":0,"msg":"密码错误"}');
        $loginsql = "UPDATE `account` SET `ip` = '$ip',`device` = '$device',`city` = '$city' WHERE `username` = '$username'";
		$User = $DB->exec($loginsql);
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $pass;
		$_SESSION['usertype'] = $userData['id'];
		$session=md5($userData['id'].$username.$userData['id']);
		$token=authcode("{$username}\t{$session}", 'ENCODE', SYS_KEY);
		setcookie("user_token", $token, time() + 7200);
		$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $username . "','网页手动登陆玩家后台', NOW(), '".$ip."', '".$city."')");
		$bindData = $Admin->getBind($userData['id'],$userData['bindid']);
        if(empty($bindData)){
        exit('{"code":1,"msg":"此账户尚未绑定任何角色，请先进游戏绑定！"}');
		}else{
        exit('{"code":2,"msg":"登录成功，请稍后..."}');
		}
    break;
    case 'reg':
		$username = addslashes($post['username']);
		$password = addslashes($post['password']);
		$invite = addslashes($post['invite']);
        if ($username=='' || $password=='') {
            exit('{"code":0,"msg":"请确保账号密码都不为空"}');
        }
        if ($invite=='') {
            exit('{"code":0,"msg":"邀请码不能为空"}');
        }
		if( mb_strlen($username) < "6" ||  mb_strlen($username) > "18" )exit('{"code":0,"msg":"注册失败,账号长度必须为6-18位!"}');
		if( mb_strlen($password) < "6" ||  mb_strlen($password) > "18" )exit('{"code":0,"msg":"注册失败,密码长度必须为6-18位!!"}');
		if(!preg_match("/^[a-zA-Z0-9]*$/", $username))exit('{"code":0,"msg":"注册失败,账号必须是大小写字母或者数字!"}');
		if(!preg_match("/^[a-zA-Z0-9]*$/", $password))exit('{"code":0,"msg":"注册失败,密码必须是大小写字母或者数字!"}');
		$invite = $Admin->getAgentId($invite);
        if(empty($invite))exit('{"code":0,"msg":"邀请码不正确"}');
        if($invite['status'] != 1)exit('{"code":0,"msg":"邀请码已失效"}');
		$adminData = $Admin->getUser($username);
        if(!empty($adminData))exit('{"code":0,"msg":"此账户已经存在"}');
		//IP限制
		$limitAccount=$DB->getRow("select * from `config` where `keys`='limitAccount' limit 1");
		if($limitAccount['values'] != 0){
		//判定IP
		$checkip = $DB->query("SELECT * FROM `reg_ip` WHERE `ip` = '$ip' limit 1")->fetch();
        if($checkip['times'] != NULL && $checkip['times'] >= $limitAccount['values'] )exit('{"code":0,"msg":"注册IP超过限制"}');
		if($checkip){
			$iplist = "UPDATE `reg_ip` SET `times` = `times` + '1' WHERE `ip` = '$ip'";
			$iplists = $DB->exec($iplist);
		}else{
			$DB->query("insert into `reg_ip` (`ip`,`times`) values ('" . $ip . "', '1')");
		}
		}
		//
		$salt = $Admin->salt($username,$password);
		$pass = md5($salt.$password.$username);
		//写入数据库
		$addUser = $Admin->addUser($username,$pass,$salt,$invite['id'],$ip,$city);
		$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $username . "','成功创建账号，账号为：".$username."，密码为：".$password."', NOW(), '".$ip."', '".$city."')");
        exit('{"code":"1","msg":"注册成功"}');
    break;
    case 'logout':
		setcookie("user_token");
		unset($_SESSION['username']);
		unset($_SESSION['password']);
		unset($_SESSION['usertype']);
		unset($_SESSION['UserLogin']);
		header('Location:./');
        exit;
    break;
    default:
        exit('{"code":-4,"msg":"No Act"}');
    break;
}
?>