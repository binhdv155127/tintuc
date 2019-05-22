<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\TheLoai;
// use App\TinTuc;
// use App\LoaiTin;
use App\Comment;
use App\TinTuc;
use Illuminate\Support\Facades\Auth;  // đùng để đăng nhập

class CommentController extends Controller
{
   

  public function getXoa($id,$idTinTuc){
    $comment= Comment::find($id); // tìm thể loại có $id truyền vào
    $comment->delete();
    

    return redirect('admin/tintuc/sua/'.$idTinTuc)->with('thongbao','xóa thành công');
  }

  public function postComment($id,Request $request){
    $idTinTuc=$id;
    $tintuc=TinTuc::find($id);
    $comment=new Comment;
    $comment->idTinTuc=$idTinTuc;
    $comment->idUser=Auth::user()->id;
    $comment->NoiDung=$request->NoiDung;
    $comment->save();
    return redirect("tintuc/$id/".$tintuc->TieuDeKhongDau.".html")->with('thongbao','bt thành công');
  }
}
