<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
include 'header.php';
?>
<div class="kbox"></div><div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
  <div class="con">
	<h3 style="color:blue">📢📢：本页面最多显示最新500条信息。</h3>
  </div>
</div>
<div class="kbox"></div>
<div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
<div class="con">
    <h3>充值订单</h3><br>
	<?php 
	$rs=$DB->query("SELECT * FROM `pay_order` WHERE `user`='".$_SESSION['username']."' and `status`='1' order by id desc");
	while($res = $rs->fetch())
	{
		if($res['ordertype']==1){
			$leixing = '平台币订单';
		}
		echo '
		<div class="message_1">
			<div class="meR">
			<b>订单类型：'.$leixing.'&nbsp;&nbsp;&nbsp;&nbsp;成功支付：'.$res['money'].'元</b>
			<br><br>
			'.$res['date'].'&nbsp;'.$res['time'].'
			</div>
		</div>
	  ';
	}
	?>
  
</div>
</div>
<?php
include 'footer.php';
?>

