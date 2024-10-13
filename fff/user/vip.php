<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
include 'header.php';
if(isset($get['type'])){
	$type = addslashes($get['type']);
}
//月卡
$yueka=$DB->getRow("select * from `config` where `keys`='yueka' limit 1");
//周卡
$zhouka=$DB->getRow("select * from `config` where `keys`='zhouka' limit 1");

$zhoukatime = $bindData['zk'];
$yuekatime = $bindData['yk'];
if($zhoukatime == 0){ 
$zhoukatime = '尚未开通过';
}else{
$zhoukatime = date('Y-m-d h:m:s',$zhoukatime);
}
if($yuekatime == 0){ 
$yuekatime = '尚未开通过';
}else{
$yuekatime = date('Y-m-d h:m:s',$yuekatime);
}



?>
<div class="kbox"></div><div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
  <div class="con">
	<h3>
	周卡到期时间：<b style="color:blue"><?php echo $zhoukatime; ?></b>
	<br>
	周卡待发放奖励：<b style="color:red">第<?php echo $bindData['zkday']; ?>天</b>
	<br>
	月卡到期时间：<b style="color:blue"><?php echo $yuekatime; ?></b>
	<br>
	月卡待发放奖励：<b style="color:red">第<?php echo $bindData['ykday']; ?>天</b>
	</h3>
	<br>
	<b style="color:black">注意：</b><b style="color:green">月卡或周卡，开通当天3分钟内发放至网页背包，后续为当日0点系统统一自动发放</b>
	<br>
	<br>
	<h3>
	<b style="color:red">周卡奖励按照开通后第几天，自动发放，请留意网页背包和平台币余额</b>
	<br>
	<b style="color:blue">月卡奖励按照开通后第几天，自动发放，请留意网页背包和平台币余额</b>
	</h3>
  </div>
</div>
<div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
<div class="myddstatu">
  <ul>
    <li>
      <a href="./vip.php?type=yueka">月卡</a>
    </li>
    <li>
      <a href="./vip.php?type=zhouka">周卡</a>
    </li>
    <li>
      <a href="./vip.php?type=award">奖励预览</a>
    </li>
  </ul>
</div>
</div>

	<?php 
	if($type=='yueka'){
	if($alipay['values']==1){
		$alipays='<div class="dpbtn2">
				<a href="../pay/api.php?type=alipay&types=3&id=1">支付宝</a>
			</div>';
	}else{
		$alipays='';
	}
	if($wxpay['values']==1){
		$wxpays='<div class="dpbtn4">
				<a href="../pay/api.php?type=wxpay&types=3&id=1">微&nbsp;&nbsp;信</a>
			</div>';
	}else{
		$wxpays='';
	}
	$info=$alipays.$wxpays;
		echo '<div class="kbox"></div>
<div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
<div class="con">
		<div class="message_1">
			'.$info.'
			<div class="dpbtn3">
				<a>开通/续费：'.$yueka['values'].'元</a>
			</div>
			<div class="meR">
			<div class="meR_1">
				<p><b>月卡</b></p>
			</div>
			</div>
		</div>
</div>
</div>
	  ';
}else if($type=='zhouka'){
	if($alipay['values']==1){
		$alipays='<div class="dpbtn2">
				<a href="../pay/api.php?type=alipay&types=3&id=2">支付宝</a>
			</div>';
	}else{
		$alipays='';
	}
	if($wxpay['values']==1){
		$wxpays='<div class="dpbtn4">
				<a href="../pay/api.php?type=wxpay&types=3&id=2">微&nbsp;&nbsp;信</a>
			</div>';
	}else{
		$wxpays='';
	}
	$info=$alipays.$wxpays;
	?>
  
<div class="kbox"></div>
<div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
<div class="con">
	<?php 
		echo '
		<div class="message_1">
			'.$info.'
			<div class="dpbtn3">
				<a>开通/续费：'.$zhouka['values'].'元</a>
			</div>
			<div class="meR">
			<div class="meR_1">
				<p><b>周卡</b></p>
			</div>
			</div>
		</div>
	  
</div>
</div>';
	
}else if($type=='award'){
	?>
  
<div class="kbox"></div>
<div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
<div class="con">
<h2>周卡奖励预览</h2>
	<?php 
	$rs=$DB->query("SELECT * FROM `vipitems` WHERE `types`='2' order by days");
	while($res = $rs->fetch())
	{
		if($res['days'] < 8){
			$daylqs = $res['days'];
		}else{
			$daylqs = '领取日期错误';
		}
		echo '
		<div class="message_1">
			<div class="meL">
			<img src="'.$res['image'].'" />
			</div>
			<div class="dpbtn3">
				<a>奖励时间：第'.$daylqs.'天</a>
			</div>
			<div class="meR">
			<div class="meR_1">
				<p><b>'.$res['name'].'</b></p>
			</div>
			<div class="meR_2">数量：'.$res['num'].'</div>
			</div>
		</div>
	  ';
	}
	
	
echo '
</div>
</div>
<div class="kbox"></div>
<div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
<div class="con">
<h2>月卡奖励预览</h2>';
	$rs=$DB->query("SELECT * FROM `vipitems` WHERE `types`='1' order by days");
	while($res = $rs->fetch())
	{
		if($res['days'] < 31){
			$daylqs = $res['days'];
		}else{
			$daylqs = '领取日期错误';
		}
		echo '
		<div class="message_1">
			<div class="meL">
			<img src="'.$res['image'].'" />
			</div>
			<div class="dpbtn3">
				<a>奖励时间：第'.$daylqs.'天</a>
			</div>
			<div class="meR">
			<div class="meR_1">
				<p><b>'.$res['name'].'</b></p>
			</div>
			<div class="meR_2">数量：'.$res['num'].'</div>
			</div>
		</div>
	  ';
	}
}
	?>
  
</div>
</div>
<script>
function buyshop(id){
	
	  var ii = layer.load(2, {shade:[0.1,'#fff']});
	  $.ajax({
	    type : 'POST',
	    url : 'ajax.php?act=buy',
	    data : {id:id},
	    dataType : 'json',
	    success : function(data) {
	      layer.close(ii);
	      if(data.code == 1){
			  swal('操作成功', data.msg,"success");setTimeout("self.location.reload();",1500);
	        //layer.alert(data.msg, {icon: 1,closeBtn: false});
	      }else{
			swal('操作失败', data.msg,"error");setTimeout("self.location.reload();",1500);
	      }
	    },
	    error:function(data){
		  swal('服务器错误', data.msg,"error");setTimeout("self.location.reload();",1500);
	      return false;
	    }
	  });
	  return false;
}
</script>
<?php
include 'footer.php';
?>

