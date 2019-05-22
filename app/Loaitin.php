<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loaitin extends Model
{
    //
    protected $table="Loaitin";


    public function theloai(){ // loại tin thuộc thể loại nào 

        // loại tin thuộc thể laoij nào => belongsTo
        return $this->belongsTo('App\TheLoai','idTheLoai','id');
    }

    public function tintuc(){// trong loại tin có bn tin tức
        return $this->hasMany('App\TinTuc','idLoaiTin','id');
    }
}
