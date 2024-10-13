<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
include('./common/main.php');
	//网站信息
		$title=$DB->getRow("select * from `config` where `keys`='title' limit 1");
		$keywords=$DB->getRow("select * from `config` where `keys`='keywords' limit 1");
		$description=$DB->getRow("select * from `config` where `keys`='description' limit 1");
	//版权信息
		$banquan=$DB->getRow("select * from `config` where `keys`='banquan' limit 1");
//
if(isset($post['gmma']) && $post['gmma'] != null){
	$poster = daddslashes($post['gmma']);
}else{
	if(isset($post['serverid'])){
		exit('{"code":0,"msg":"GM码不能为空"}');
	}else{
		$poster = null;
	}
}
if($poster != null){
	$gmma = addslashes($post['gmma']);
	if($gmma == null )exit('{"code":0,"msg":"GM码不能为空"}');
	if($gmma != '123321' )exit('{"code":0,"msg":"GM码不正确"}');
	$flag = ":";
	$flag1 = "\\";
	$flag2 = 'export LANG="zh_CN.UTF-8" && ';
    $serverid = addslashes($post['serverid']);
    $serverData=$DB->getRow("select * from `servers` where id='$serverid' limit 1");
    $port = $serverData['port'];
	$caozuo = addslashes($post['caozuo']);
    $uid = addslashes($post['roleid']);
	if($uid == null )exit('{"code":0,"msg":"角色ID不能为空"}');
			if($caozuo==1){
				$cmd = $flag2 . 'java -jar ./static/api/jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "nonvoice ' . $uid . ' 64000000 GM 0"';
				exec($cmd, $out);
				if(success_cmd($out)){
				$tishi = "禁言成功！";
				$caozuoinfo = "【禁言】角色id：".$uid;
				}else{
				exit('{"code":0,"msg":"操作失败！"}');
				}
			}elseif($caozuo==2){
				$cmd = $flag2 . 'java -jar ./static/api/jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "unnonvoice ' . $uid . '"';
				exec($cmd, $out);
				if(success_cmd($out)){
				$tishi = "解除禁言成功！";
				$caozuoinfo = "【解除禁言】角色id：".$uid;
				}else{
				exit('{"code":0,"msg":"操作失败！"}');
				}
			}elseif($caozuo==6){
				$cmd = $flag2 . 'java -jar ./static/api/jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=9845" "roleId=' . $uid . '" "forbid#' . $uid . '#999999#1"';
				exec($cmd, $out);
				if(success_cmd($out)){
				$tishi = "封号成功！";
				$caozuoinfo = "【封号】角色id：".$uid;
				}else{
				exit('{"code":0,"msg":"操作失败！"}');
				}
			}elseif($caozuo==7){
				$cmd = $flag2 . 'java -jar ./static/api/jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "unforbid ' . $uid . '"';
				exec($cmd, $out);
				if(success_cmd($out)){
				$tishi = "解除封号成功！";
				$caozuoinfo = "【解除封号】角色id：".$uid;
				}else{
				exit('{"code":0,"msg":"操作失败！"}');
				}
			}elseif($caozuo==10){
				$cmd = $flag2 . 'java -jar ./static/api/jmxc.jar "" "" "127.0.0.1" "' . $port . '" "gm" "userId=4096" "roleId=' . $uid . '" "kick ' . $uid . '"';
				exec($cmd, $out);
				if(success_cmd($out)){
				$tishi = "强制下线成功！";
				$caozuoinfo = "【强制下线】角色id：".$uid;
				}else{
				exit('{"code":0,"msg":"操作失败！"}');
				}
			}
	exit('{"code":1,"msg":"'.$tishi.'"}');
}
?>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?php echo $title['values'];?></title>
<link rel="icon" href="favicon.ico" type="image/ico">
<meta name="keywords" content="<?php echo $keywords['values'];?>">
<meta name="description" content="<?php echo $description['values'];?>">
<link href="/static/admin/css/bootstrap.min.css" rel="stylesheet">
<link href="/static/admin/css/materialdesignicons.min.css" rel="stylesheet">
<!--标签插件-->
<link rel="stylesheet" href="/static/admin/js/jquery-tags-input/jquery.tagsinput.min.css">
<link href="/static/admin/css/style.min.css" rel="stylesheet">

<!-- 加载 Jquery -->
<script src="/static/admin/select/jquery-3.2.1.min.js"></script>
<!-- 加载 Select2 -->
<link href="/static/admin/select/select2.min.css" rel="stylesheet" />
<script src="/static/admin/select/select2.min.js"></script>
<script src="/static/admin/layer/layer.js"></script>
</head>
  
<body>
<div class="container-fluid p-t-15">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          
          <form onsubmit="return gm(this)" method="post" class="row">
			<div class="form-group col-md-12">
				<label for="gmma">GM码</label>
				<small style="color:blue">**必填**</small>
				<input type="text" class="form-control" name="gmma" value="" placeholder="请输入GM码" />
			</div>
			<div class="form-group col-md-12">
				<label>选择大区</label>
				<select name="serverid" class="form-control">
				<?php
				$rs=$DB->query("SELECT * FROM `servers` order by id");
				while($res = $rs->fetch())
				{
				echo '<option value="'.$res['id'].'">'.$res['name'].'</option>';
				}
				?> 
				</select>
			</div>
			<div class="form-group col-md-12">
				<label for="roleid">角色ID</label>
				<small style="color:blue">**必填**</small>
				<input type="text" class="form-control" name="roleid" value="" placeholder="请输入角色ID" />
			</div>
			<div class="form-group col-md-12">
				<label for="caozuo">选择操作内容</label>
				<select name="caozuo" class="form-control" id="caozuo" >
					<option value="1">禁言</option>
					<option value="2">解除禁言</option>
					<option value="6">封禁账号</option>
					<option value="7">解除账号封禁</option>
					<option value="10">强制下线</option>
				</select>
			</div>
            <div class="form-group col-md-12">
              <button type="submit" class="btn btn-primary ajax-post" target-form="add-form">确认</button>
            </div>
          </form>
 
        </div>
      </div>
    </div>
    
  </div>
</div>

<script src="/static/admin/js/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="/static/admin/js/bootstrap-datepicker/locales/bootstrap-datepicker.zh-CN.min.js"></script>


<script type="text/javascript" src="/static/admin/js/jquery.min.js"></script>
<script src="/static/admin/layer/layer.js"></script>
<script type="text/javascript" src="/static/admin/js/bootstrap.min.js"></script>
<!--标签插件-->
<script src="/static/admin/js/jquery-tags-input/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="/static/admin/js/main.min.js"></script>
<script>
function gm(obj){
	  var ii = layer.load(2, {shade:[0.1,'#fff']});
	  $.ajax({
	    type : 'POST',
	    url : './gm.php',
	    data : $(obj).serialize(),
	    dataType : 'json',
	    success : function(data) {
	      layer.close(ii);
	      if(data.code == 1){
	       // layer.alert(data.msg, {icon: 1,closeBtn: false}, function(){window.location.reload()});
	       layer.alert(data.msg, {icon: 1,closeBtn: false});
	      }else{
	        layer.alert(data.msg, {icon: 2})
	      }
	    },
	    error:function(data){
	      layer.msg('服务器错误');
	      return false;
	    }
	  });
	  return false;
}
</script>
</body>
</html>