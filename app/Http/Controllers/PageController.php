<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\Loaitin;
use App\TinTuc;
// use Illuminate\Support\Facades\View;

use Illuminate\Support\Facades\Auth;  // đùng để đăng nhập

class PageController extends Controller
{


    // function __contruct(){
    //     $theloai = TheLoai::all();
    //     view::share(['theloai'=>$theloai, 'slide'=>$slide]);
    // }

    function trangchu(){

        // $theloai= TheLoai::all();
        return view('pages.trangchu');
    }
    function lienhe(){

        // $theloai= TheLoai::all();
        return view('pages.lienhe');
    }
    function loaitin($id){
        $loaitin= LoaiTin::find($id);
        $tintuc=TinTuc::where('idLoaiTin',$id)->paginate(5);
        return view('pages.loaitin',['loaitin'=>$loaitin,'tintuc'=>$tintuc]);
    }
    function tintuc ($id){
        $tintuc=TinTuc::find($id);
        $tinnoibat=TinTuc::where('NoiBat',1)->take(4)->get();
        $tinlienquan=TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();
        return view('pages.tintuc',['tintuc'=>$tintuc,'tinnoibat'=>$tinnoibat,'tinlienquan'=>$tinlienquan]);
    }



    function getDangNhap(){
        return view('pages.dangnhap');
    }
    function postDangNhap(Request $request){
        $this->validate($request,
        [
    
            'email'=>'required',
            'password'=>'required|min:3|max:32',
    
        ],
        [
    
            'email.required'=>'bạn chưa nhập email',
            'password.required'=>'bạn chưa nhập password',
            'password.min'=>' password không được nhỏ hơn 3 kt',
            'password.max'=>' password không được lớn hơn 32 kt',
        ]);
    
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect('trangchu');
        }else{
            return redirect('dangnhap')->with('thongbao','dang nhập ko thành công');
        }
    }
    function getDangXuat(){
        Auth::logout();
        return redirect('trangchu');
    }
}
