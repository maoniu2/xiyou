<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>正在为您跳转到支付页面，请稍候...</title>
	<style type="text/css">
body{margin:0;padding:0}
p{position:absolute;left:50%;top:50%;height:35px;margin:-35px 0 0 -160px;padding:20px;font:bold 16px/30px "宋体",Arial;text-indent:40px;border:1px solid #c5d0dc}
#waiting{font-family:Arial}
	</style>
</head>
<body>
<?php
include 'payconfig.php';
require_once("lib/EpayCore.class.php");
$strtotime = strtotime("now"); 
$date = date('Y-m-d',$strtotime);
$time = date('H:i:s',$strtotime);
function short_md5($str) 
{
	return substr(md5($str), 8, 16);
}
//异步回调
$notify_url = "http://".$_SERVER['HTTP_HOST']."/pay/notify.php";
//同步回调
$return_url = "http://".$_SERVER['HTTP_HOST']."/user/return.php";
//商户订单号
$out_trade_no =  "Pay".$strtotime.short_md5($strtotime);
//支付方式（可传入alipay,wxpay,qqpay,bank,jdpay）
//检测
$username = $_SESSION['username'];
$userData = $Admin->getUser($username);
if(!$userData){
exit('参数错误');
}
$bindData = $Admin->getBind($userData['id'],$userData['bindid']);
if(!$bindData){
exit('参数错误');
}
$serverData = $DB->query("SELECT * FROM `servers` WHERE `id` = '".$bindData['serverid']."' ")->fetch();
if(!$serverData){
exit('参数错误');
}
//分类
$type = addslashes($get['type']);
$types = addslashes($get['types']);
if($types == 1){
//商品名称
$name = '平台币';
//付款金额
$money = addslashes($get['money']);
if($money == 'on'){
$money = addslashes($get['setmoney']);
}
//平台币数量
$value = $money * $serverData['ptb'];
}else if($types == 2){
$id = addslashes($get['id']);
$rmbshopsData = $DB->query("SELECT * FROM `rmbshops` WHERE `id` = '".$id."' ")->fetch();
if(!$rmbshopsData){
exit('商品不存在');
}
//商品名称
$name = $rmbshopsData['name'];
//平台币数量
$money = $rmbshopsData['price'];
$value = $id;
}else if($types == 3){
$id = addslashes($get['id']);
if($id == 1){
$vipsData = $DB->query("SELECT * FROM `config` WHERE `keys` = 'yueka' ")->fetch();
$name = '月卡';
}else if($id == 2){
$vipsData = $DB->query("SELECT * FROM `config` WHERE `keys` = 'zhouka' ")->fetch();
$name = '周卡';
}
//商品名称
//平台币数量
$money = $vipsData['values'];
$value = $id;
}else if($types == 4){
$id = addslashes($get['id']);
$drawData = $DB->query("SELECT * FROM `drawrule` WHERE `id` = '".$id."' ")->fetch();
$name = '抽奖';
//商品名称
//平台币数量
$money = $drawData['money'];
$value = $id;
}else{
exit('参数错误');
}
$checkOrder = $DB->query("SELECT * FROM `pay_order` WHERE `orderid` = '".$out_trade_no."' ")->fetch();
if($checkOrder){
exit('此订单已存在');
}
$checkAgent = $DB->query("SELECT * FROM `admin` WHERE `id` = '".$userData['agentid']."' ")->fetch();
if($checkOrder){
exit('上级代理信息错误');
}
//构建订单
$agents = explode(';',$checkAgent['lastuid']);
$agent = '['.$checkAgent['id'].'];'.$agents[1];
$DB->query("insert into `pay_order` (`orderid`,`ordertype`,`value`,`user`,`roleid`,`rolename`,`qu`,`agent`,`money`,`status`,`ip`,`city`,`date`,`time`) values ('$out_trade_no','$types','$value', '".$username."', '".$bindData['roleid']."', '".$bindData['name']."','".$bindData['serverid']."', '".$agent."', '".$money."', '0', '".$ip."', '".$city."', '".$date."', '".$time."')");
//exit($money);
/************************************************************/

//构造要请求的参数数组，无需改动
$parameter = array(
	"pid" => $epay_config['pid'],
	"type" => $type,
	"notify_url" => $notify_url,
	"return_url" => $return_url,
	"out_trade_no" => $out_trade_no,
	"name" => $name,
	"money"	=> $money,
	"sitename"	=> $name,
);

//建立请求
$epay = new EpayCore($epay_config);
$html_text = $epay->pagePay($parameter);
echo $html_text;

?>
<p>正在为您跳转到支付页面，请稍候...</p>
</body>
</html>