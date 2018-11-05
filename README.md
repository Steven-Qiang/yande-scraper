## 获取 yande.re 的图片

### 说明

获取yande.re的图片信息，包括搜索，获取tag，搜索tag。其他功能暂不谢写

需要国外的服务器，环境：**php>7.0**



写这些只是爱好。

### 方法说明

#### yande::index

```php
 /**  
     * 获取首页图片
     * 
     * @access public 
     * @param integer $page 页数
     * @return array
*/
yande::index($page)
```

#### yande::tag

```php
/**  
     * 获取tag图片
     * 
     * @access public 
     * @param string $tag tag名称
     * @return array
*/
yande::tag($tag, $page)
```

#### yande::searchTag

```php
  /**   
     * 搜索tag
     * 
     * @access public 
     * @param string $keyword 关键词
     * @param integer $order 排列方式 {name: 名称 count: tag下图片数量 date: 时间}
     * @param integer $type 搜索类型 {0: General 1: Artist 3: Copyright 4: Character 5: Circle 6: Faults}
     * @return array
*/
yande::searchTag($keyword, $order, $type)
```



### 将它作为接口？

example.php 为示例文件，作为参考

获取首页的图片 ./example.php?page=页数

获取tag的图片 ./example.php?tag=tag名称&page=页数

搜索tag ./example.php?do=searchTag&keyword=关键词&order=排序方式&type=搜索类型

##### 字符所对应的排序方式 

| name  | 名称       |
| ----- | -------- |
| count | tag下图片数量 |
| date  | 时间       |

##### 字符所对应的搜索类型

| 0    | General   |
| ---- | --------- |
| 1    | Artist    |
| 2    | Copyright |
| 3    | Character |
| 4    | Circle    |
| 5    | Faults    |

## Bug

如果有什么问题，请提交issues