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
	<h3 style="color:blue">
	注意：此功能将会为当前参展宠物增加所选技能！
	</h3>
	<br>
	<h3>
	注意：定制技能前，请确认需要定制技能的宠物处于参战状态以及角色是否在线，否则定制失败，概不负责！
	</h3>
  </div>
</div>
<div class="kbox"></div><div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
<form class="form-inline pull-right" method="post" onsubmit="return petskilldingzhi(this)">
  <br>
  <div class="con">
			<div style="text-align:center;">
				<label><b>选择宠物技能：</b></label>&nbsp;&nbsp;
				<select name="skillid" style="width:360px;height:46px;border-radius:10px">
				<?php
				$rs=$DB->query("SELECT * FROM `petskilldz` order by id");
				while($res = $rs->fetch())
				{
				echo '<option value="'.$res['id'].'">&nbsp;&nbsp;&nbsp;&nbsp;'.$res['name'].'，价格'.$res['price'].'元(平台币)</option>';
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
function petskilldingzhi(obj){  
	  var ii = layer.load(2, {shade:[0.1,'#fff']});
	  $.ajax({
	    type : 'POST',
	    url : './ajax.php?act=petskilldingzhi',
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

