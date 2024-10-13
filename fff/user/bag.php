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
	$sql=" `bindsid`='".$userData['bindid']."' and `status`='$type'";
}else{
	$sql=" `bindsid`=".$userData['bindid'];
}
$allbagnum=$DB->getColumn("SELECT count(*) from `bindsbag` WHERE `bindsid`='".$userData['bindid']."' ");
$allwlqbagnum=$DB->getColumn("SELECT count(*) from `bindsbag` WHERE `bindsid`='".$userData['bindid']."' and `status`='0'");
$allylqbagnum=$DB->getColumn("SELECT count(*) from `bindsbag` WHERE `bindsid`='".$userData['bindid']."' and `status`='1'");
if($allwlqbagnum > 20){
	$allzjbagnum = 20;
}else{
	$allzjbagnum = $allwlqbagnum;
}
//图标
$fotter24=$DB->getRow("select * from `tubiao` where `id`='24' limit 1");
$fotter25=$DB->getRow("select * from `tubiao` where `id`='25' limit 1");
$fotter26=$DB->getRow("select * from `tubiao` where `id`='26' limit 1");
$fotter27=$DB->getRow("select * from `tubiao` where `id`='27' limit 1");
$fotter28=$DB->getRow("select * from `tubiao` where `id`='28' limit 1");
?>
<div class="kbox"></div><div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
  <div class="con">
	<h2>
	领取物品注意事项（游戏内）：</h2><h4><br>📢📢：确保角色处于在线状态<br>📢📢：确保角色背包空间充足<br>📢📢：否则造成物品丢失概不负责！！！<br><br></h4><h3 style="color:blue">📢📢：本页面最多显示最新300条信息，未领取优先显示，如果未领取物品超过300条，待前面领取完，即可显示之前未显示物品信息，【领取所有物品】按钮不受此限制。</h3>
	
  </div>
</div>
<div class="kbox"></div>
<div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
<div class="con">
    <ul>
      <li>
        <a href="./bag.php">
          <div class="ddimg">
			<img src="<?php echo $fotter24['value']; ?>" />
            <div class="num"><?php echo $allwlqbagnum; ?></div>
          </div>
          <p>全部物品</p>
        </a>
      </li>
      <li>
        <a href="./bag.php?type=0">
          <div class="ddimg">
			<img src="<?php echo $fotter25['value']; ?>" />
            <div class="num"><?php echo $allwlqbagnum; ?></div>
          </div>
          <p>待领取物品</p>
        </a>
      </li>
      <li>
        <a href="./bag.php?type=1">
          <div class="ddimg">
			<img src="<?php echo $fotter26['value']; ?>" />
          </div>
          <p>已领取物品</p>
        </a>
      </li>
      <li>
        <a href="javascript:lingquA(<?php echo $allzjbagnum; ?>)">
          <div class="ddimg">
			<img src="<?php echo $fotter27['value']; ?>" />
            <div class="num"><?php echo $allzjbagnum; ?></div>
          </div>
          <p><b>领取最近<?php echo $allzjbagnum; ?>件</b></p>
        </a>
      </li>
      <li>
        <a href="javascript:lingquB()">
          <div class="ddimg">
			<img src="<?php echo $fotter28['value']; ?>" />
            <div class="num"><?php echo $allwlqbagnum; ?></div>
          </div>
          <p><b>领取所有物品</b></p>
        </a>
      </li>
    </ul>
</div>
</div>
<div class="kbox"></div>
<div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
<div class="con">
	<?php 
	$rs=$DB->query("SELECT * FROM `bindsbag` WHERE{$sql} order by status , id DESC limit 0,299");
	while($res = $rs->fetch())
	{
		if($res['status']==1){
			//$lingqu = '<a style="background-color:blue" >已领</a>';
			$lingqu = '<div class="dpbtn2"><a style="color: #00FFFF">已领</a></div>';
		}else{
			$lingqu = '<div class="dpbtn2"><a href="javascript:lingquC('.$res['id'].')"><b>领取</b></a></div>';
		}
		$item = explode(';',$res['value']);
		echo '
		<div class="message_1">
			<div class="meL">
			<img src="'.$res['image'].'" />
			</div>
			'.$lingqu.'
			<div class="dpbtn3">
				<a>来源：'.$res['info'].'</a>
			</div>
			<div class="meR">
			<div class="meR_1">
				<p>'.$res['name'].'*'.$item[1].'</p>
			</div>
			<div class="meR_2">获取时间：'.$res['data'].'</div>
			</div>
		</div>
	  ';
	}
	?>
  
</div>
</div>
<script>

function lingquA(id){
  swal({
title: "确定批量领取吗？",text: "此功能会批量领取物品到背包，请检查角色是否在线，背包空间是否充足！",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "确认",cancelButtonText: "取消",closeOnConfirm: true,closeOnCancel: true}, function(){
    var ii = layer.load(2, {shade:[0.1,'#fff']});
    $.ajax({
      type : 'POST',
      url : 'ajax.php?act=bag&type=1',
      data: {num:id},
      dataType : 'json',
      success : function(data) {
        layer.close(ii);
        if(data.code == 1){
			  swal('操作成功', data.msg,"success");setTimeout("self.location.reload();",3000);
	      }else{
			swal('操作失败', data.msg,"error");setTimeout("self.location.reload();",3000);
        }
      },
      error:function(data){
		  swal('服务器错误', data.msg,"error");setTimeout("self.location.reload();",3000);
        return false;
      }
    });
  }, function() {});
  return false;
}
function lingquB(id){
  swal({
title: "确定批量领取吗？",text: "此功能会批量领取物品到背包，请检查角色是否在线，背包空间是否充足！",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "确认",cancelButtonText: "取消",closeOnConfirm: true,closeOnCancel: true}, function(){
    var ii = layer.load(2, {shade:[0.1,'#fff']});
    $.ajax({
      type : 'POST',
      url : 'ajax.php?act=bag&type=2',
      data: {num:id},
      dataType : 'json',
      success : function(data) {
        layer.close(ii);
        if(data.code == 1){
			  swal('操作成功', data.msg,"success");setTimeout("self.location.reload();",3000);
	      }else{
			swal('操作失败', data.msg,"error");setTimeout("self.location.reload();",3000);
        }
      },
      error:function(data){
		  swal('服务器错误', data.msg,"error");setTimeout("self.location.reload();",3000);
        return false;
      }
    });
  }, function() {});
  return false;
}
function lingquC(id){
  swal({
title: "确定领取吗？",text: "此功能会领取物品到背包，请检查角色是否在线，背包空间是否充足！",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "确认",cancelButtonText: "取消",closeOnConfirm: true,closeOnCancel: true}, function(){
    var ii = layer.load(2, {shade:[0.1,'#fff']});
    $.ajax({
      type : 'POST',
      url : 'ajax.php?act=bag&type=3',
      data: {id:id},
      dataType : 'json',
      success : function(data) {
        layer.close(ii);
        if(data.code == 1){
			  swal('操作成功', data.msg,"success");setTimeout("self.location.reload();",1000);
	      }else{
			swal('操作失败', data.msg,"error");setTimeout("self.location.reload();",1000);
        }
      },
      error:function(data){
		  swal('服务器错误', data.msg,"error");setTimeout("self.location.reload();",1000);
        return false;
      }
    });
  }, function() {});
  return false;
}
</script>
<?php
include 'footer.php';
?>

