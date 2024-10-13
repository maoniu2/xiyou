<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
include 'header.php';
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
	</h3><br>
	<h3>
	注意：定制装备前请确保人物处于在线状态，否则定制失败，概不负责
	</h3>
	</h3>
	
  </div>
</div>
<div class="kbox"></div><div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
<form class="form-inline pull-right" method="post" onsubmit="return zbdz(this)">
  <div class="con">
			<div style="text-align:center;">
				<label><b>选择装备：</b></label>&nbsp;&nbsp;
				<select name="zhuangbeiid" style="width:360px;height:46px;border-radius:10px">
				<?php
				$rs=$DB->query("SELECT * FROM `zbdz` where `type`='1' order by id");
				while($res = $rs->fetch())
				{
				echo '<option value="'.$res['id'].'">&nbsp;&nbsp;'.$res['name'].'，价格'.$res['price'].'元(平台币)</option>';
				}
				?> 
				</select>
			</div>
  </div>
  <br>
  <div class="con">
			<div style="text-align:center;">
				<label><b>选择特技：</b></label>&nbsp;&nbsp;
				<select name="tejiid" style="width:360px;height:46px;border-radius:10px">
				<?php
				$rs=$DB->query("SELECT * FROM `zbdz` where `type`='2' order by id");
				while($res = $rs->fetch())
				{
				echo '<option value="'.$res['id'].'">&nbsp;&nbsp;'.$res['name'].'，价格'.$res['price'].'元(平台币)</option>';
				}
				?> 
				</select>
			</div>
  </div>
  <br>
  <div class="con">
			<div style="text-align:center;">
				<label><b>选择特效：</b></label>&nbsp;&nbsp;
				<select name="texiaoid" style="width:360px;height:46px;border-radius:10px">
				<?php
				$rs=$DB->query("SELECT * FROM `zbdz` where `type`='3' order by id");
				while($res = $rs->fetch())
				{
				echo '<option value="'.$res['id'].'">&nbsp;&nbsp;'.$res['name'].'，价格'.$res['price'].'元(平台币)</option>';
				}
				?> 
				</select>
			</div>
  </div>
					<div class="tr_paybox" style="text-align:center;vertical-align:middle;">
						<input type="submit" value="确认定制" class="tr_pay" />
					</div>
  </form>
</div>
<script>
function zbdz(obj){  
	  var ii = layer.load(2, {shade:[0.1,'#fff']});
	  $.ajax({
	    type : 'POST',
	    url : './ajax.php?act=zbdz',
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

