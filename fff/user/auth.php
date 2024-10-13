<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
include '../common/main.php';
if(isset($_COOKIE["user_token"])){
	$token=authcode(daddslashes($_COOKIE['user_token']), 'DECODE', SYS_KEY);
	list($username, $newpass) = explode("\t", $token);
	$userData = $Admin->getUser($username);
	$session=md5($userData['id'].$username.$userData['id']);
	if($session != $newpass) {
			header('Location:../ajax.php?act=logout');
			//var_dump('2');
		exit;
	}else{
		if(isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_SESSION['usertype'])){
			$usernamenew = $_SESSION['username'];
			$passwordnew = $_SESSION['password'];
			if($usernamenew !== $username || $passwordnew !== $userData['password']){
			header('Location:../ajax.php?act=logout');
			/*
			echo $usernamenew.'<br>';
			echo $username.'<br>';
			echo $passwordnew.'<br>';
			echo $userData['password'].'<br>';
			setcookie("user_token");
			print_r($_COOKIE);
			//var_dump('3');
			*/
			exit;
			}else{
			//正常进入
			$bindData = $Admin->getBind($userData['id'],$userData['bindid']);
			if(empty($bindData)){
			header('Location:../ajax.php?act=logout');
			exit;
			}
			$serverData = $Admin->getServer($bindData['serverid']);
			if(empty($serverData)){
			header('Location:../ajax.php?act=logout');
			exit;
			}
			//时间
			$_SESSION['UserLogin'] = '1';
			$strtotime = strtotime("now"); 
			$date = date('Y-m-d',$strtotime);
			//网站信息
			$title=$DB->getRow("select * from `config` where `keys`='title' limit 1");
			$keywords=$DB->getRow("select * from `config` where `keys`='keywords' limit 1");
			$description=$DB->getRow("select * from `config` where `keys`='description' limit 1");
			$openings=$DB->getRow("select * from `config` where `keys`='opening' limit 1");
			$opening = explode(';', $openings['values']);
			//exit($_SESSION['UserLogin']);
			}
		}else{
			header('Location:../ajax.php?act=logout');
			//var_dump('4');
			exit;
		}
	}
}else{
	header('Location:../ajax.php?act=logout');
	//var_dump($_SESSION['type']);
	exit;
}
?>