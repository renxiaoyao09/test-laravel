<?php

namespace App\Http\Controllers\Mine\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login']]);
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = User::find(auth('api')->user()->id);
        $info = User::find(auth('api')->user()->id)->UserInfo;

        $userinfo = [
            'user'=>$user,
            'info'=>$info
        ];

        return commonResponse(200,'Successfully get!',$userinfo);
    }

    public function insert(Request $request)
    {
        //表单验证
        $this->validate($request,[
            'name'=>'required|regex:/^[A-Za-z][A-Za-z0-9]{2,9}$/',
            'email'=>'required|email',
            'password'=>'same:repassword'
        ],[
            'name.required'=>'用户名不能为空！',
            'name.regex'=>'用户名错误！',
            'email.required'=>'邮箱不能为空！',
            'email.email'=>'邮箱错误！',
            'password.same'=>'两次密码不一致！',
        ]);

        
        //判断请求中是否包含name=file的上传文件
        if(!$request->hasFile('profile')){
            exit('上传文件为空！');
        }
        $file = $request->file('profile');
        //判断文件上传过程中是否出错
        if(!$file->isValid()){
            exit('文件上传出错！');
        }
        //$img = $file -> getRealPath(); // 临时文件的绝对路径
        $entension = $file -> getClientOriginalExtension(); //  上传文件后缀
        $filename = date('YmdHis').mt_rand(100,999).'.'.$entension; // 重命名图片
        $date = date('Y-m-d');
        $path = $file->move(public_path().'\\uploads\\'.$date.'\\',$filename);  // 重命名保存
        $img_path = '/uploads/'.$date.'/'.$filename;  // 图片相对路径
        $serve_path = 'http://class1.com';
        // return $serve_path.$img_path;
        


        // 数据插入
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->profile = $request->profile;
        $user->remember_token = str_random(50);
        $user->imgUrl = $serve_path.$img_path;
        $user->save();
    }
}
