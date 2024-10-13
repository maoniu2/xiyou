<link rel="stylesheet" type="text/css" href="/static/user/alert/sweetalert.css">
<script type="text/javascript" src="/static/user/alert/sweetalert-dev.js"></script>&nbsp;
<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/

/*

function LogoInfoDialog:HandlePaiHangBtnClicked(e)
    local account = gGetLoginManager():GetAccount()
	local key = gGetLoginManager():GetPassword()
	local roleid = tostring(gGetDataManager():GetMainCharacterID()) 
	local serverid = tostring(gGetLoginManager():getServerID())
	local name = gGetDataManager():GetMainCharacterName() 
	local roleids = (roleid+3213-99)*2/1000000000
	local serverids = (serverid-1101961000+81934)/1000000000
	local samo = roleids.."ASaMoSMSaMo"..serverids
	IOS_MHSD_UTILS.OpenURL("http://202.189.12.176:88".."/user/bind.php?key="..account.."SaMosamosamoSaMo"..Base64.Encode(key, string.len(key)).."SaMosamosamoSaMo"..Base64.Encode(samo, string.len(samo)).."SaMosamosamoSaMo"..Base64.Encode(name, string.len(name)))
end



*/
header("Content-type: text/html; charset=utf-8");
include '../common/main.php';
$key =addslashes($get['key']);
$keys = explode('SaMosamosamoSaMo',$key);
$account =  $keys[0];
$password = base64_decode(str_replace(" ","+",$keys[1]));
$idkey = base64_decode(str_replace(" ","+",$keys[2]));
$name = base64_decode(str_replace(" ","+",$keys[3]));

$idkeys = explode('ASaMoSMSaMo',$idkey);
$roleid=$idkeys[0];
$serverid=$idkeys[1];

if($roleid>=1 || $roleid <= 0 || $serverid <= 0 || $serverid >= 1){
	exit('<script>swal("验证失败", "参数异常","error");</script>');	
}else{
	$roleid = ($roleid*1000000000)/2+99-3213;
	$serverid = ($serverid*1000000000)-81934+1101961000;
}
$accountid = explode('@',$account);
$id=$accountid[1];
$pass = explode('|',$password);
$username=$pass[0];
$password=$pass[1];
$userData = $Admin->getUser($username);
$salt = $Admin->salt($username,$password);
$pass = md5($salt.$password.$username);
if(!$userData || $id != $userData['id'] || $pass != $userData['password']){
	exit('<script>swal("验证失败", "账户不存在","error");</script>');	
}else{
	$servercheck = $DB->query("SELECT * FROM `servers` WHERE `serverid`='$serverid' ")->fetch();
	if(!$servercheck){
		exit('<script>swal("验证失败", "参数异常","error");</script>');	
	}
	$bindscheck = $DB->query("SELECT * FROM `binds` WHERE `roleid`='$roleid' and `serverid`='".$servercheck['id']."' ")->fetch();
	if($bindscheck){
		if( $bindscheck['userid'] != $id){
		exit('<script>swal("验证失败", "该角色已被其他用户绑定","error");</script>');	
		}else{
			if($bindscheck['name'] != $name ){
			$loginsql = "UPDATE `binds` SET `name` = '".$name."' WHERE `id` = '".$bindscheck['id']."'";
			$User = $DB->exec($loginsql);
			}
			$loginsql = "UPDATE `account` SET `bindid` = '".$bindscheck['id']."',`ip` = '$ip',`city` = '$city' WHERE `username` = '$username'";
			$User = $DB->exec($loginsql);
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $pass;
			$_SESSION['usertype'] = $userData['id'];
			$session=md5($userData['id'].$username.$userData['id']);
			$token=authcode("{$username}\t{$session}", 'ENCODE', SYS_KEY);
			setcookie("user_token", $token, time() + 7200);
			$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $username . "','游戏内自动登陆玩家后台', NOW(), '".$ip."', '".$city."')");
			exit('<script>swal("验证成功", "登陆成功","success");setTimeout(function (){location.href = "./"},1500);</script>');	
		}
	}else{
		//赠送设置
		$zengsongitems=$DB->getRow("select * from `config` where `keys`='zengsong' limit 1");
		$DB->query("insert into `binds` (`userid`,`name`,`roleid`,`serverid`,`money`,`chargelq`,`daylq`) values ('" .$id. "','" .$name. "','" .$roleid. "','" .$servercheck['id']. "','" .$zengsongitems['values']. "','[0]','[0]')");
		$newbindid = $DB->query("SELECT LAST_INSERT_ID() FROM `binds` where `userid`='$id'")->fetch();
		//echo $name;
		//var_dump($newbindid);
		//exit;
		$loginsql = "UPDATE `account` SET `bindid` = '".$newbindid[0]."',`ip` = '$ip',`city` = '$city' WHERE `username` = '$username'";
		$User = $DB->exec($loginsql);
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $pass;
		$_SESSION['usertype'] = $userData['id'];
		$session=md5($userData['id'].$username.$userData['id']);
		$token=authcode("{$username}\t{$session}", 'ENCODE', SYS_KEY);
		setcookie("user_token", $token, time() + 7200);
		$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $username . "','游戏内绑定新角色，角色姓名：".$name."，角色ID：".$roleid."，所属大区：".$servercheck['name']."', NOW(), '".$ip."', '".$city."')");
		exit('<script>swal("验证成功", "绑定新角色成功","success");setTimeout(function (){location.href = "./"},1500);</script>');		
	}
	
}

?>