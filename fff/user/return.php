<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
include 'header.php';
//计算得出通知验证结果
require_once("../pay/payconfig.php");
require_once("../pay/lib/EpayCore.class.php");
$epay = new EpayCore($epay_config);
$verify_result = $epay->verifyReturn();

if($verify_result) {//验证成功

	//商户订单号
	$out_trade_no = $get['out_trade_no'];

	//支付宝交易号
	$trade_no = $get['trade_no'];

	//交易状态
	$trade_status = $get['trade_status'];

	//支付方式
	$type = $get['type'];
	//支付方式
	$money = $get['money'];

	if($get['trade_status'] == 'TRADE_SUCCESS') {
	$statusinfo = '支付成功';
	}else{
	$statusinfo = '支付失败';
	}
}
else {
	$statusinfo = '支付失败';
}
?>
<link rel="stylesheet" type="text/css" href="/static/pay/css/main.css" />
<div class="kbox"></div><div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
  <div class="con">
	<h1><b><?php echo $statusinfo; ?></b></h1>
  </div>
</div>
<div class="kbox"></div><div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
  <div class="con">
	<h2>支付信息：</h2>
	<br>
	<h3>订单号：<?php echo $out_trade_no; ?>
	<br>支付状态：<?php echo $trade_status; ?>
	<br>支付金额：<?php echo $money; ?>
	<br>月卡、周卡、平台币直接到账，现金商城直接到网页背包！
	<br>抽奖命中物品查看操作日志即可，物品发送至网页背包内！
	</h3>
  </div>
</div>
<?php
include 'footer.php';
?>

