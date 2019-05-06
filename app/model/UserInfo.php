<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    /**
     * 拥有该信息的用户
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
    public $timestamps = false;
    public $incrementing = false;
    public $primaryKey = 'user_id';
    public $keyType = 'string';
    
    protected $fillable = ['user_id','nickname','imageUrl','editor','language','letter','notification',];

}
