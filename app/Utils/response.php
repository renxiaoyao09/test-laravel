<?php


// 写完执行命令：composer dump-auto
// function_exists检测函数是否存在
  /**
   * Get the token array structure.
   *
   * @param  string $token
   *
   * @return \Illuminate\Http\JsonResponse
   */
  if (!function_exists('commonResponse')) {
    function commonResponse($status=200,$message='',$data=[])
    {
        return response()->json([
          "status"=>$status,
          "message"=>$message,
          "data"=>$data,
        ],$status);
    }
  }
  