<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
//图标
$fotter1=$DB->getRow("select * from `tubiao` where `id`='1' limit 1");
$fotter2=$DB->getRow("select * from `tubiao` where `id`='2' limit 1");
$fotter3=$DB->getRow("select * from `tubiao` where `id`='3' limit 1");
$fotter4=$DB->getRow("select * from `tubiao` where `id`='4' limit 1");
?>

<div class="clear"></div>
<div class="fbox"></div>
<div class="footbox">
  <div class="footer">
    <ul>
	<?php
	if($opening[16]=='on'){ 
	?>	
      <li>
        <a href="index.php">
          <img src="<?php echo $fotter1['value']; ?>" />
          <p>首页</p>
        </a>
      </li>
	<?php
	}
	if($opening[17]=='on'){
	?>	
      <li>
        <a href="rmbshop.php">
          <img src="<?php echo $fotter2['value']; ?>" />
          <p>现金商城</p>
        </a>
      </li>
	<?php 
	}
	if($opening[18]=='on'){ 
	?>	
      <li>
        <a href="draw.php">
          <img src="<?php echo $fotter3['value']; ?>" />
          <p>抽奖</p>
        </a>
      </li>
	<?php
	}
	if($opening[19]=='on'){
	?>	
      <li>
        <a href="bag.php">
          <img src="<?php echo $fotter4['value']; ?>" />
          <p>背包</p>
        </a>
      </li>
	<?php } ?>	
    </ul>
  </div>
</div>
</body>
</html>