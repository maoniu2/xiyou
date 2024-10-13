<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
include './auth.php';
$act=isset($get['act'])?daddslashes($get['act']):null;
$flag = ":";
$flag1 = "\\";
$flag2 = 'export LANG="zh_CN.UTF-8" && ';
$locale = 'en_US.UTF-8';
//时间
$strtotime = strtotime("now"); 
$date = date('Y-m-d',$strtotime);
switch($act){
    case 'setbind':
		$username = $_SESSION['username'];
		$id = addslashes($post['id']);
        if ($username=='') {
            exit('{"code":0,"msg":"非法操作"}');
        }
		$userData = $Admin->getUser($username);
        if(empty($userData))exit('{"code":0,"msg":"此账户不存在"}');
		$bindData = $Admin->getBind($userData['id'],$id);
        if(empty($bindData))exit('{"code":0,"msg":"此绑定信息不存在"}');
		$serverData = $Admin->getServer($bindData['serverid']);
        if(empty($serverData))exit('{"code":0,"msg":"此区服信息不存在"}');
        $setbindsql = "UPDATE `account` SET `bindid` = '$id' WHERE `username` = '$username'";
		$setbindsql = $DB->exec($setbindsql);
		if(!$setbindsql){
			exit('{"code":0,"msg":"切换角色失败"}');
		}else{
		$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $_SESSION['username'] . "','切换当前使用角色信息，所属大区：".$serverData['name']."，角色名：".$bindData['name']."，角色ID：".$bindData['roleid']."', NOW(), '".$ip."', '".$city."')");
			exit('{"code":1,"msg":"切换角色成功"}');
		}
    break;
    case 'password':
		$newpass = addslashes($post['newpass']);
		$newpassagain = addslashes($post['newpassagain']);
		$username = $_SESSION['username'];
        if ($username=='') {
            exit('{"code":0,"msg":"非法操作"}');
        }
        if ($newpass == null || $newpassagain == null) {
            exit('{"code":0,"msg":"新密码或确认新密码不能为空"}');
        }
        if ($newpass !== $newpassagain) {
            exit('{"code":0,"msg":"两次密码输入不一致"}');
        }
		if( mb_strlen($newpass) < "6" ||  mb_strlen($newpass) > "18" )exit('{"code":0,"msg":"修改失败,密码长度必须为6-18位!!"}');
		if(!preg_match("/^[a-zA-Z0-9]*$/", $newpass))exit('{"code":0,"msg":"修改失败,密码必须是大小写字母或者数字!"}');
		$adminData = $Admin->getUser($username);
        if(empty($adminData))exit('{"code":0,"msg":"此账户不存在"}');
		$salt = $Admin->salt($username,$newpass);
		$pass = md5($salt.$newpass.$username);
        if($pass == $adminData['password'])exit('{"code":0,"msg":"修改失败,新密码与原密码相同！"}');
		$updatepass	= "UPDATE `account` SET `password` = '".$pass."',`salt` = '".$salt."' WHERE `id` = '".$adminData['id']."'";
		$update = $DB->exec($updatepass);
        if(!$update)exit('{"code":0,"msg":"修改失败"}');
		$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $_SESSION['username'] . "','修改新密码，新密码为：".$newpass."', NOW(), '".$ip."', '".$city."')");
		exit('{"code":1,"msg":"修改成功,新密码:'.$newpass.'"}');
    break;
    case 'petzzdingzhi':
		$zizhitype = addslashes($post['zizhitype']);
		$number = addslashes($post['number']);
		$username = $_SESSION['username'];
		if($number == '' || $number <= 0){ exit('{"code":0,"msg":"定制数值不能为空"}');}
		//角色查询
		$userData = $Admin->getUser($username);
        if(empty($userData))exit('{"code":0,"msg":"此账户不存在"}');
		$bindData = $Admin->getBind($userData['id'],$userData['bindid']);
        if(empty($bindData))exit('{"code":0,"msg":"此绑定信息不存在"}');
		$serverData = $Admin->getServer($bindData['serverid']);
        if(empty($serverData))exit('{"code":0,"msg":"此区服信息不存在"}');
		//资质查询
        if ($zizhitype==1) {
			$petvalue1=$DB->getRow("select * from `petzizhi` where `id`='1' limit 1");
			$petvalue2=$DB->getRow("select * from `petzizhi` where `id`='2' limit 1");
			if($number > $petvalue1['value']){ exit('{"code":0,"msg":"定制数值超出限制"}');}
			$price = $number * $petvalue2['value'];
			$cmd = $flag2 . 'java -jar ../static/api/jmxc.jar "" "" "127.0.0.1" "' . $serverData['port'] . '" "gm" "userId=4096" "roleId=' . $bindData['roleid'] . '" "setpetgrow ' . $number . '"';
			$zzname = '成长资质';
        }else  if ($zizhitype==2) {
			$petvalue3=$DB->getRow("select * from `petzizhi` where `id`='3' limit 1");
			$petvalue4=$DB->getRow("select * from `petzizhi` where `id`='4' limit 1");
			if($number > $petvalue3['value']){ exit('{"code":0,"msg":"定制数值超出限制"}');}
			$price = $number * $petvalue4['value'];
			$cmd = $flag2 . 'java -jar ../static/api/jmxc.jar "" "" "127.0.0.1" "' . $serverData['port'] . '" "gm" "userId=4096" "roleId=' . $bindData['roleid'] . '" "setpetattack ' . $number . '"';
			$zzname = '攻击资质';
        }else  if ($zizhitype==3) {
			$petvalue5=$DB->getRow("select * from `petzizhi` where `id`='5' limit 1");
			$petvalue6=$DB->getRow("select * from `petzizhi` where `id`='6' limit 1");
			if($number > $petvalue5['value']){ exit('{"code":0,"msg":"定制数值超出限制"}');}
			$price = $number * $petvalue6['value'];
			$cmd = $flag2 . 'java -jar ../static/api/jmxc.jar "" "" "127.0.0.1" "' . $serverData['port'] . '" "gm" "userId=4096" "roleId=' . $bindData['roleid'] . '" "setpetdefend ' . $number . '"';
			$zzname = '速度资质';
        }else  if ($zizhitype==4) {
			$petvalue7=$DB->getRow("select * from `petzizhi` where `id`='7' limit 1");
			$petvalue8=$DB->getRow("select * from `petzizhi` where `id`='8' limit 1");
			if($number > $petvalue7['value']){ exit('{"code":0,"msg":"定制数值超出限制"}');}
			$price = $number * $petvalue8['value'];
			$cmd = $flag2 . 'java -jar ../static/api/jmxc.jar "" "" "127.0.0.1" "' . $serverData['port'] . '" "gm" "userId=4096" "roleId=' . $bindData['roleid'] . '" "setpetmagic ' . $number . '"';
			$zzname = '法术资质';
        }else  if ($zizhitype==5) {
			$petvalue9=$DB->getRow("select * from `petzizhi` where `id`='9' limit 1");
			$petvalue10=$DB->getRow("select * from `petzizhi` where `id`='10' limit 1");
			if($number > $petvalue9['value']){ exit('{"code":0,"msg":"定制数值超出限制"}');}
			$price = $number * $petvalue10['value'];
			$cmd = $flag2 . 'java -jar ../static/api/jmxc.jar "" "" "127.0.0.1" "' . $serverData['port'] . '" "gm" "userId=4096" "roleId=' . $bindData['roleid'] . '" "setpetphyforce ' . $number . '"';
			$zzname = '体质资质';
        }else  if ($zizhitype==6) {
			$petvalue11=$DB->getRow("select * from `petzizhi` where `id`='11' limit 1");
			$petvalue12=$DB->getRow("select * from `petzizhi` where `id`='12' limit 1");
			if($number > $petvalue11['value']){ exit('{"code":0,"msg":"定制数值超出限制"}');}
			$price = $number * $petvalue12['value'];
			$cmd = $flag2 . 'java -jar ../static/api/jmxc.jar "" "" "127.0.0.1" "' . $serverData['port'] . '" "gm" "userId=4096" "roleId=' . $bindData['roleid'] . '" "setpetspeed ' . $number . '"';
			$zzname = '速度资质';
		}
		//扣除平台币
		$moneys = $bindData['money'] - $price;
		if($moneys < 0)exit('{"code":0,"msg":"平台币不足"}');
		$moneysql = "UPDATE `binds` SET `money` = `money`-'".$price."' WHERE `id` = '".$userData['bindid']."' ";
		$moneysql = $DB->exec($moneysql);
		if(!$moneysql)exit('{"code":0,"msg":"平台币扣除失败"}');
		//执行操作
		exec($cmd, $out);
		if(success_cmd($out)){
			//写入日志
			$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $_SESSION['username'] . "','网页定制宠物资质：".$zzname."，数值：".$number."，扣除平台币：".$price."', NOW(), '".$ip."', '".$city."')");
			//发送跑马灯
			setlocale(LC_ALL, $locale);
			putenv('LC_ALL=' . $locale);
			$notice = '玩家【'.$bindData['name'].'】刚刚在网页后台定制了宠物资质';
			$cmd = $flag2 . "java -classpath ." . $flag . "../static/api/gsxdb.jar Clients " . $serverData['port'] . " " . $bindData['roleid'] . " post#". $notice;
			exec($cmd, $out);
			if(success_cmd($out)){
				exit('{"code":1,"msg":"定制'.$zzname.'成功"}');
			}else{
				exit('{"code":0,"msg":"定制'.$zzname.'成功，公告发送失败"}');
			}
		}else{
			$moneysql = "UPDATE `binds` SET `money` = `money`+'".$price."' WHERE `id` = '".$userData['bindid']."' ";
			$moneysql = $DB->exec($moneysql);
			exit('{"code":0,"msg":"定制'.$zzname.'失败，平台币已返还！"}');
		}
    break;
    case 'zbdz':
		$zhuangbeiid = addslashes($post['zhuangbeiid']);
		$tejiid = addslashes($post['tejiid']);
		$texiaoid = addslashes($post['texiaoid']);
		$username = $_SESSION['username'];
        if ($username=='') {
            exit('{"code":0,"msg":"非法操作1"}');
        }
        if ($texiaoid=='' || $tejiid=='' || $zhuangbeiid=='') {
            exit('{"code":0,"msg":"非法操作2"}');
        }
		$zhuangbeiData = $DB->query("SELECT * FROM `zbdz` WHERE `id` = '".$zhuangbeiid."' ")->fetch();
		$tejiData = $DB->query("SELECT * FROM `zbdz` WHERE `id` = '".$tejiid."' ")->fetch();
		$texiaoData = $DB->query("SELECT * FROM `zbdz` WHERE `id` = '".$texiaoid."' ")->fetch();
		if( !$zhuangbeiData || !$tejiData || !$texiaoData ){
            exit('{"code":0,"msg":"输入信息异常"}');
		}
		$userData = $Admin->getUser($username);
        if(empty($userData))exit('{"code":0,"msg":"此账户不存在"}');
		$bindData = $Admin->getBind($userData['id'],$userData['bindid']);
        if(empty($bindData))exit('{"code":0,"msg":"此绑定信息不存在"}');
		$serverData = $Admin->getServer($bindData['serverid']);
        if(empty($serverData))exit('{"code":0,"msg":"此区服信息不存在"}');
		$allmoney = $zhuangbeiData['price']+$tejiData['price']+$texiaoData['price'];
		$moneys = $bindData['money'] - $allmoney;
		if($moneys < 0)exit('{"code":0,"msg":"平台币不足"}');
		$moneysql = "UPDATE `binds` SET `money` = `money`-'".$allmoney."' WHERE `id` = '".$userData['bindid']."' ";
		$moneysql = $DB->exec($moneysql);
		if(!$moneysql)exit('{"code":0,"msg":"平台币扣除失败"}');
		//定制装备
		$str = 'addsequip'.'#'.$zhuangbeiData['itemid'].'#'.$tejiData['itemid'].'#'.$texiaoData['itemid'].'#'.$taozhuang;
		$gmcmd = str_replace(" ", "#", $str);
        $cmd = $flag2 . "java -classpath ." . $flag . "../static/api/gsxdb.jar Clients " . $serverData['port'] . " " . $bindData['roleid'] ." ". $gmcmd;
        exec($cmd, $out);
		if(success_cmd($out)){
			$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $_SESSION['username'] . "','网页定制装备：".$zhuangbeiData['name']."，特技名称：".$tejiData['name']."，特效名称：".$texiaoData['name']."，扣除平台币：".$allmoney."', NOW(), '".$ip."', '".$city."')");
			//发送跑马灯
			setlocale(LC_ALL, $locale);
			putenv('LC_ALL=' . $locale);
			$notice = '玩家【'.$bindData['name'].'】刚刚在网页后台定制了专属装备';
			$cmd = $flag2 . "java -classpath ." . $flag . "../static/api/gsxdb.jar Clients " . $serverData['port'] . " " . $bindData['roleid'] . " post#". $notice;
			exec($cmd, $out);
			if(success_cmd($out)){
				exit('{"code":1,"msg":"定制成功，请到游戏背包内查看"}');
			}else{
				exit('{"code":0,"msg":"定制成功，公告发送失败，请到游戏背包内查看"}');
			}
		}else{
			$moneysql = "UPDATE `binds` SET `money` = `money`+'".$allmoney."' WHERE `id` = '".$userData['bindid']."' ";
			$moneysql = $DB->exec($moneysql);
			exit('{"code":0,"msg":"定制装备失败，平台币已返还！"}');
		}
    break;
    case 'petskilldingzhi':
		$skillid = addslashes($post['skillid']);
		$username = $_SESSION['username'];
        if ($username=='') {
            exit('{"code":0,"msg":"非法操作1"}');
        }
        if ($skillid=='') {
            exit('{"code":0,"msg":"非法操作2"}');
        }
		$petskilldzData = $DB->query("SELECT * FROM `petskilldz` WHERE `id` = '".$skillid."' ")->fetch();
		if( !$petskilldzData){
            exit('{"code":0,"msg":"输入信息异常"}');
		}
		$userData = $Admin->getUser($username);
        if(empty($userData))exit('{"code":0,"msg":"此账户不存在"}');
		$bindData = $Admin->getBind($userData['id'],$userData['bindid']);
        if(empty($bindData))exit('{"code":0,"msg":"此绑定信息不存在"}');
		$serverData = $Admin->getServer($bindData['serverid']);
        if(empty($serverData))exit('{"code":0,"msg":"此区服信息不存在"}');
		$allmoney = $petskilldzData['price'];
		$moneys = $bindData['money'] - $allmoney;
		if($moneys < 0)exit('{"code":0,"msg":"平台币不足"}');
		$moneysql = "UPDATE `binds` SET `money` = `money`-'".$allmoney."' WHERE `id` = '".$userData['bindid']."' ";
		$moneysql = $DB->exec($moneysql);
		if(!$moneysql)exit('{"code":0,"msg":"平台币扣除失败"}');
		//定制宠物技能
		$cmd = $flag2 . 'java -jar ../static/api/jmxc.jar "" "" "127.0.0.1" "' . $serverData['port'] . '" "gm" "userId=4096" "roleId=' . $bindData['roleid'] . '" "addpetskill ' . $petskilldzData['itemid'] . ' 1 1 "';
        exec($cmd, $out);
		if(success_cmd($out)){
			$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $_SESSION['username'] . "','网页定制宠物技能：".$petskilldzData['name']."，扣除平台币：".$allmoney."', NOW(), '".$ip."', '".$city."')");
			//发送跑马灯
			setlocale(LC_ALL, $locale);
			putenv('LC_ALL=' . $locale);
			$notice = '玩家【'.$bindData['name'].'】刚刚在网页后台定制了专属装备';
			$cmd = $flag2 . "java -classpath ." . $flag . "../static/api/gsxdb.jar Clients " . $serverData['port'] . " " . $bindData['roleid'] . " post#". $notice;
			exec($cmd, $out);
			if(success_cmd($out)){
				exit('{"code":1,"msg":"定制成功"}');
			}else{
				exit('{"code":0,"msg":"定制成功，公告发送失败"}');
			}
		}else{
			$moneysql = "UPDATE `binds` SET `money` = `money`+'".$allmoney."' WHERE `id` = '".$userData['bindid']."' ";
			$moneysql = $DB->exec($moneysql);
			//var_dump( $cmd);
			exit('{"code":0,"msg":"定制宠物技能失败，平台币已返还！"}');
		}
    break;
    case 'buy':
		$id = addslashes($post['id']);
		$username = $_SESSION['username'];
        if ($username=='') {
            exit('{"code":0,"msg":"非法操作"}');
        }
		$shopData = $DB->query("SELECT * FROM `shops` WHERE `id` = '".$id."' ")->fetch();
		if($shopData['status'] !=1 ){
            exit('{"code":0,"msg":"该商品不存在"}');
		}
		$userData = $Admin->getUser($username);
        if(empty($userData))exit('{"code":0,"msg":"此账户不存在"}');
		$bindData = $Admin->getBind($userData['id'],$userData['bindid']);
        if(empty($bindData))exit('{"code":0,"msg":"此绑定信息不存在"}');
		$serverData = $Admin->getServer($bindData['serverid']);
        if(empty($serverData))exit('{"code":0,"msg":"此区服信息不存在"}');
		$moneys = $bindData['money'] - $shopData['price'];
		if($moneys < 0)exit('{"code":0,"msg":"平台币不足"}');
		$moneysql = "UPDATE `binds` SET `money` = `money`-'".$shopData['price']."' WHERE `id` = '".$userData['bindid']."' ";
		$moneysql = $DB->exec($moneysql);
		if(!$moneysql)exit('{"code":0,"msg":"平台币扣除失败"}');
		$DB->query("insert into `bindsbag` (`bindsid`,`name`,`image`,`value`,`status`,`data`,`info`) values ('".$userData['bindid']."','".$shopData['name']."','".$shopData['image']."','".$shopData['itemid'].';'.$shopData['num']."', '0', NOW(), '平台币商城' )");
		$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $_SESSION['username'] . "','商城购买商品：".$shopData['name']."，扣除平台币：".$shopData['price']."', NOW(), '".$ip."', '".$city."')");
		//发送跑马灯
        setlocale(LC_ALL, $locale);
        putenv('LC_ALL=' . $locale);
		$notice = '玩家【'.$bindData['name'].'】刚刚在网页商城购买了商品【'.$shopData['name'].'】';
		$cmd = $flag2 . "java -classpath ." . $flag . "../static/api/gsxdb.jar Clients " . $serverData['port'] . " " . $bindData['roleid'] . " post#". $notice;
        exec($cmd, $out);
		if(success_cmd($out)){
			exit('{"code":1,"msg":"购买成功，请到网页背包查看领取"}');
		}else{
			exit('{"code":0,"msg":"购买成功，公告发送失败，请到网页背包查看领取"}');
		}
    break;
    case 'mobile':
		$username = $_SESSION['username'];
        if ($username=='') {
            exit('{"code":0,"msg":"非法操作"}');
        }
		$userData = $Admin->getUser($username);
        if(empty($userData))exit('{"code":0,"msg":"此账户不存在"}');
		$bindData = $Admin->getBind($userData['id'],$userData['bindid']);
        if(empty($bindData))exit('{"code":0,"msg":"此绑定信息不存在"}');
		$serverData = $Admin->getServer($bindData['serverid']);
        if(empty($serverData))exit('{"code":0,"msg":"此区服信息不存在"}');
		$cmd = $flag2 . 'java -jar ../static/api/jmxc.jar "" "" "127.0.0.1" "' . $serverData['port'] . '" "gm" "userId=4096" "roleId=' . $bindData['roleid'] . '"  "changebindtel ' . $bindData['roleid'] . ' 13266554433"';
		exec($cmd, $out);
		if(success_cmd($out)){
			$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $_SESSION['username'] . "','进行关联手机操作', 	NOW(), '".$ip."', '".$city."')");
			exit('{"code":1,"msg":"关联成功"}');
		}else{
			exit('{"code":0,"msg":"关联失败"}');
		}
    break;
    case 'cdks':
		$username = $_SESSION['username'];
		$codes = addslashes($post['codes']);
        if ($username=='') {
            exit('{"code":0,"msg":"非法操作"}');
        }
        if ($codes=='') {
            exit('{"code":0,"msg":"CDK不能为空"}');
        }
		$userData = $Admin->getUser($username);
        if(empty($userData))exit('{"code":0,"msg":"此账户不存在"}');
		$bindData = $Admin->getBind($userData['id'],$userData['bindid']);
        if(empty($bindData))exit('{"code":0,"msg":"此绑定信息不存在"}');
		$serverData = $Admin->getServer($bindData['serverid']);
        if(empty($serverData))exit('{"code":0,"msg":"此区服信息不存在"}');
		$cdksData = $DB->query("SELECT * FROM `cdks` WHERE `codes` = '".$codes."' ")->fetch();
		if(!$cdksData){
            exit('{"code":0,"msg":"该CDK不存在"}');
		}
		if($cdksData['status']==1){
            exit('{"code":0,"msg":"该CDK已使用"}');
		}
		$money = $cdksData['money'];
		$ptb = $serverData['ptb'] * $money;
		$vipnum = $serverData['vip'] * $money;
		$xianyunum = $serverData['xianyu'] * $money;
		$chargemoney = $serverData['charge'] * $money;
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
		$cdkssql = "UPDATE `cdks` SET `status` = '1' WHERE `id` = '".$cdksData['id']."' ";
		$cdkssql = $DB->exec($cdkssql);
		$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $_SESSION['username'] . "','使用cdk（".$codes."）成功".$ptbinfo.$chargeinfo.$vipinfo.$xianyuinfo."', NOW(), '".$ip."', '".$city."')");
		exit('{"code":1,"msg":"兑换成功，请到日志查看详情"}');
    break;
    case 'fulilingqu':
		$username = $_SESSION['username'];
        if ($username=='') {
            exit('{"code":0,"msg":"非法操作"}');
        }
		$userData = $Admin->getUser($username);
        if(empty($userData))exit('{"code":0,"msg":"此账户不存在"}');
		$bindData = $Admin->getBind($userData['id'],$userData['bindid']);
        if(empty($bindData))exit('{"code":0,"msg":"此绑定信息不存在"}');
		$serverData = $Admin->getServer($bindData['serverid']);
        if(empty($serverData))exit('{"code":0,"msg":"此区服信息不存在"}');
		if($bindData['fuli'] == 1){
			exit('{"code":0,"msg":"此角色已领取过新手福利"}');
		}else{
			$filiData = $DB->query("SELECT * FROM `config` WHERE `keys` = 'fuliitems' ")->fetch();
			if(empty($filiData))exit('{"code":0,"msg":"新手福利配置信息错误"}');
			$fulis = explode(';', $filiData['values']);
			$itemid = $fulis[0];
			$num = $fulis[1];
			$cmd=$flag2.'java -jar ../static/api/jmxc.jar "" "" "127.0.0.1" "'.$serverData['port'].'" "gm" "userId=4096" "roleId='.$bindData['roleid'].'" "mail '.$bindData['roleid'].'#新手福利#网页领取新手福利已到账#0 '.$itemid.'|'.$num.'" ';
			exec($cmd, $out);
			if(success_cmd($out)){
				$fulissql = "UPDATE `binds` SET `fuli` = '1' WHERE `id` = '".$userData['bindid']."' ";
				$fulisql = $DB->exec($fulissql);
				if(!$fulisql)exit('{"code":0,"msg":"修改领取状态失败"}');
					$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $_SESSION['username'] . "','领取新手福利，已经发送至游戏邮件', 	NOW(), '".$ip."', '".$city."')");
				exit('{"code":1,"msg":"领取成功，请到游戏邮件内查看"}');
			}else{
				exit('{"code":0,"msg":"领取失败，请重试"}');
			}
		}
    break;
    case 'bag':
		$type = addslashes($get['type']);
		$username = $_SESSION['username'];
        if ($username=='') {
            exit('{"code":0,"msg":"非法操作"}');
        }
		$userData = $Admin->getUser($username);
        if(empty($userData))exit('{"code":0,"msg":"此账户不存在"}');
		$bindData = $Admin->getBind($userData['id'],$userData['bindid']);
        if(empty($bindData))exit('{"code":0,"msg":"此绑定信息不存在"}');
		$serverData = $Admin->getServer($bindData['serverid']);
        if(empty($serverData))exit('{"code":0,"msg":"此区服信息不存在"}');
		if($type==1){
			$num = addslashes($post['num']);
			$check = $DB->query("SELECT * FROM `bindsbag` WHERE `status`='0' and `bindsid` = '".$bindData['id']."' ")->fetch();
			if(!$check)exit('{"code":0,"msg":"尚无可领取物品"}');
			$rs=$DB->query("SELECT * FROM `bindsbag` WHERE `status`='0' and `bindsid` = '".$bindData['id']."' order by id desc");
			$i=0;
			while($i < $num){
				$res = $rs->fetch();
				$statussql = "UPDATE `bindsbag` SET `status` = '1' WHERE `id` = '".$res['id']."' ";
				$statussql = $DB->exec($statussql);
				if(!$statussql)exit('{"code":0,"msg":"修改领取状态失败"}');
				$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $_SESSION['username'] . "','领取网页背包物品：".$res['name']."', NOW(), '".$ip."', '".$city."')");
				$item = explode(';',$res['value']);
				$cmd = $flag2 . 'java -jar ../static/api/jmxc.jar "" "" "127.0.0.1" "' . $serverData['port'] . '" "gm" "userId=4096" "roleId=' . $bindData['roleid'] . '" "additem ' . $item[0] . ' ' . $item[1] . '" ';
				exec($cmd, $out);
				usleep(5000);
				if(!success_cmd($out)){
					$statussqls = "UPDATE `bindsbag` SET `status` = '0' WHERE `id` = '".$res['id']."' ";
					$statussqls = $DB->exec($statussqls);
					$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $_SESSION['username'] . "','领取失败，返还网页背包物品：".$res['name']."', NOW(), '".$ip."', '".$city."')");
					exit('{"code":0,"msg":"领取失败，剩余物品已返还！"}');
				}
				$i++;
			}
            exit('{"code":1,"msg":"领取最近【'.$num.'】件物品成功"}');
		}else if($type==2){
			$check = $DB->query("SELECT * FROM `bindsbag` WHERE `status`='0' and `bindsid` = '".$bindData['id']."'")->fetch();
			if(!$check)exit('{"code":0,"msg":"尚无可领取物品"}');
				$rs=$DB->query("SELECT * FROM `bindsbag` WHERE `status`='0' and `bindsid` = '".$bindData['id']."' order by id desc");
				$i=0;
				while($res = $rs->fetch()){
				$statussql = "UPDATE `bindsbag` SET `status` = '1' WHERE `id` = '".$res['id']."' ";
				$statussql = $DB->exec($statussql);
				if(!$statussql)exit('{"code":0,"msg":"修改领取状态失败"}');
				$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $_SESSION['username'] . "','领取网页背包物品：".$res['name']."', NOW(), '".$ip."', '".$city."')");
				$item = explode(';',$res['value']);
				$cmd = $flag2 . 'java -jar ../static/api/jmxc.jar "" "" "127.0.0.1" "' . $serverData['port'] . '" "gm" "userId=4096" "roleId=' . $bindData['roleid'] . '" "additem ' . $item[0] . ' ' . $item[1] . '" ';
				//$cmd=$flag2.'java -jar ../static/api/jmxc.jar "" "" "127.0.0.1" "'.$serverData['port'].'" "gm" "userId=4096" "roleId='.$bindData['roleid'].'" "mail '.$bindData['roleid'].'#网页背包#网页背包领取#0 '.$item[0].'|'.$item[1].'" ';

				exec($cmd, $out);
				usleep(5000);
				if(!success_cmd($out)){
					$statussqls = "UPDATE `bindsbag` SET `status` = '0' WHERE `id` = '".$res['id']."' ";
					$statussqls = $DB->exec($statussqls);
					$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $_SESSION['username'] . "','领取失败，返还网页背包物品：".$res['name']."', NOW(), '".$ip."', '".$city."')");
				exit('{"code":0,"msg":"领取失败，剩余物品已返还！"}');
				}
				$i++;
			}
            exit('{"code":1,"msg":"领取剩余【'.$i.'】件物品成功"}');
		}else if($type==3){
			$id = addslashes($post['id']);
			$bagData = $DB->query("SELECT * FROM `bindsbag` WHERE `id`='$id' and `bindsid` = '".$bindData['id']."' ")->fetch();
			if(!$bagData)exit('{"code":0,"msg":"无此背包物品信息"}');
			if($bagData['status'] != 0)exit('{"code":0,"msg":"此物品已领取"}');
			$statussql = "UPDATE `bindsbag` SET `status` = '1' WHERE `id` = '".$id."' ";
			$statussql = $DB->exec($statussql);
			if(!$statussql)exit('{"code":0,"msg":"修改领取状态失败"}');
			$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $_SESSION['username'] . "','领取网页背包物品：".$bagData['name']."', NOW(), '".$ip."', '".$city."')");
			$item = explode(';',$bagData['value']);
			$cmd = $flag2 . 'java -jar ../static/api/jmxc.jar "" "" "127.0.0.1" "' . $serverData['port'] . '" "gm" "userId=4096" "roleId=' . $bindData['roleid'] . '" "additem ' . $item[0] . ' ' . $item[1] . '" ';
			exec($cmd, $out);
				usleep(5000);
			if(!success_cmd($out)){
				$statussqls = "UPDATE `bindsbag` SET `status` = '0' WHERE `id` = '".$id."' ";
				$statussqls = $DB->exec($statussqls);
				$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $_SESSION['username'] . "','领取失败，返还网页背包物品：".$bagData['name']."', NOW(), '".$ip."', '".$city."')");
				exit('{"code":0,"msg":"领取失败，物品已返还！"}');
			}
            exit('{"code":1,"msg":"领取背包物品【'.$bagData['name'].'】成功"}');
		}
         exit('{"code":0,"msg":"非法操作"}');
    break;
    case 'addup':
		$type = addslashes($get['type']);
		$username = $_SESSION['username'];
        if ($username=='') {
            exit('{"code":0,"msg":"非法操作"}');
        }
		$userData = $Admin->getUser($username);
        if(empty($userData))exit('{"code":0,"msg":"此账户不存在"}');
		$bindData = $Admin->getBind($userData['id'],$userData['bindid']);
        if(empty($bindData))exit('{"code":0,"msg":"此绑定信息不存在"}');
		$serverData = $Admin->getServer($bindData['serverid']);
        if(empty($serverData))exit('{"code":0,"msg":"此区服信息不存在"}');
		if($type==1){
			$id = addslashes($post['id']);
			$check = $DB->query("SELECT * FROM `addup` WHERE `id`='$id' and `type`='1'")->fetch();
			if(!$check)exit('{"code":0,"msg":"此奖励信息不存在"}');
			if(strpos($bindData['chargelq'],'['.$id.']') !== false)exit('{"code":0,"msg":"您已领取此奖励"}');
			//检查累计是否满足要求
			$checks = $DB->query("SELECT * FROM `adduptype` WHERE `id` = '".$check['lv']."' ")->fetch();
			if($bindData['charge'] < $checks['value'])exit('{"code":0,"msg":"当前角色尚未满足领取要求"}');
			//修改领取状态
			$chargeupsql = "UPDATE `binds` SET `chargelq` = '".$bindData['chargelq'].'-['.$id."]' WHERE `id` = '".$bindData['id']."' ";
			$chargeupsql = $DB->exec($chargeupsql);
			if(!$chargeupsql)exit('{"code":0,"msg":"修改领取状态失败"}');
			//新增网页背包物品
			$DB->query("insert into `bindsbag` (`bindsid`,`name`,`image`,`value`,`status`,`data`,`info`) values ('".$userData['bindid']."','".$check['name']."','".$check['image']."','".$check['itemid'].';'.$check['num']."', '0', NOW(), '角色累计奖励' )");
			$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $_SESSION['username'] . "','领取角色累计：".$checks['value']."奖励物品，奖品名称：".$check['name']."', NOW(), '".$ip."', '".$city."')");
			//发送跑马灯
			setlocale(LC_ALL, $locale);
			putenv('LC_ALL=' . $locale);
			$notice = '玩家【'.$bindData['name'].'】领取角色累计奖励物品，物品名称【'.$check['name'].'】';
			$cmd = $flag2 . "java -classpath ." . $flag . "../static/api/gsxdb.jar Clients " . $serverData['port'] . " " . $bindData['roleid'] . " post#". $notice;
			exec($cmd, $out);
			if(success_cmd($out)){
				exit('{"code":1,"msg":"领取成功，请到网页背包查看领取"}');
			}else{
				exit('{"code":0,"msg":"领取成功，公告发送失败，请到网页背包查看领取"}');
			}
		}else if($type==2){
			$id = addslashes($post['id']);
			$check = $DB->query("SELECT * FROM `addup` WHERE `id`='$id' and `type`='2'")->fetch();
			if(!$check)exit('{"code":0,"msg":"此奖励信息不存在"}');
			if($bindData['lastday'] !== $date)exit('{"code":0,"msg":"今日尚未充值"}');
			if(strpos($bindData['daylq'],'['.$id.']') !== false)exit('{"code":0,"msg":"您已领取此奖励"}');
			//检查累计是否满足要求
			$checks = $DB->query("SELECT * FROM `adduptype` WHERE `id` = '".$check['lv']."' ")->fetch();
			if($bindData['daycharge'] < $checks['value'])exit('{"code":0,"msg":"当前角色尚未满足领取要求"}');
			//修改领取状态
			$chargeupsql = "UPDATE `binds` SET `daylq` = '".$bindData['daylq'].'-['.$id."]' WHERE `id` = '".$bindData['id']."' ";
			$chargeupsql = $DB->exec($chargeupsql);
			if(!$chargeupsql)exit('{"code":0,"msg":"修改领取状态失败"}');
			//新增网页背包物品
			$DB->query("insert into `bindsbag` (`bindsid`,`name`,`image`,`value`,`status`,`data`,`info`) values ('".$userData['bindid']."','".$check['name']."','".$check['image']."','".$check['itemid'].';'.$check['num']."', '0', NOW(), '今日累计奖励' )");
			$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $_SESSION['username'] . "','领取今日累计：".$checks['value']."奖励物品，奖品名称：".$check['name']."', NOW(), '".$ip."', '".$city."')");
			//发送跑马灯
			setlocale(LC_ALL, $locale);
			putenv('LC_ALL=' . $locale);
			$notice = '玩家【'.$bindData['name'].'】领取今日累计奖励物品，物品名称【'.$check['name'].'】';
			$cmd = $flag2 . "java -classpath ." . $flag . "../static/api/gsxdb.jar Clients " . $serverData['port'] . " " . $bindData['roleid'] . " post#". $notice;
			exec($cmd, $out);
			if(success_cmd($out)){
				exit('{"code":1,"msg":"领取成功，请到网页背包查看领取"}');
			}else{
				exit('{"code":0,"msg":"领取成功，公告发送失败，请到网页背包查看领取"}');
			}
		}
         exit('{"code":0,"msg":"非法操作"}');
    break;
    case 'draw':
		$id = addslashes($post['id']);
		$username = $_SESSION['username'];
        if ($username=='') {
            exit('{"code":0,"msg":"非法操作"}');
        }
		$userData = $Admin->getUser($username);
        if(empty($userData))exit('{"code":0,"msg":"此账户不存在"}');
		$bindData = $Admin->getBind($userData['id'],$userData['bindid']);
        if(empty($bindData))exit('{"code":0,"msg":"此绑定信息不存在"}');
		$serverData = $Admin->getServer($bindData['serverid']);
        if(empty($serverData))exit('{"code":0,"msg":"此区服信息不存在"}');
		//检查抽奖规则
		$drawscheck = $DB->query("SELECT * FROM `drawrule` WHERE `id` = '$id' ")->fetch();
		$moneys = $bindData['money'] - $drawscheck['value'];
		if($moneys < 0)exit('{"code":0,"msg":"平台币不足"}');
		//扣除平台币
		$moneysqls = "UPDATE `binds` SET `money` = `money`-'".$drawscheck['value']."' WHERE `id` = '".$userData['bindid']."' ";
		$moneysql = $DB->exec($moneysqls);
		if(!$moneysql)exit('{"code":0,"msg":"平台币扣除失败"}');
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
		$DB->query("insert into `user_log` (`username`,`info`,`data`,`ip`,`city`) values ('" . $_SESSION['username'] . "','操作抽奖，消耗平台币：".$drawscheck['value']."，抽中奖品：".$names."', NOW(), '".$ip."', '".$city."')");
         exit('{"code":1,"msg":"抽中奖品：'.$names.'"}');
    break;
    default:
        exit('{"code":-4,"msg":"No Act"}');
    break;
}
?>