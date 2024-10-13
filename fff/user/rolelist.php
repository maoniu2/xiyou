<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
include 'header.php';
?>
<div class="kbox"></div>
<div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
<div class="con">
<h2>当前使用角色</h2>
	<?php 
		echo '
		<div class="message_1">
			<div class="meL">
			<img src="/static/user/img/footer1.png" />
			</div>
			<div class="dpbtn2"><a style="color: #00FFFF">正在使用</a></div>
			<div class="meR">
			<div class="meR_1">
				<p>所属大区：<b>'.$serverData['name'].'</b></p>
			</div>
			<div class="meR_2">角色名称：<b>'.$bindData['name'].'</b>&nbsp;&nbsp;&nbsp;&nbsp;角色ID：<b>'.$bindData['roleid'].'</b></div>
			</div>
		</div>
	   ';
	?>
  
</div>
</div>
<div class="kbox"></div>
<div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
<div class="con">
<h2>其他角色信息</h2>
	<?php 
	$rs=$DB->query("SELECT * FROM `binds` WHERE `userid`='".$userData['id']."' order by id");
	while($res = $rs->fetch())
	{
		if($res['id'] != $bindData['id']){
		$servercheck = $DB->query("SELECT * FROM `servers` WHERE `id`='".$res['serverid']."' ")->fetch();
		echo '
		<div class="message_1">
			<div class="meL">
			<img src="/static/user/img/footer1.png" />
			</div>
			<div class="dpbtn2"><a href="javascript:setbind('.$res['id'].')"><b>切换此角色</b></a></div>
			<div class="meR">
			<div class="meR_1">
				<p>所属大区：<b>'.$servercheck['name'].'</b></p>
			</div>
			<div class="meR_2">角色名称：<b>'.$res['name'].'</b>&nbsp;&nbsp;&nbsp;&nbsp;角色ID：<b>'.$res['roleid'].'</b></div>
			</div>
		</div>
	   ';
	    }
	}
	?>
  
</div>
</div>
<script>

function setbind(id){
	  var ii = layer.load(2, {shade:[0.1,'#fff']});
	  $.ajax({
	    type : 'POST',
	    url : 'ajax.php?act=setbind',
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

