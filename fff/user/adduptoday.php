<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
include 'header.php';
if(isset($get['lv'])){
	$lv = addslashes($get['lv']);
	$sql=" `lv`='$lv' and `type`='2'";
}else{
	$sql=" `type`='2'";
}
$fotter30=$DB->getRow("select * from `tubiao` where `id`='30' limit 1");
?>
<div class="kbox"></div>
<div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
<div class="con">
    <ul>
      <li>
        <a href="./adduptoday.php">
          <div class="ddimg">
			<img src="<?php echo $fotter30['value']; ?>" />
          </div>
          <p>全部奖励</p>
        </a>
      </li>
		<?php 
		$rs=$DB->query("SELECT * FROM `adduptype` order by value");
		while($res = $rs->fetch())
		{
			$allljslnum=$DB->getColumn("SELECT count(*) from `addup` WHERE `lv` = '".$res['id']."' and `type`='2'");
			if($allljslnum > 0){
			$value = explode('.',$res['value']);
			echo '
			<li>
				<a href="./adduptoday.php?lv='.$res['id'].'">
				<div class="ddimg">
					<img src="'.$res['image'].'" />
				</div>
				<p>累计'.$value[0].'</p>
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
	$rs=$DB->query("SELECT * FROM `addup` WHERE{$sql} order by id");
	while($res = $rs->fetch())
	{
		$lvData = $DB->query("SELECT * FROM `adduptype` WHERE `id`='".$res['lv']."' ")->fetch();
		if($bindData['lastday'] == $date && $bindData['daycharge'] >= $lvData['value']){
			if(strpos($bindData['daylq'],'['.$res['id'].']') !== false){ 
				//$lingqu = '<a style="background-color:blue" >已领</a>';
				$lingqu = '<div class="dpbtn2"><a style="color: #00FFFF">已领</a></div>';
			}else{
			$lingqu = '<div class="dpbtn2"><a href="javascript:lingqu('.$res['id'].')"><b>领取</b></a></div>';
			}
		}else{
			$lingqu = '<div class="dpbtn2"><a href="javascript:lingqu('.$res['id'].')"><b>未达到要求</b></a></div>';
		}
		echo '
		<div class="message_1">
			<div class="meL">
			<img src="'.$res['image'].'" />
			</div>
			'.$lingqu.'
			<div class="meR">
			<div class="meR_1">
				<p>'.$res['name'].'*'.$res['num'].'</p>
			</div>
			<div class="meR_2">领取要求：今日累计满'.$lvData['value'].'元</div>
			</div>
		</div>
	  ';
	}
	?>
  
</div>
</div>
<script>

function lingqu(id){
	  var ii = layer.load(2, {shade:[0.1,'#fff']});
	  $.ajax({
	    type : 'POST',
	    url : 'ajax.php?act=addup&type=2',
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

