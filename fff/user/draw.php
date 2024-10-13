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
	<h2>
	抽奖注意事项：</h2><h4><br>📢📢：抽中的所有物品会储存网页背包内<br>📢📢：点击多次抽奖按钮，请耐心等待系统提示，次数越多，系统运行时间越长<br>📢📢：否则造成奖品丢失概不负责！！！
	</h4>
  </div>
</div>
<div class="kbox"></div>
<div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
<div class="con">
<h2>抽奖方式</h2><br>
	<?php 
	$rs=$DB->query("SELECT * FROM `drawrule` order by id");
	while($res = $rs->fetch())
	{
		if($alipay['values']==1){
			$alipays='<div class="dpbtn2">
					<a href="../pay/api.php?type=alipay&types=4&id='.$res['id'].'">支付宝</a>
				</div>';
		}else{
			$alipays='';
		}
		if($wxpay['values']==1){
			$wxpays='<div class="dpbtn4">
					<a href="../pay/api.php?type=wxpay&types=4&id='.$res['id'].'">微&nbsp;&nbsp;信</a>
				</div>';
		}else{
			$wxpays='';
		}
		if($res['ptbopen']==1){
			$ptb='<div class="dpbtn3">
			<a href="javascript:draw('.$res['id'].')"><b>平台币</b></a>
			</div>';
			$ptbinfo='平台币：<b>'.$res['value'].'</b>币&nbsp;&nbsp;&nbsp;&nbsp';
		}else{
			$ptb='';
			$ptbinfo='';
		}
		$info=$alipays.$wxpays.$ptb;
		if($wxpay['values']!=1&&$alipay['values']!=1){
			$rmbinfo='';
		}else{
			$rmbinfo='现金：<b>'.$res['money'].'</b>元';
		}
		echo '
		<div class="message_1">
			'.$info.'
			<div class="meR">
			<div class="meR_1">
				<p>抽奖：<b>'.$res['times'].'次</b></p>
			</div>
			<div class="meR_2">'.$ptbinfo.$rmbinfo.'</div>
			</div>
		</div>
	   ';
	}
	?>
</div>
</div>
<div class="kbox"></div>
<div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
<div class="con">
<h2>奖池物品列表</h2><br>
	<?php 
	$rs=$DB->query("SELECT * FROM `draws` order by id");
	while($res = $rs->fetch())
	{
		echo '
		<div class="message_1">
			<div class="meR">
			<div class="meR_1">
				<p>概率抽中：<b>'.$res['name'].'*'.$res['num'].'</b></p>
			</div>
			</div>
		</div>
	   ';
	}
	?>
</div>
</div>
<script>

function draw(id){
	  var ii = layer.load(2, {shade:[0.1,'#fff']});
	  $.ajax({
	    type : 'POST',
	    url : 'ajax.php?act=draw',
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

