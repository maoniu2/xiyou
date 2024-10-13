<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
include './common/main.php';
$strtotime = strtotime("now"); 
$day = 86400*1;//1天

//玩家日志
$opena = 0; // 1为开启，0为关闭
$datewjrz = $strtotime-$day*7; // 保留几天内容，填写及，如填写10，则超过10天的所有记录都会被删除
$datewjrz = date('Y-m-d',$datewjrz);
//后台日志
$openb = 0; // 1为开启，0为关闭
$datehoutai = $strtotime-$day*7; // 保留几天内容，填写及，如填写10，则超过10天的所有记录都会被删除
$datehoutai = date('Y-m-d',$datehoutai);
//网页背包 
$openc = 0; // 1为开启，0为关闭
$datewybb = $strtotime-$day*7; // 保留几天内容，填写及，如填写10，则超过10天的所有记录都会被删除
$datewybb = date('Y-m-d',$datewybb);
//网页背包 (已领取)
$opend = 0; // 1为开启，0为关闭
$datewybbtlq = $strtotime-$day*7; // 保留几天内容，填写及，如填写10，则超过10天的所有记录都会被删除
$datewybbtlq = date('Y-m-d',$datewybbtlq);
//额度记录
$opene = 0; // 1为开启，0为关闭
$edjl = $strtotime-$day*7; // 保留几天内容，填写及，如填写10，则超过10天的所有记录都会被删除
$edjl = date('Y-m-d',$edjl);
//充值记录
$openf = 0; // 1为开启，0为关闭
$czjl = $strtotime-$day*7; // 保留几天内容，填写及，如填写10，则超过10天的所有记录都会被删除
$czjl = date('Y-m-d',$czjl);
//转区申请记录
$openg = 0; // 1为开启，0为关闭
$datezqsq = $strtotime-$day*7; // 保留几天内容，填写及，如填写10，则超过10天的所有记录都会被删除
$datezqsq = date('Y-m-d',$datezqsq);
//玩家账号（已绑定角色）
$openh = 0; // 1为开启，0为关闭
$cleartimea = $strtotime - $day*14; // 保留几天内容，填写及，如填写10，则超过10天的所有记录都会被删除
//玩家账号（未绑定角色）
$openi = 0; // 1为开启，0为关闭
$cleartimeb = $strtotime - $day*3; // 保留几天内容，填写及，如填写10，则超过10天的所有记录都会被删除

//玩家日志
if($opena == 1){
	$checkuserlog = $DB->query("SELECT * FROM `user_log` WHERE `data` LIKE '%".$datewjrz."%' limit 1")->fetch();
	//exit($checkuserlog['id']);
	$sql="DELETE FROM user_log WHERE `id`<'".$checkuserlog['id']."' ";
	$DB->exec($sql);
}
usleep(500);
//玩家账号
if($openh == 1){
$sql="DELETE FROM account WHERE `lastlogin`<'".$cleartimea."'";
$DB->exec($sql);
}
usleep(500);
if($openi == 1){
$sql="DELETE FROM account WHERE `lastlogin`<'".$cleartimeb."' and `bindid`='0'";
$DB->exec($sql);
}
usleep(500);
//后台日志
if($openb == 1){
$checkadminlog = $DB->query("SELECT * FROM `admin_log` WHERE `data` LIKE '%".$datehoutai."%' limit 1")->fetch();
$sql="DELETE FROM admin_log WHERE `id`<'".$checkadminlog['id']."'";
$DB->exec($sql);
}
usleep(500);
//网页背包 
if($openc == 1){
$checkbaglog = $DB->query("SELECT * FROM `bindsbag` WHERE `data` LIKE '%".$datewybb."%' limit 1")->fetch();
$sql="DELETE FROM bindsbag WHERE `id`<'".$checkbaglog['id']."'";
$DB->exec($sql);
}
usleep(500);
//网页背包 (已领取)
if($opend == 1){
$checkbaglog = $DB->query("SELECT * FROM `bindsbag` WHERE `data` LIKE '%".$datewybbtlq."%' limit 1")->fetch();
$sql="DELETE FROM bindsbag WHERE `id`<'".$checkbaglog['id']."' and `status`='1'";
$DB->exec($sql);
}
usleep(500);
//额度记录
if($opene == 1){
$checkedulog = $DB->query("SELECT * FROM `gm_order` WHERE `date` LIKE '%".$edjl."%' limit 1")->fetch();
$sql="DELETE FROM gm_order WHERE `id`<'".$checkedulog['id']."'";
$DB->exec($sql);
}
usleep(500);
//充值记录
if($openf == 1){
$checkpaylog = $DB->query("SELECT * FROM `pay_order` WHERE `date` LIKE '%".$czjl."%' limit 1")->fetch();
$sql="DELETE FROM pay_order WHERE `id`<'".$checkpaylog['id']."'";
$DB->exec($sql);
}
usleep(500);
//转区申请记录 保留8天
if($openg == 1){
$checkuserlog = $DB->query("SELECT * FROM `zqsq_log` WHERE `date` LIKE '%".$datezqsq."%' limit 1")->fetch();
$sql="DELETE FROM zqsq_log WHERE `id`<'".$checkuserlog['id']."'";
$DB->exec($sql);
}
usleep(500);
//结束
echo 'success';
exit;
?>