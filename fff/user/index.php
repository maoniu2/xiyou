<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
include 'header.php';
//图标
$fotter10=$DB->getRow("select * from `tubiao` where `id`='10' limit 1");
$fotter11=$DB->getRow("select * from `tubiao` where `id`='11' limit 1");
$fotter12=$DB->getRow("select * from `tubiao` where `id`='12' limit 1");
$fotter13=$DB->getRow("select * from `tubiao` where `id`='13' limit 1");
$fotter14=$DB->getRow("select * from `tubiao` where `id`='14' limit 1");
$fotter15=$DB->getRow("select * from `tubiao` where `id`='15' limit 1");
$fotter16=$DB->getRow("select * from `tubiao` where `id`='16' limit 1");
$fotter17=$DB->getRow("select * from `tubiao` where `id`='17' limit 1");
$fotter18=$DB->getRow("select * from `tubiao` where `id`='18' limit 1");
$fotter19=$DB->getRow("select * from `tubiao` where `id`='19' limit 1");
$fotter20=$DB->getRow("select * from `tubiao` where `id`='20' limit 1");
$fotter21=$DB->getRow("select * from `tubiao` where `id`='21' limit 1");


$fotter31=$DB->getRow("select * from `tubiao` where `id`='31' limit 1");
$fotter32=$DB->getRow("select * from `tubiao` where `id`='32' limit 1");
$fotter33=$DB->getRow("select * from `tubiao` where `id`='33' limit 1");
$fotter34=$DB->getRow("select * from `tubiao` where `id`='34' limit 1");
$fotter35=$DB->getRow("select * from `tubiao` where `id`='35' limit 1");


$kuaijiecaidan=$DB->getRow("select * from `config` where `keys`='kuaijiecaidan' limit 1");



$kuaijimenua=$DB->getRow("select * from `config` where `keys`='kuaijimenua' limit 1");
$kuaijimenualj=$DB->getRow("select * from `config` where `keys`='kuaijimenualj' limit 1");
$kuaijimenub=$DB->getRow("select * from `config` where `keys`='kuaijimenub' limit 1");
$kuaijimenublj=$DB->getRow("select * from `config` where `keys`='kuaijimenublj' limit 1");
$kuaijimenuc=$DB->getRow("select * from `config` where `keys`='kuaijimenuc' limit 1");
$kuaijimenuclj=$DB->getRow("select * from `config` where `keys`='kuaijimenuclj' limit 1");
$kuaijimenud=$DB->getRow("select * from `config` where `keys`='kuaijimenud' limit 1");
$kuaijimenudlj=$DB->getRow("select * from `config` where `keys`='kuaijimenudlj' limit 1");
$kuaijimenue=$DB->getRow("select * from `config` where `keys`='kuaijimenue' limit 1");
$kuaijimenuelj=$DB->getRow("select * from `config` where `keys`='kuaijimenuelj' limit 1");


?>
<?php if($kuaijiecaidan['values'] == 1){ ?>
<div class="kbox"></div><div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
  <div class="con">
    <div class="pa2_tit">
      <p>快捷按钮</p>
      <!--<a href="allDd.html">查看更多订单 ></a>-->
    </div>
    <ul>
	<?php
	if($opening[5]=='on'){ 
	?>	
      <li>
        <a href="<?php echo $kuaijimenualj['values']; ?>">
          <div class="ddimg">
			<img src="<?php echo $fotter31['value']; ?>" />
          </div>
          <p><?php echo $kuaijimenua['values']; ?></p>
        </a>
      </li>
	<?php
	}
	if($opening[6]=='on'){ 
	?>	
      <li>
        <a href="<?php echo $kuaijimenublj['values']; ?>">
          <div class="ddimg">
			<img src="<?php echo $fotter32['value']; ?>" />
          </div>
          <p><?php echo $kuaijimenub['values']; ?></p>
        </a>
      </li>
	<?php
	}
	if($opening[7]=='on'){ 
	?>	
      <li>
        <a href="<?php echo $kuaijimenuclj['values']; ?>">
          <div class="ddimg">
			<img src="<?php echo $fotter33['value']; ?>" />
          </div>
          <p><?php echo $kuaijimenuc['values']; ?></p>
        </a>
      </li>
	<?php
	}
	if($opening[8]=='on'){ 
	?>	
      <li>
        <a href="<?php echo $kuaijimenudlj['values']; ?>">
          <div class="ddimg">
			<img src="<?php echo $fotter34['value']; ?>" />
          </div>
          <p><?php echo $kuaijimenud['values']; ?></p>
        </a>
      </li>
	<?php
	}
	if($opening[9]=='on'){ 
	?>	
      <li>
        <a href="<?php echo $kuaijimenuelj['values']; ?>">
          <div class="ddimg">
			<img src="<?php echo $fotter35['value']; ?>" />
          </div>
          <p><?php echo $kuaijimenue['values']; ?></p>
        </a>
      </li>
	<?php
	}
	?>	
    </ul>
  </div>
</div>
<?php } ?>
<div class="kbox"></div><div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
  <div class="con">
    <div class="pa2_tit">
      <p>菜单</p>
      <!--<a href="allDd.html">查看更多订单 ></a>-->
    </div>
    <ul>
	<?php
	if($opening[5]=='on'){ 
	?>	
	  <?php if($bindData['fuli'] != 1){?>
      <li>
        <a href="javascript:fulilingqu()">
          <div class="ddimg">
			<img src="<?php echo $fotter10['value']; ?>" />
          </div>
          <p>福利领取</p>
        </a>
      </li>
	  <?php }else{ ?>
      <li>
        <a>
          <div class="ddimg">
			<img src="<?php echo $fotter11['value']; ?>" />
          </div>
          <p>已领福利</p>
        </a>
      </li>
	  <?php }?>
	  
	<?php
	}
	if($opening[6]=='on'){ 
	?>	
      <li>
        <a href="javascript:mobile()">
          <div class="ddimg">
			<img src="<?php echo $fotter12['value']; ?>" />
          </div>
          <p>关联手机</p>
        </a>
      </li>
	<?php
	}
	if($opening[7]=='on'){ 
	?>	
      <li>
        <a href="cdks.php">
          <div class="ddimg">
			<img src="<?php echo $fotter13['value']; ?>" />
          </div>
          <p>CDK兑换</p>
        </a>
      </li>
	<?php
	}
	if($opening[8]=='on'){ 
	?>	
      <li>
        <a href="shop.php">
          <div class="ddimg">
			<img src="<?php echo $fotter14['value']; ?>" />
          </div>
          <p>余额商城</p>
        </a>
      </li>
	<?php
	}
	if($opening[9]=='on'){ 
	?>	
      <li>
        <a href="vip.php?type=yueka">
          <div class="ddimg">
			<img src="<?php echo $fotter15['value']; ?>" />
          </div>
          <p>会员中心</p>
        </a>
      </li>
	<?php
	}
	if($opening[10]=='on'){ 
	?>	
      <li>
        <a href="zbdz.php">
          <div class="ddimg">
			<img src="<?php echo $fotter16['value']; ?>" />
          </div>
          <p>装备定制</p>
        </a>
      </li>
	<?php
	}
	if($opening[11]=='on'){ 
	?>	
      <li>
        <a href="petdzzizhi.php">
          <div class="ddimg">
			<img src="<?php echo $fotter17['value']; ?>" />
          </div>
          <p>宠物资质</p>
        </a>
      </li>
	<?php
	}
	if($opening[12]=='on'){ 
	?>	
      <li>
        <a href="petskilldz.php">
          <div class="ddimg">
			<img src="<?php echo $fotter18['value']; ?>" />
          </div>
          <p>宠物技能</p>
        </a>
      </li>
	<?php
	}
	if($opening[13]=='on'){ 
	?>	
      <li>
        <a href="order.php">
          <div class="ddimg">
			<img src="<?php echo $fotter19['value']; ?>" />
          </div>
          <p>充值订单</p>
        </a>
      </li>
	<?php
	}
	if($opening[14]=='on'){ 
	?>	
      <li>
        <a href="userlog.php">
          <div class="ddimg">
			<img src="<?php echo $fotter20['value']; ?>" />
          </div>
          <p>操作日志</p>
        </a>
      </li>
	<?php
	}
	if($opening[15]=='on'){ 
	?>	
      <li>
        <a href="../ajax.php?act=logout">
          <div class="ddimg">
			<img src="<?php echo $fotter21['value']; ?>" />
          </div>
          <p>退出登陆</p>
        </a>
      </li>
	<?php
	}
	?>	
    </ul>
  </div>
</div>
<!--
<div class="clear"></div>
<div class="kbox"></div><div class="kbox"></div>
<div class="clear"></div>
<div class="mypart3">
  <ul>
    <li>
      <a href="javascript:void()">
      <img src="/static/user/img/footer1.png" />
      <p>我的活动</p>
      </a>
    </li>
    <li>
      <a href="javascript:void()">
      <img src="/static/user/img/footer1.png" />
      <p>社区</p>
      </a>
    </li>
    <li>
      <a href="javascript:void()">
      <img src="/static/user/img/footer1.png" />
      <p>客户服务</p>
      </a>
    </li>
    <li>
      <a href="javascript:void()">
      <img src="/static/user/img/footer1.png" />
      <p>京东超市</p>
      </a>
    </li>
    <li>
      <a href="quanNews1.html">
      <img src="/static/user/img/footer1.png" />
      <p>我的优惠券</p>
      </a>
    </li>
    <li>
      <a href="addressGL.html">
      <img src="/static/user/img/footer1.png" />
      <p>收获地址</p>
      </a>
    </li>
    <li>
      <a href="jifen.html">
      <img src="/static/user/img/footer1.png" />
      <p>我的积分</p>
      </a>
    </li>
    <li>
      <a href="javascript:void()">
      <img src="/static/user/img/footer1.png" />
      <p>我的客服</p>
      </a>
    </li>
  </ul>
</div>
-->
<script>
function fulilingqu(){
  swal({
title: "确定领取吗？",text: "新手福利将会直接发放至游戏邮件，请注意查收！",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "确认",cancelButtonText: "取消",closeOnConfirm: true,closeOnCancel: true}, function(){
    var ii = layer.load(2, {shade:[0.1,'#fff']});
    $.ajax({
      type : 'POST',
      url : 'ajax.php?act=fulilingqu',
      dataType : 'json',
      success : function(data) {
        layer.close(ii);
        if(data.code == 1){
			  swal('操作成功', data.msg,"success");setTimeout("self.location.reload();",1500);
	      }else{
			swal('操作失败', data.msg,"error");setTimeout("self.location.reload();",1500);
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
function mobile(){
  swal({
title: "确定关联手机吗？",text: "此操作将会对角色进行手机关联！",type: "warning",showCancelButton: true,confirmButtonColor: "#DD6B55",confirmButtonText: "确认",cancelButtonText: "取消",closeOnConfirm: true,closeOnCancel: true}, function(){
    var ii = layer.load(2, {shade:[0.1,'#fff']});
    $.ajax({
      type : 'POST',
      url : 'ajax.php?act=mobile',
      dataType : 'json',
      success : function(data) {
        layer.close(ii);
        if(data.code == 1){
			  swal('操作成功', data.msg,"success");setTimeout("self.location.reload();",1500);
	      }else{
			swal('操作失败', data.msg,"error");setTimeout("self.location.reload();",1500);
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
function logout(){
	  var ii = layer.load(2, {shade:[0.1,'#fff']});
	  $.ajax({
	    type : 'POST',
	    url : '../ajax.php?act=logout',
	    dataType : 'json',
	    success : function(data) {
	      layer.close(ii);
	      if(data.code == 1){
			  swal('注销成功', data.msg,"success");setTimeout("self.location.reload();",1500);
	        //layer.alert(data.msg, {icon: 1,closeBtn: false});
	      }else{
			swal('注销失败', data.msg,"error");setTimeout("self.location.reload();",1500);
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

