<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
include './auth.php';

//网站信息
$title=$DB->getRow("select * from `config` where `keys`='title' limit 1");
$keywords=$DB->getRow("select * from `config` where `keys`='keywords' limit 1");
$description=$DB->getRow("select * from `config` where `keys`='description' limit 1");
//滚动公告
$gundongnotice=$DB->getRow("select * from `config` where `keys`='gundongnotice' limit 1");



//图标
$fotter5=$DB->getRow("select * from `tubiao` where `id`='5' limit 1");
$fotter6=$DB->getRow("select * from `tubiao` where `id`='6' limit 1");
$fotter7=$DB->getRow("select * from `tubiao` where `id`='7' limit 1");
$fotter8=$DB->getRow("select * from `tubiao` where `id`='8' limit 1");
$fotter9=$DB->getRow("select * from `tubiao` where `id`='9' limit 1");
//网站信息
$wanjiaanwz=$DB->getRow("select * from `config` where `keys`='wanjiaanwz' limit 1");
//网站信息
$wanjiaanlj=$DB->getRow("select * from `config` where `keys`='wanjiaanlj' limit 1");

//支付开关
$alipay=$DB->getRow("select * from `config` where `keys`='alipay' limit 1");
$wxpay=$DB->getRow("select * from `config` where `keys`='wxpay' limit 1");
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0">
<meta name="renderer" content="webkit"/>
<meta name="force-rendering" content="webkit"/>
<title><?php echo $title['values'];?></title>
<link href="/favicon.ico" rel="icon" type="image/x-ico">
<link type="text/css" rel="stylesheet" href="/static/user/css/style.css" />
<link rel="stylesheet" type="text/css" href="/static/user/alert/sweetalert.css">
<script type="text/javascript" src="/static/user/alert/sweetalert-dev.js"></script>
<script type="text/javascript" src="/static/admin/js/bootstrap.min.js"></script>
<script src="/static/admin/js/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="/static/admin/js/bootstrap-datepicker/locales/bootstrap-datepicker.zh-CN.min.js"></script>
<script type="text/javascript" src="/static/admin/js/main.min.js"></script>
<script type="text/javascript" src="/static/admin/js/jquery.min.js"></script>
<script src="/static/admin/layer/layer.js"></script>
</head>

<body>
<div class="m0myheader">
  <div class="conbox">
    <div class="conboxL">
	  <img src="/static/user/img/txtb.png"  class="tt"/>
      <div class="btR">
        <p class="p1"><?php echo $userData['username']; ?></p>
        <div class="v1">
          <p>【<?php echo $serverData['name']; ?>】<?php echo $bindData['name']; ?></p>
        </div>
      </div>
    </div>
	<div class="conboxR">
          <b><a class="p1" style="text-align:center;font-size:1.0rem;color=:white;background-color:#e5595c;border-radius:10px" href="password.php">修改密码</a></b>
    </div>
    <div class="clear"></div>
  </div>
  <div class="conbox2">
    <ul>
      <li>
        <a href="javascript:void()">
          <p class="p1"><?php echo $bindData['money']; ?>
          <p class="p2">平台币</p>
        </a>
      </li>
      <li>
        <a href="javascript:void()">
          <p class="p1"><?php 
		  if($bindData['lastday'] == $date){
		  echo $bindData['daycharge']; 
		  }else{
		  echo '0.00'; 
		  }?></p>
          <p class="p2">今日累计</p>
        </a>
      </li>
      <li>
        <a href="javascript:void()">
          <p class="p1"><?php echo $bindData['charge']; ?></p>
          <p class="p2">角色累计</p>
        </a>
      </li>
    </ul>
  </div>
</div>
<div class="clear"></div>
<div class="mypart1">
  <ul>
	<?php
	if($opening[0]=='on'){ 
	?>	
    <li>
      <a href="adduptoday.php">
		<img src="<?php echo $fotter5['value']; ?>" />
      <p class="p2">今日累计</p>
    </li>
	<?php
	}
	if($opening[1]=='on'){ 
	?>	
    <li>
      <a href="addup.php">
		<img src="<?php echo $fotter6['value']; ?>" />
      <p class="p2">角色累计</p>
    </li>
	<?php
	}
	if($opening[2]=='on'){ 
	?>	
    <li>
      <a href="rolelist.php">
		<img src="<?php echo $fotter8['value']; ?>" />
      <p class="p2">切换角色</p>
      </a>
    </li>
	<?php
	}
	if($opening[3]=='on'){ 
	?>	
    <li>
      <a href="<?php echo $wanjiaanlj['values']; ?>">
		<img src="<?php echo $fotter7['value']; ?>" />
      <p class="p2"><?php echo $wanjiaanwz['values']; ?></p>
    </li>
	<?php
	}
	if($opening[4]=='on'){ 
	?>	
    <li>
      <a href="pay.php">
		<img src="<?php echo $fotter9['value']; ?>" />
      <p class="p2"><b>充值余额</b></p>
      </a>
    </li>
	<?php
	}
	?>	
  </ul>
</div>
<div class="kbox"></div><div class="kbox"></div>
<div class="clear"></div>
	<?php
	if($opening[20]=='on'){ 
	?>	
<div class="mypart2">
  <div class="con">
	<h2>
		<marquee border="0" valign="middle" align="center" scrolldelay="60">📢📢公告📢📢：<?php echo $gundongnotice['values']; ?></marquee>
	</h2>
  </div>
</div>
	<?php
	}
	?>	