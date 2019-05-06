<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\model\UserInfo;
use Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    //
    
    /**
     * 注册用户
     */
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        // //判断请求中是否包含name=file的上传文件
        // if(!$request->hasFile('profile')){
        //     exit('上传文件为空！');
        // }
        // $file = $request->file('profile');
        // //判断文件上传过程中是否出错
        // if(!$file->isValid()){
        //     exit('文件上传出错！');
        // }
        // //$img = $file -> getRealPath(); // 临时文件的绝对路径
        // $entension = $file -> getClientOriginalExtension(); //  上传文件后缀
        // $filename = date('YmdHis').mt_rand(100,999).'.'.$entension; // 重命名图片
        // $date = date('Y-m-d');
        // $path = $file->move(public_path().'\\uploads\\'.$date.'\\',$filename);  // 重命名保存
        // $img_path = '/uploads/'.$date.'/'.$filename;  // 图片相对路径
        // $serve_path = 'http://class1.com';

        $userinfo = UserInfo::create([
            'user_id' => $user->id,
            'nickname' => $request['name'],
            // 'imageUrl' => $serve_path.$img_path,
            'imageUrl' => 'http://class1.com/images/t01b980c2d49d17e06d.jpg',
            'editor' => 1,
            'language' => 1,
            'letter' => 1,
            'notification' => 1,
        ]);

        return commonResponse(200,'Successfully register!',$user);
    }

    
}
