<?php
/* 
萨摩不爱笑
QQ 366067876
趣游猫 quyoumao.com
*/
foreach ((array)$_GET as $get_key=>$get_var)
{
    if (is_numeric($get_var)) {
        $get[$get_key] = get_int($get_var);
    } else {
        $get[$get_key] = get_str($get_var);
    }
}
/* 过滤所有POST过来的变量 */
foreach ((array)$_POST as $post_key=>$post_var)
{
    if (is_numeric($post_var)) {
        $post[$post_key] = get_int($post_var);
    } else {
        $post[$post_key] = get_str($post_var);
    }
}
/* 过滤函数 */
//整型过滤函数
function get_int($number)
{
    return intval($number);
}
//字符串型过滤函数
function get_str($string)
{
    if (!get_magic_quotes_gpc()) {
        return addslashes($string);
    }
    return $string;
}


?>