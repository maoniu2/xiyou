<?php
/* *
 * 配置文件
 */
include '../common/main.php';
//支付api
$apiurl=$DB->getRow("select * from `config` where `keys`='apiurl' limit 1");
//商户PID
$pid=$DB->getRow("select * from `config` where `keys`='pid' limit 1");
//商户KEY
$key=$DB->getRow("select * from `config` where `keys`='key' limit 1");
//比例设置
$ptbbili=$DB->getRow("select * from `config` where `keys`='ptbbili' limit 1");
$vipbili=$DB->getRow("select * from `config` where `keys`='vipbili' limit 1");
$xianyubili=$DB->getRow("select * from `config` where `keys`='xianyubili' limit 1");
//支付接口地址
$epay_config['apiurl'] = $apiurl['values'];

//商户ID
$epay_config['pid'] = $pid['values'];

//商户密钥
$epay_config['key'] = $key['values'];
/*
//比例
$ptbbili = $ptbbili['values'];

//仙玉比例
$xianyubili = $xianyubili['values'];

//VIP经验比例
$vipbili = $vipbili['values'];
*/
