<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
include './common/main.php';
//网站信息
$title=$DB->getRow("select * from `config` where `keys`='title' limit 1");
$filename = $get['file'];


?>
<html lang="en">
<head>
	<title>玩家中心 - <?php echo $title['values'];?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/static/login/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/static/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/static/login/vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="/static/login/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/static/login/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/static/login/css/util.css">
	<link rel="stylesheet" type="text/css" href="/static/login/css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div align="center">
				<a href="./gonglue.php"><button class="login100-form-btn" style="width:248;height:58;display:block;margin:0 auto">返回菜单</button></a>
						<br>
						<br>
						<br>
				</div>		
				<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
	$fileurl = 'http://'.$_SERVER['HTTP_HOST'].'/word/'.$filename.'/index.htm';
	echo '<iframe src="'.$fileurl.'" width="1120" height="720" frameborder="1" name="'.$fileurl.'" scrolling="auto">';
?>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="/static/login/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="/static/login/vendor/bootstrap/js/popper.js"></script>
	<script src="/static/login/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="/static/login/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="/static/login/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="/static/login/js/main.js"></script>
  
<script src="/static/admin/js/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="/static/admin/js/bootstrap-datepicker/locales/bootstrap-datepicker.zh-CN.min.js"></script>


<script type="text/javascript" src="/static/admin/js/jquery.min.js"></script>
<script src="/static/admin/layer/layer.js"></script>
<script type="text/javascript" src="/static/admin/js/bootstrap.min.js"></script>
<!--标签插件-->
<script src="/static/admin/js/jquery-tags-input/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="/static/admin/js/main.min.js"></script>
<link rel="stylesheet" type="text/css" href="/static/user/alert/sweetalert.css">
<script type="text/javascript" src="/static/user/alert/sweetalert-dev.js"></script>
</body>
</html>
