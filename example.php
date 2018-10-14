<?php
/** 
 * yande api 示例文件
 * 
 * 获取yande.re图片 
 * @author      QiangGe <2962051004@qq.com> 
 * @Date		2018-10-14 16:07
 */

require('yande.class.php');

function response($arr)
{
    header('Content-Type:application/json');
    echo json_encode($arr);
    exit;
}
switch ($_GET['do']) {
    case "tag":
        response(yande::tag($_GET['tag'], $_GET['page']));
    /*
     * 获取tag的图片
     */
    case "searchTag":
        response(yande::searchTag($_GET['keyword'], $_GET['order'], $_GET['type']));
    /*
     * 查询tag
     */
    default:
        response(yande::index($_GET['page']));
        /*
         * 默认获取首页图片
         */
}