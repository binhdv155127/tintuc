<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table="Comment";

    public function tintuc(){ // để biết cmt thuộc tin tức nào
        return $this->belongsTo('App\TinTuc','idTinTuc','id');
    }

    public function user(){//để biết cmt là của ai
        return $this->belongsTo('App\User','idUser','id');
    }
}
