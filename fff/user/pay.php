<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
include 'header.php';
//支付公告
$paynotice=$DB->getRow("select * from `config` where `keys`='paynotice' limit 1");
//预设金额
$ysrmb1=$DB->getRow("select * from `config` where `keys`='ysrmb1' limit 1");
$ysrmb2=$DB->getRow("select * from `config` where `keys`='ysrmb2' limit 1");
$ysrmb3=$DB->getRow("select * from `config` where `keys`='ysrmb3' limit 1");
$zdyrmbmax=$DB->getRow("select * from `config` where `keys`='zdyrmbmax' limit 1");
$zdyrmbmin=$DB->getRow("select * from `config` where `keys`='zdyrmbmin' limit 1");
//预设金额
$alipay=$DB->getRow("select * from `config` where `keys`='alipay' limit 1");
$wxpay=$DB->getRow("select * from `config` where `keys`='wxpay' limit 1");
//比例设置
$ptbbili=$DB->getRow("select * from `config` where `keys`='ptbbili' limit 1");
$vipbili=$DB->getRow("select * from `config` where `keys`='vipbili' limit 1");
$xianyubili=$DB->getRow("select * from `config` where `keys`='xianyubili' limit 1");
?>
<link rel="stylesheet" type="text/css" href="/static/pay/css/main.css" />
<div class="kbox"></div><div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
  <div class="con">
	<h4><?php echo $paynotice['values']; ?></h4>
  </div>
</div>
<div class="kbox"></div><div class="kbox"></div>
<div class="clear"></div>
<div class="mypart2">
  <div class="con">
	<h2>充值角色信息：</h2>
	<h3>
	<br>角色ID：<?php echo $bindData['roleid']; ?>
	<br>角色名称：<?php echo $bindData['name']; ?>
	<br>所属大区：<?php echo $serverData['name']; ?>
	</h3><br>
	<h2>充值比例信息：</h2>
	<h3>
	<br>平台币比例：1元=<?php echo $serverData['ptb']; ?>币
	<br>累计充值比例：1元=<?php echo $serverData['charge']; ?>币
	<?php if($serverData['xianyu'] != 0){ ?>
	<br>赠送金元宝：1元=<?php echo $serverData['xianyu']; ?>点
	</h3>
	注意：充值前请确保人物处于在线状态，否则金元宝赠送失败，概不负责
	<?php } if($serverData['vip'] != 0){?>
	<h3>
	<br>赠送游戏内VIP经验：1元=<?php echo $serverData['vip']; ?>点
	</h3>
	注意：充值前请确保人物处于在线状态，否则游戏内VIP经验赠送失败，概不负责
	
	<?php }?>
	</h3>
	
  </div>
</div>
<div class="kbox"></div>
<div class="kbox"></div>
<div class="clear"></div>
<div class="clear"></div>
<div class="massegeBox">
        <div class="card-body">
		<form action="../pay/api.php" class="am-form" method="get" id="doc-vld-msg">
		<input value="1" name="types" style="display:none"/> 
					<div class="tr_rechbox">
						<div class="tr_rechli am-form-group">
							<h3>充值金额：</h3><br>
							<ul class="ui-choose am-form-group" id="uc_01">
								<li>
									<label class="am-radio-inline">
								        	<input type="radio"  value="<?php echo $ysrmb1['values']; ?>" name="money" required data-validation-message="请选择一项充值额度" checked="checked" /> <?php echo $ysrmb1['values']; ?>￥
									</label>
								</li>
								<li>
									<label class="am-radio-inline">
									        <input type="radio"  value="<?php echo $ysrmb2['values']; ?>" name="money" data-validation-message="请选择一项充值额度" /> <?php echo $ysrmb2['values']; ?>￥
								    </label>
								</li>

								<li>
									<label class="am-radio-inline">
									        <input type="radio"  value="<?php echo $ysrmb3['values']; ?>" name="money" data-validation-message="请选择一项充值额度" /> <?php echo $ysrmb3['values']; ?>￥
								    </label>
								</li>
								<li>
									<label class="am-radio-inline">
									        <input type="radio"  name="money" data-validation-message="请选择一项充值额度" /> 其他金额
								    </label>
								</li>
							</ul>
						</div>
						<div class="tr_rechoth am-form-group">
							<h3>其他金额：</h3><br>
							<input type="number" min="<?php echo $zdyrmbmin['values']; ?>" max="<?php echo $zdyrmbmax['values']; ?>" name="setmoney" class="othbox" data-validation-message="充值金额范围：<?php echo $zdyrmbmin['values']; ?>-<?php echo $zdyrmbmax['values']; ?>元" />
							<!--<p>充值金额范围：10-10000元</p>-->
						</div>
						<br>
						<div class="tr_rechli am-form-group">
							<h3>支付方式：</h3><br>
							<ul class="ui-choose am-form-group"">
							<?php if($wxpay['values']==1){ ?>
								<li>
									<label class="am-radio-inline">
								        	<input type="radio"  value="wxpay" name="type" required data-validation-message="请选择一种支付方式" checked="checked" /> <?php echo $number1; ?>微信
									</label>
								</li>
							<?php } if($alipay['values']==1){ ?>
								<li>
									<label class="am-radio-inline">
									        <input type="radio"  value="alipay" name="type" data-validation-message="请选择一种支付方式" /> <?php echo $number2; ?>支付宝
								    </label>
								</li>
							<?php } ?>
							</ul>
						</div>
						<div class="tr_rechnum">
							<span>应付金额：</span>
							<p class="rechnum">0元</p>
						</div>
					</div>
					<div class="tr_paybox" style="text-align:center;vertical-align:middle;">
						<input type="submit" value="确认支付" class="tr_pay am-btn" />
					</div>
				</form>
        </div>
</div>
<script type="text/javascript" src="/static/pay/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/pay/js/amazeui.min.js"></script>
<script type="text/javascript" src="/static/pay/js/ui-choose.js"></script>

<script type="text/javascript">
			// 将所有.ui-choose实例化
			$('.ui-choose').ui_choose();
			// uc_01 ul 单选
			var uc_01 = $('#uc_01').data('ui-choose'); // 取回已实例化的对象
			uc_01.click = function(index, item) {
				console.log('click', index, item.text())
			}
			uc_01.change = function(index, item) {
				console.log('change', index, item.text())
			}
			$(function() {
				$('#uc_01 li:eq(3)').click(function() {
					$('.tr_rechoth').show();
					$('.tr_rechoth').find("input").attr('required', 'true')
					$('.rechnum').text('<?php echo $ysrmb1['values']; ?>元');
				})
				$('#uc_01 li:eq(0)').click(function() {
					$('.tr_rechoth').hide();
					$('.rechnum').text('<?php echo $ysrmb1['values']; ?>元');
					$('.othbox').val('');
				})
				$('#uc_01 li:eq(1)').click(function() {
					$('.tr_rechoth').hide();
					$('.rechnum').text('<?php echo $ysrmb2['values']; ?>元');
					$('.othbox').val('');
				})
				$('#uc_01 li:eq(2)').click(function() {
					$('.tr_rechoth').hide();
					$('.rechnum').text('<?php echo $ysrmb3['values']; ?>元');
					$('.othbox').val('');
				})
				$(document).ready(function() {
					$('.othbox').on('input propertychange', function() {
						var num = $(this).val();
						$('.rechnum').html(num + "元");
					});
				});
			})

			$(function() {
				$('#doc-vld-msg').validator({
					onValid: function(validity) {
						$(validity.field).closest('.am-form-group').find('.am-alert').hide();
					},
					onInValid: function(validity) {
						var $field = $(validity.field);
						var $group = $field.closest('.am-form-group');
						var $alert = $group.find('.am-alert');
						// 使用自定义的提示信息 或 插件内置的提示信息
						var msg = $field.data('validationMessage') || this.getValidationMessage(validity);

						if(!$alert.length) {
							$alert = $('<div class="am-alert am-alert-danger"></div>').hide().
							appendTo($group);
						}
						$alert.html(msg).show();
					}
				});
			});
</script>
<?php
include 'footer.php';
?>

