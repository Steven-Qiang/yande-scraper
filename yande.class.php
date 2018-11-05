<?php

/*
* yande 图片爬虫类
* @author QangMouRen<2962051004@qq.com>
* @github https://github.com/QiangMouRen/yande_scraper
* @version 1.0
* @static 变量、类、函数是静态的
*/
require('QueryList/require.php');
use QL\QueryList;


class yande
{
	
    /** 
     * 获取post图片
     * @static 该函数是静态的
     * @access private 
     * @param array $data get参数
     * @return array 
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
     * 搜索tag
     * @static 该函数是静态的
     * @access public 
     * @param string $keyword 关键词
     * @param integer $order 排列方式 {name: 名称 count: tag下图片数量 date: 时间}
     * @param integer $type 搜索类型 {0: General 1: Artist 3: Copyright 4: Character 5: Circle 6: Faults}
     * @return array
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
     * 获取首页图片
     * @static 该函数是静态的
     * @access public 
     * @param integer $page 页数
     * @return array
     */
    static public function index($page)
    {
        return self::post(array(
            'page' => $page
        ));
        
    }
    /** 
     * 获取tag图片
     * @static 该函数是静态的
     * @access public 
     * @param string $tag tag名称
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
