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
	$sql=" `status`='1' and `itemtype`='$type'";
}else{
	$sql=" `status`='1'";
}

//图标
$fotter22=$DB->getRow("select * from `tubiao` where `id`='22' limit 1");
?>
<div class="kbox"></div>
<div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
<div class="con">
    <ul>
      <li>
        <a href="./shop.php">
          <div class="ddimg">
			<img src="<?php echo $fotter22['value']; ?>" />
          </div>
          <p>全部商品</p>
        </a>
      </li>
	<?php 
	$rs=$DB->query("SELECT * FROM `types` order by id");
	while($res = $rs->fetch())
	{
			$allljslnum=$DB->getColumn("SELECT count(*) from `shops` WHERE `itemtype` = '".$res['id']."' and `status`='1'");
			if($allljslnum > 0){
			echo '
			<li>
				<a href="./shop.php?type='.$res['id'].'">
				<div class="ddimg">
					<img src="'.$res['image'].'" />
				</div>
				<p>'.$res['name'].'</p>
				</a>
			</li>
			';
		}
	}
	?>
    </ul>
</div>
</div>
<div class="kbox"></div>
<div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
<div class="con">
	<?php 
	$rs=$DB->query("SELECT * FROM `shops` WHERE{$sql} order by id");
	while($res = $rs->fetch())
	{
		echo '
		<div class="message_1">
			<div class="meL">
			<img src="'.$res['image'].'" />
			</div>
			<div class="dpbtn2">
				<a href="javascript:buyshop('.$res['id'].')">购&nbsp;&nbsp;买</a>
			</div>
			<div class="dpbtn3">
				<a>'.$res['price'].'币</a>
			</div>
			<div class="meR">
			<div class="meR_1">
				<p><b>'.$res['name'].'<br><font style="color:red">数量：</font>'.$res['num'].'</b></p>
			</div>
			<br>
			<div class="meR_2"><b style="color:blue">介绍：</b>'.$res['info'].'</div>
			</div>
		</div>
	  ';
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

