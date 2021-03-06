<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     * 要求附带name和password（数据来源users表）
     * 
     * @return void
     */
    public function __construct()
    {
        // 这里额外注意了：官方文档样例中只除外了『login』
        // 这样的结果是，token 只能在有效期以内进行刷新，过期无法刷新
        // 如果把 refresh 也放进去，token 即使过期但仍在刷新期以内也可刷新
        // 不过刷新一次作废
        // $this->middleware('auth:api', ['except' => ['login']]);
        $this->middleware('jwt.auth', ['except' => ['login']]);
        // 另外关于上面的中间件，官方文档写的是『auth:api』
        // 但是我推荐用 『jwt.auth』，效果是一样的，但是有更加丰富的报错信息返回
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request(['name', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            // return response()->json(['error' => 'Unauthorized'], 401);
            return commonResponse(401,'Unauthorized');
        }

        // $user_info = User::where('name', $request['name'])->first()
        // ->toarray();
        // $user_info->access_token = $token;
        // $user_info->save();
        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ];
        return commonResponse(200,'Successfully login!',$data);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        // return response()->json(['message' => 'Successfully logged out']);
        return commonResponse(200,'Successfully logged out');
    }

    /**
     * Refresh a token.
     * 刷新token，如果开启黑名单，以前的token便会失效。
     * 值得注意的是用上面的getToken再获取一次Token并不算做刷新，两次获得的Token是并行的，即两个都可用。
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return commonResponse(200,'Successfully refresh',auth('api')->refresh());
        // return $this->respondWithToken(auth('api')->refresh());
    }

    

}
