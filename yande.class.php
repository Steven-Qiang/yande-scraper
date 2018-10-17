<?php

/** 
 * yande图片api类
 * 
 * 获取yande.re图片 包括搜索tag 获取tag下的图片 
 * @author      QiangGe <2962051004@qq.com> 
 * @Date		2018-10-14 16:07
 */
/* 引入phpquery */
require('QueryList/require.php');
use QL\QueryList;


class yande
{
    /** 
     * post  
     * 获取post图片
     * 
     * @access private 
     * @param mixed $data get参数 array
     * @return array 
     * example
     [
     "id"=> "488184",
     "show"=> ating: Questionable Score: 10 Tags: bikini_top bottomless erect_nipples onjouji_toki saki tagme thighhighs User: BattlequeenYume",
     "thumb"=> "https://assets.yande.re/data/preview/0d/b0/0db0134490daa0e256460a0d05f7ee77.jpg",
     "large"=> "https://files.yande.re/jpeg/0db0134490daa0e256460a0d05f7ee77/yande.re%20488184%20bikini_top%20bottomless%20erect_nipples%20onjouji_toki%20saki%20tagme%20thighhighs.jpg"
     ]
     */
    private static function post($data)
    {
        $tmp = QueryList::get('https://yande.re/post', $data)->rules(array(
            'id' => array( // 图片id
                '#post-list-posts li',
                'id'
            ),
            'alt' => array( // 图片alt
                '#post-list-posts li .thumb img',
                'alt'
            ),
            'thumb' => array( // 缩略图地址
                '#post-list-posts li .thumb img',
                'src'
            ),
            'large' => array( // 原图地址
                '#post-list-posts li .largeimg',
                'href'
            )
        ))->query()->getData()->all();
        
        if ($tmp) {
            $data = array();
            foreach ($tmp as $k => $val) {
                $id = trim($val["id"], "p"); // 去掉id开头的p
                $data[$k] = array(
                    "id" => $id,
                    "show" => 'https://yande.re/post/show/' . $id, // 官方shou地址
                    "alt" => $val['alt'], // 图片描述
                    'thumb' => $val['thumb'], // 缩略图地址
                    'large' => $val['large'] // 原图地址
                );
            }
            return array(
                "massage" => "",
                "data" => $data
            );
        }
        return array(
            "massage" => "no data",
            "data" => array()
        );
    }
    /** 
     * searchTag  
     * 搜索tag
     * 
     * @access public 
     * @param mixed $keyword 关键词
     * @param mixed $order 排列方式	  name => 名称
				     count => tag下图片数量
				     date => 时间
     * @param mixed $type 搜索类型	  0 => General
				     1 => Artist
				     3 => Copyright
				     4 => Character
				     5 => Circle
				     6 => Faults
     * @return array 
     * example
     [
     "count"=> "8",
     "name"=> "28aarts",
     "type"=> "artist"
     ]
     */
    static public function searchTag($keyword, $order, $type)
    {
        $data = QueryList::get('https://yande.re/tag', array(
            "name" => $keyword,
            "order" => $order,
            "type" => $type,
            "commit" => "Search"
        ))->rules(array(
            'count' => array(
                '.highlightable tbody tr td:first-child',
                'html'
            ),
            'name' => array(
                '.highlightable tbody tr td:nth-child(2) a:last-child',
                'html'
            ),
            'type' => array(
                '.highlightable tbody tr td:nth-child(3)',
                'html'
            )
            
        ))->query()->getData()->all();
        return array(
            "massage" => "",
            "data" => $data
        );
    }
    /** 
     * index  
     * 获取首页图片
     * 
     * @access public 
     * @param mixed $page 页数
     * @return array
     */
    static public function index($page)
    {
        return self::post(array(
            'page' => $page
        ));
        
    }
    /** 
     * tag  
     * 获取tag图片
     * 
     * @access public 
     * @param mixed $tag tag名称
     * @return array
     */
    static public function tag($tag, $page)
    {
        return self::post(array(
            'tags' => $tag,
			'page' => $page
        ));
        
    }
}
