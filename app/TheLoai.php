<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    //
    protected $table="TheLoai";

    public function loaitin(){ // lấy ra tất cả các loại tin của thằng thể loại này
        // 1 thể loại có nhiều loại tin => dùng hasMany

        // App\loại tin trỏ tới loại tin||| khóa phụ||| khóa chính
        return $this->hasMany('App\LoaiTin','idTheLoai','id');
    }
    public function tintuc(){ // lấy ra hết các tin tức trong thể loại (từ các loại tin khác nhau)

        // liên kết từ tin tức thông qua bảng loại tin đến thể loại => dùng hasManyThrough

        
        return $this->hasManyThrough('App\Tintuc','App\LoaiTin','idTheLoai','idLoaiTin','id');
    }
}
