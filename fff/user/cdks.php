<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
include 'header.php';
?>
<link rel="stylesheet" type="text/css" href="/static/pay/css/main.css" />
<div class="kbox"></div><div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
	<h3>
        <form onsubmit="return cdks(this)" method="post" class="form-inline pull-right" >
		  <div class="con">
			<br>
			<br>
            <div style="text-align:center;">
              <label>CDK：</label>
              <input type="text" class="form-control"  name="codes" value="" style="width:360px;height:46px;border-radius:10px" placeholder="　请输入获取的CDK" />
            </div>
			<br>
			<br>
		  </div>
		  <div class="tr_paybox" style="text-align:center;vertical-align:middle;">
				<input type="submit" value="确认兑换" class="tr_pay" />
		  </div>
        </form>
	</h3>
</div>
<script>
function cdks(obj){
	  var ii = layer.load(2, {shade:[0.1,'#fff']});
	  $.ajax({
	    type : 'POST',
	    url : './ajax.php?act=cdks',
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

