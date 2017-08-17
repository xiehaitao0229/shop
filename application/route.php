<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

////如果有定义绑定后台模块则禁用路由规则
//if (defined('BIND_MODULE') && BIND_MODULE == 'admin')
//    return [];

use think\Route;

Route::rule('/','home/Entry/index');

// user路由组
Route::group(['ext'=>'html'],function(){
    // method ：请求方法
    Route::rule('register','home/User/register','GET|POST');
    Route::rule('login','home/User/login','GET|POST');
    Route::get('logout','home/User/logout');
    // 个人中心
    Route::get('user','home/User/user');
});

// 首页路由组
Route::group(['ext'=>'html'],function(){
    // 商品分类路由
   Route::rule('category/:cid','home/Entry/category');
});

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];


