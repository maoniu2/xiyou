<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
include 'header.php';
//资质查询
$petvalue1=$DB->getRow("select * from `petzizhi` where `id`='1' limit 1");
$petvalue2=$DB->getRow("select * from `petzizhi` where `id`='2' limit 1");
$petvalue3=$DB->getRow("select * from `petzizhi` where `id`='3' limit 1");
$petvalue4=$DB->getRow("select * from `petzizhi` where `id`='4' limit 1");
$petvalue5=$DB->getRow("select * from `petzizhi` where `id`='5' limit 1");
$petvalue6=$DB->getRow("select * from `petzizhi` where `id`='6' limit 1");
$petvalue7=$DB->getRow("select * from `petzizhi` where `id`='7' limit 1");
$petvalue8=$DB->getRow("select * from `petzizhi` where `id`='8' limit 1");
$petvalue9=$DB->getRow("select * from `petzizhi` where `id`='9' limit 1");
$petvalue10=$DB->getRow("select * from `petzizhi` where `id`='10' limit 1");
$petvalue11=$DB->getRow("select * from `petzizhi` where `id`='11' limit 1");
$petvalue12=$DB->getRow("select * from `petzizhi` where `id`='12' limit 1");
?>
<link rel="stylesheet" type="text/css" href="/static/pay/css/main.css" />
<div class="kbox"></div><div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
  <div class="con">
	<h2>定制角色信息：</h2>
	<h3>
	<br>角色ID：<?php echo $bindData['roleid']; ?>
	<br>角色名称：<?php echo $bindData['name']; ?>
	<br>所属大区：<?php echo $serverData['name']; ?>
	</h3>
	<br>
	<h3>
	注意：定制资质前，请确认需要定制资质的宠物处于参战状态以及角色是否在线，否则定制失败，概不负责！
	</h3>
  </div>
</div>
<div class="kbox"></div><div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
<form class="form-inline pull-right" method="post" onsubmit="return petzzdingzhi(this)">
  <br>
  <div class="con">
			<div style="text-align:center;">
				<label><b>选择资质：</b></label>&nbsp;&nbsp;
				<select name="zizhitype" style="width:360px;height:46px;border-radius:10px">
				<option value="1">成长资质，价格：每点/<?php echo $petvalue2['value']; ?>元(平台币)，最大值：<?php echo $petvalue1['value']; ?>点</option>
				<option value="2">攻击资质，价格：每点/<?php echo $petvalue4['value']; ?>元(平台币)，最大值：<?php echo $petvalue3['value']; ?>点</option>
				<option value="3">防御资质，价格：每点/<?php echo $petvalue6['value']; ?>元(平台币)，最大值：<?php echo $petvalue5['value']; ?>点</option>
				<option value="4">法术资质，价格：每点/<?php echo $petvalue8['value']; ?>元(平台币)，最大值：<?php echo $petvalue7['value']; ?>点</option>
				<option value="5">体质资质，价格：每点/<?php echo $petvalue10['value']; ?>元(平台币)，最大值：<?php echo $petvalue9['value']; ?>点</option>
				<option value="6">速度资质，价格：每点/<?php echo $petvalue12['value']; ?>元(平台币)，最大值：<?php echo $petvalue11['value']; ?>点</option>
				</select>
			</div>
</div>  <br>
  <div class="con">
            <div style="text-align:center;">
              <label><b>定制数值：</b></label>&nbsp;&nbsp;
              <input type="text" class="form-control"  name="number" value="" style="width:360px;height:46px;border-radius:10px" placeholder="　请输入需要定制的数值" />
            </div>
  </div>
					<div class="tr_paybox" style="text-align:center;vertical-align:middle;">
						<input type="submit" value="确认定制" class="tr_pay" />
					</div>
  </form>
</div>
<script>
function petzzdingzhi(obj){  
	  var ii = layer.load(2, {shade:[0.1,'#fff']});
	  $.ajax({
	    type : 'POST',
	    url : './ajax.php?act=petzzdingzhi',
	    data : $(obj).serialize(),
	    dataType : 'json',
	    success : function(data) {
	      layer.close(ii);
	      if(data.code == 1){
	        swal('操作成功', data.msg,"success");
	      }else{
	        swal('操作失败', data.msg,"error");
	      }
	    },
	    error:function(data){
	      swal('服务器错误', data.msg,"error");
	      return false;
	    }
	  });
	  return false;
}
</script>
<?php
include 'footer.php';
?>

