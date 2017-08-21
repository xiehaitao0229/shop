<?php

namespace app\home\controller;

use think\Controller;
use app\common\model\User as UserModel;
use app\common\model\Category;
use think\Cookie;
use think\Session;

class User extends Controller
{
    private $categoryData;

    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub

        // 调取分类数据
        // 获取后台分类表数据
        $this->categoryData = (new Category())->where('pid',0)->select();
    }

    /**
     *  前台用户登陆
     */
    public function login(){

        if (request()->isPost()){
            $res = (new UserModel())->login(input('post.'));
            if ($res['valid']){
                $this->success($res['msg'],'/');
            }else{
                $this->error($res['msg']);
            }
            // 验证用户数据
        }

        $categoryData = $this->categoryData;
        return view('',compact('categoryData'));
    }

    /**
     * 前台用户退出
     */
    public function logout(){
        // 清除session（当前作用域）
        session(null);
        // 删除cookie
        Cookie::delete('PHPSESSID');

        $this->success('退出成功','/');

    }

    /**
     *  用户注册
     */
    public function register(){
        if(request()->isPost()){
            // 接受用户数据
            $res = (new UserModel())->userRegister(input('post.'));
            if ($res['valid']){
                $this->success($res['msg'],'/login.html');
            }else{
                $this->error($res['msg']);
            }
        }
        $categoryData = $this->categoryData;
        return view('',compact('categoryData'));
    }

    /**
     *  用户修改密码
     */
    public function changePassword(){

        if(request()->isPost()){
            $res = (new  UserModel())->changePassword(input('post.'));
            if(!$res['valid']){
                $this->error($res['msg']);
            }else{
                $this->success($res['msg']);
            }
        }
        $categoryData = $this->categoryData;
        return view('',compact('categoryData'));
    }

    /**
     *  个人中心
     */
    public function user(){
        if(request()->isPost()){
            // 验证用户信息 进行存入数据库
            $res = (new UserModel())->userInfo(input('post.'));
            // 如果有问题 给用户提示信息 返回原页面
            if (!$res['valid']){
                $this->error($res['msg']);
            }
        }
        // 获取用户信息
        $userInfo = UserModel::where('username',Session::get('user.user_username'))->find();
        $categoryData = $this->categoryData;
        return view('',compact('categoryData','userInfo'));
    }
}
