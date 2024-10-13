<?php
/*
本后台只允许自行研究使用，适用于mt3源代码
切勿用于非法用途，否则后果自负
如用于非法用途使用，所产生的一切后果，与本人及社区无关
QQ：366067876
*/
include '../common/main.php';
function jiami($data, $key){
    $key    =    md5($key);
    $x        =    0;
    $len    =    strlen($data);
    $l        =    strlen($key);
    for ($i = 0; $i < $len; $i++){
        if ($x == $l) {
            $x = 0;
        }
        $char .= $key{$x};
        $x++;
    }
    for ($i = 0; $i < $len; $i++) {
		$str.=ord($data{$i})-ord($char{$i}).'MHXY';/*用于分割密文的分割符,必须与解密里的一致*/
    }
    return $str;
}
$username = addslashes($get['user']);
$account=$DB->getRow("select * from `account` where `username`='$username'");
$key1="fuckmhxysmd";
$data1="cczsdk@".$account['id']."@@cczsdk";
echo jiami($data1,$key1);
exit;
?>