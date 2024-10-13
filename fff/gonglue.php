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
				<div class="login100-pic js-tilt" data-tilt>
					<img src="/static/login/images/img-01.png" alt="IMG">
				</div>
				<form class="login100-form validate-form" onsubmit="return login(this)" method="post" >
					<span class="login100-form-title">
						<?php echo $title['values'];?>
					</span>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" onclick='location.href=("index.php")'>
						返回首页
						</button>
						<br>
						<br>
						<br>
						<?php 
						
$handler = opendir('word/');
while( ($filename = readdir($handler)) !== false )
{
if($filename != '.' && $filename != '..')
{
$a= 'gonglue_tool.php?file='.$filename;
echo '<button class="login100-form-btn" onclick=\'location.href=("'.$a.'")\'>
						'.$filename.'
						</button>
						<br>
						<br>
						<br>';
}
}
closedir($handler);

						?> 
						
					</div>
				</form>
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
<script>
function login(obj){
	  var ii = layer.load(2, {shade:[0.1,'#fff']});
	  $.ajax({
	    type : 'POST',
	    url : 'ajax.php?act=login',
	    data : $(obj).serialize(),
	    dataType : 'json',
	    success : function(data) {
	      layer.close(ii);
	      if(data.code == 1){
			  swal('操作成功', data.msg,"success");
			  setTimeout(function (){
                  location.href = './ajax.php?act=logout'
              },1000);
	      }else if(data.code == 2){
			  swal('操作成功', data.msg,"success");
			  setTimeout(function (){
                  location.href = './user'
              },1000);
	      }else{
			
	      }
	    },
	    error:function(data){
		  setTimeout("self.location.reload();",1000);
	      return false;
	    }
	  });
	  return false;
}
</script>
</body>
</html>
