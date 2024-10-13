<?php
/* *
 * 功能：趣游猫云面签异步通知页面
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 */

include 'payconfig.php';
require_once("lib/EpayCore.class.php");
//计算得出通知验证结果
$epay = new EpayCore($epay_config);
$verify_result = $epay->verifyNotify();

if($verify_result) {//验证成功
	//商户订单号
	$out_trade_no = $get['out_trade_no'];
	//彩虹易支付交易号
	$trade_no = $get['trade_no'];
	//交易状态
	$trade_status = $get['trade_status'];
	//支付方式
	$type = $get['type'];
	//支付金额
	$money = $get['money'];
	if ($get['trade_status'] == 'TRADE_SUCCESS') {
		$checkOrder = $DB->query("SELECT * FROM `pay_order` WHERE `orderid` = '".$out_trade_no."' ")->fetch();
		//判断该笔订单是否存在
		if(!$checkOrder){
			exit('订单不存在');
		}
		//判断该笔订单是否已经回调
		if($checkOrder['status']!= 0){
			exit('订单已回调');
		}
		$userData = $Admin->getUser($checkOrder['user']);
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
		$success = '';
		$ptb = $serverData['ptb'] * $money;
		$vipnum = $serverData['vip'] * $money;
		$xianyunum = $serverData['xianyu'] * $money;
		$chargemoney = $serverData['charge'] * $money;
	if($checkOrder['ordertype']==1){
		$flag = ":";
		$flag1 = "\\";
		$flag2 = 'export LANG="zh_CN.UTF-8" && ';
		//检测今日累充
		if($chargemoney != 0){
			$strtotime = strtotime("now"); 
			$date = date('Y-m-d',$strtotime);
			if($bindData['lastday']==$date){
				$sql = " ,`charge`=`charge`+'$chargemoney', `daycharge`=`daycharge`+'$chargemoney'";
				$chargeupsql = "UPDATE `binds` SET `charge`=`charge`+'$chargemoney', `daycharge`=`daycharge`+'$chargemoney' WHERE `id`='".$bindData['id']."' ";
			}else{
				$chargeupsql = "UPDATE `binds` SET `charge`=`charge`+'$chargemoney', `daycharge`='$chargemoney', `lastday`='$date', `daylq`='[0]' WHERE `id`='".$bindData['id']."' ";
			}
			$chargeinfo = ',增加累计：'.$chargemoney;
			$chargeupsqls = $DB->exec($chargeupsql) ;
		}else{
			$chargeinfo = '';
		}
		//平台币增加
		if($ptb != 0){
			$ptbupsql = "UPDATE `binds` SET `money`=`money`+'$ptb' WHERE `id`='".$bindData['id']."' ";
			$ptbupsqls = $DB->exec($ptbupsql) ;
			$ptbinfo = ',增加平台币：'.$ptb;
		}else{
			$ptbinfo = '';
		}
		//赠送VIP经验
		if($vipnum != 0){
			$cmd = $flag2 . 'java -jar ../static/api/jmxc.jar "" "" "127.0.0.1" "' . $serverData['port'] . '" "gm" "userId=4096" "roleId=' . $bindData['roleid'] . '" "addvipexp#' . $vipnum . '"';
			exec($cmd, $out);
			if(!success_cmd($out)){
			$vipinfo = ',未增加VIP经验：'.$vipnum;
			}else{
			$vipinfo = ',已增加VIP经验：'.$vipnum;
			}
		}else{
			$vipinfo = '';
		}
		//赠送元宝
		if($xianyunum != 0){
			$cmd = $flag2 . 'java -jar ../static/api/jmxc.jar "" "" "127.0.0.1" "' . $serverData['port'] . '" "gm" "userId=4096" "roleId=' . $bindData['roleid'] . '" "addqian#3 ' . $xianyunum . '"';
			exec($cmd, $out);
			if(!success_cmd($out)){
			$xianyuinfo = ',未增加元宝：'.$xianyunum;
			}else{
			$xianyuinfo = ',已增加元宝：'.$xianyunum;
			}
		}else{
			$xianyuinfo = '';
		}
		$statusupsql = "UPDATE `pay_order` SET `status`='1' WHERE `orderid`='".$out_trade_no."' ";
		$statusupsql = $DB->exec($statusupsql) ;
		$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $checkOrder['user'] . "','在线充值".$ptbinfo.$vipinfo.$xianyuinfo."', NOW(), '".$ip."', '".$city."')");
		$success='success';
	}else if($checkOrder['ordertype']==2){
		$shopData = $DB->query("SELECT * FROM `rmbshops` WHERE `id` = '".$checkOrder['value']."' ")->fetch();
		//检测今日累充
		$strtotime = strtotime("now"); 
		$date = date('Y-m-d',$strtotime);
		if($bindData['lastday']==$date){
			$sql = " , `daycharge`=`daycharge`+'$chargemoney'";
		}else{
			$sql = " , `daycharge`='$chargemoney', `lastday`='$date', `daylq`='[0]'";
		}
		$chargeupsql = "UPDATE `binds` SET `charge`=`charge`+'$chargemoney'".$sql." WHERE `id`='".$bindData['id']."' ";
		$chargeupsql = $DB->exec($chargeupsql) ;
		
		$DB->query("insert into `bindsbag` (`bindsid`,`name`,`image`,`value`,`status`,`data`,`info`) values ('".$userData['bindid']."','".$shopData['name']."','".$shopData['image']."','".$shopData['itemid'].';'.$shopData['num']."', '0', NOW(), '现金商城' )");
		$statusupsql = "UPDATE `pay_order` SET `status`='1' WHERE `orderid`='".$out_trade_no."' ";
		$statusupsql = $DB->exec($statusupsql) ;
		$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $checkOrder['user'] . "','现金商城购买物品：物品名称".$shopData['name']."', NOW(), '".$ip."', '".$city."')");
		$success='success';
	}else if($checkOrder['ordertype']==3){
		$strtotime = strtotime("now"); 
		$date = date('Y-m-d',$strtotime);
		//检测卡类型
		if($checkOrder['value']==1){
			if($bindData['yk'] < $strtotime){
			$yuekatime =$strtotime+(86400*30);
			$sqls = " , `yk`='$yuekatime' ";
			}else{
			$yk =	2592000;
			$sqls = " , `yk`=`yk`+'$yk'";
			}
			$vipname = '月卡';
		}else if($checkOrder['value']==2){
			if($bindData['zk'] < $strtotime){
			$zhoukatime =$strtotime+(86400*7);
			$sqls = " , `zk`='$zhoukatime' ";
			}else{
			$zk =	604800;
			$sqls = " , `zk`=`zk`+'$zk'";
			}
			$vipname = '周卡';
		}
		//检测今日累充
		if($bindData['lastday']==$date){
			$sql = " , `daycharge`=`daycharge`+'$chargemoney'";
		}else{
			$sql = " , `daycharge`='$chargemoney', `lastday`='$date', `daylq`='[0]'";
		}
		//赠送VIP经验
		if($vipnum != 0){
			$cmd = $flag2 . 'java -jar ../static/api/jmxc.jar "" "" "127.0.0.1" "' . $serverData['port'] . '" "gm" "userId=4096" "roleId=' . $bindData['roleid'] . '" "addvipexp#' . $vipnum . '"';
			exec($cmd, $out);
			if(!success_cmd($out)){
			$vipinfo = ',未增加VIP经验：'.$vipnum;
			}else{
			$vipinfo = ',已增加VIP经验：'.$vipnum;
			}
		}else{
			$vipinfo = '';
		}
		//赠送元宝
		if($xianyunum != 0){
			$cmd = $flag2 . 'java -jar ../static/api/jmxc.jar "" "" "127.0.0.1" "' . $serverData['port'] . '" "gm" "userId=4096" "roleId=' . $bindData['roleid'] . '" "addqian#3 ' . $xianyunum . '"';
			exec($cmd, $out);
			if(!success_cmd($out)){
			$xianyuinfo = ',未增加元宝：'.$xianyunum;
			}else{
			$xianyuinfo = ',已增加元宝：'.$xianyunum;
			}
		}else{
			$xianyuinfo = '';
		}
		$chargeupsql = "UPDATE `binds` SET `charge`=`charge`+'$chargemoney'".$sql.$sqls." WHERE `id`='".$bindData['id']."' ";
		$chargeupsql = $DB->exec($chargeupsql) ;
		$statusupsql = "UPDATE `pay_order` SET `status`='1' WHERE `orderid`='".$out_trade_no."' ";
		$statusupsql = $DB->exec($statusupsql) ;
		$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $checkOrder['user'] . "','开通/续费会员：会员类型".$vipname."', NOW(), '".$ip."', '".$city."')");
		$success='success';
	}else if($checkOrder['ordertype']==4){
		$id = $checkOrder['value'];
		//检查抽奖规则
		$drawscheck = $DB->query("SELECT * FROM `drawrule` WHERE `id` = '$id' ")->fetch();
		//抽取物品
		$names = '';
		//抽奖方法
		function draws($data){
				$i=0;
				$temp=array();
				foreach($data as $v){
				for($i=0;$i<$v['weight'];$i++){
				$temp[]=$v;//放大数组
				}
				}
				$num = count($temp);   //错误修正
				$int=mt_rand(0,$num-1);//获取一个随机数
				$result=$temp[$int];
				return $result;   //返回一维数组
		}
		setlocale(LC_ALL, $locale);
		putenv('LC_ALL=' . $locale);
		for($b=0;$b<$drawscheck['times'];$b++){
			$rs=$DB->query("SELECT * FROM draws order by id ");
			$s=0;
			while($res = $rs->fetch())
			{
				$drawitem[$s]['id']	=$res['id'];
				$drawitem[$s]['name']	=$res['name'];
				$drawitem[$s]['weight']	=$res['value'];
				$s++;
			}
			$goods = draws($drawitem);
			//抽奖结果
			$ro = $goods['id'];//抽奖id
			usleep(2000);
			$drawsData = $DB->query("SELECT * FROM `draws` WHERE `id` = '$ro' ")->fetch();
			//写入背包
			$DB->query("insert into `bindsbag` (`bindsid`,`name`,`image`,`value`,`status`,`data`,`info`) values ('".$userData['bindid']."','".$drawsData['name']."','".$drawsData['image']."','".$drawsData['itemid'].';'.$drawsData['num']."', '0', NOW(), '抽奖系统' )");
			$names = $names.'【'.$drawsData['name'].'】';
			usleep(1500);
			//发送跑马灯
			$notice = '玩家【'.$bindData['name'].'】刚刚在网页抽奖，抽中了奖品【'.$drawsData['name'].'】';
			$cmd = $flag2 . "java -classpath ." . $flag . "../static/api/gsxdb.jar Clients " . $serverData['port'] . " " . $bindData['roleid'] . " post#". $notice;
			exec($cmd, $out);
			usleep(500);
		}
		//赠送VIP经验
		if($vipnum != 0){
			$cmd = $flag2 . 'java -jar ../static/api/jmxc.jar "" "" "127.0.0.1" "' . $serverData['port'] . '" "gm" "userId=4096" "roleId=' . $bindData['roleid'] . '" "addvipexp#' . $vipnum . '"';
			exec($cmd, $out);
			if(!success_cmd($out)){
			$vipinfo = ',未增加VIP经验：'.$vipnum;
			}else{
			$vipinfo = ',已增加VIP经验：'.$vipnum;
			}
		}else{
			$vipinfo = '';
		}
		//赠送元宝
		if($xianyunum != 0){
			$cmd = $flag2 . 'java -jar ../static/api/jmxc.jar "" "" "127.0.0.1" "' . $serverData['port'] . '" "gm" "userId=4096" "roleId=' . $bindData['roleid'] . '" "addqian#3 ' . $xianyunum . '"';
			exec($cmd, $out);
			if(!success_cmd($out)){
			$xianyuinfo = ',未增加元宝：'.$xianyunum;
			}else{
			$xianyuinfo = ',已增加元宝：'.$xianyunum;
			}
		}else{
			$xianyuinfo = '';
		}
		//检测今日累充
		$strtotime = strtotime("now"); 
		$date = date('Y-m-d',$strtotime);
		if($bindData['lastday']==$date){
			$sql = " , `daycharge`=`daycharge`+'$chargemoney'";
		}else{
			$sql = " , `daycharge`='$chargemoney', `lastday`='$date', `daylq`='[0]'";
		}
		$chargeupsql = "UPDATE `binds` SET `charge`=`charge`+'$chargemoney'".$sql." WHERE `id`='".$bindData['id']."' ";
		$chargeupsql = $DB->exec($chargeupsql) ;
		$statusupsql = "UPDATE `pay_order` SET `status`='1' WHERE `orderid`='".$out_trade_no."' ";
		$statusupsql = $DB->exec($statusupsql) ;
		$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $checkOrder['user'] . "','现金抽奖，支付金额：".$drawscheck['money']."，抽中奖品：".$names."', NOW(), '".$ip."', '".$city."')");
		$success='success';
	}
}
	//验证成功返回
	echo $success;
}
else {
	//验证失败
	echo "fail";
}
?>