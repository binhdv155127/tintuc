<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TinTuc extends Model
{
    //
    protected $table="TinTuc";

    public function loaitin(){

        // 1 tin thuộc về 1 loại tin
        return $this->belongsTo('App\Loaitin','idLoaiTin','id');
    }

    public function comment(){// lấy ra các comment, trong tin túc có cmt nào
         // tin tức có nhiều cmt=> hasMany
        return $this->hasMany('App\Comment','idTinTuc','id');
    }
}
