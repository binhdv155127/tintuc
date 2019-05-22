<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;

class LoaiTinController extends Controller
{
    public function getDanhSach(){
        // muốn dùng model the loại thì phải use nó

        $loaitin=Loaitin::all(); // câu truy vấn lấy ra csdl thể loại trong mysql 
         // sau khi lấy xong danh sách thể loại thì ta cần truyền sang bên view
          return view('admin.loaitin.danhsach',['loaitin'=>$loaitin]); // thể loại đầu là mình tự đặt còn $ biến là bên trên
          // truyền tham số sang bên vieew có thể dùng compact
    }







    public function getThem(){
        $theloai=TheLoai::all();
        return view('admin.loaitin.them',['theloai'=>$theloai]);
    }

    public function postThem(Request $request){
        $this->validate($request, // bắt lỗi
        [
            'Ten'=>'required|min:1|max:100|unique:LoaiTin,Ten',   // biến Tên là truyền từ bên form sang
            'TheLoai'=>'required'
        ],
        [
            'Ten.required'=>'bạn chưa nhập',
            'Ten.unique'=>'tên đã tồn tại',
            'Ten.min'=>'tên phài dài từ 3 đến 100 kí tự',
            'Ten.max'=>'tên phài dài từ 3 đến 100 kí tự',
            'TheLoai.required'=>'bạn chưa nhập',

        ]);
// sau khi bắt lỗi xong, thì mình lấy cái Ten nhập vào từ form, lưu vào model của mình
        $loaitin= new LoaiTin;
        $loaitin->Ten=$request->Ten;
        $loaitin->TenKhongDau=changeTitle($request->Ten);
        $loaitin->idTheLoai=$request->TheLoai;
        $loaitin->save();


        return redirect('admin/loaitin/them')->with('thongbao','them thành công');
    }





  public function getSua($id){
    $loaitin= LoaiTin::find($id); // tìm loại tin có $id truyền vào
    $theloai= TheLoai::all();  // lấy ra tất cả các thể loại để lựa chọn bên view
    // sau khi tìm xong thì truyền dữ liệu qua vieww để sửa
    return view('admin.loaitin.sua',['loaitin'=>$loaitin,'theloai'=>$theloai]);
  }

  public function postSua(Request $request,$id){  // id là cái truyền tham số trên url , còn $request là cái mình nhập vào form
    

    $this->validate($request,
    [
        'Ten'=>'required|min:1|max:100|unique:LoaiTin,Ten',   // biến Tên là truyền từ bên form sang
        'TheLoai'=>'required'
    ],
    [
        'Ten.required'=>'bạn chưa nhập',
        'Ten.unique'=>'tên đã tồn tại',
        'Ten.min'=>'tên phài dài từ 3 đến 100 kí tự',
        'Ten.max'=>'tên phài dài từ 3 đến 100 kí tự',
        'TheLoai.required'=>'bạn chưa nhập',

    ]);
        $loaitin=LoaiTin::find($id);
        $loaitin->Ten=$request->Ten;
        $loaitin->TenKhongDau=changeTitle($request->Ten);
        $loaitin->idTheLoai=$request->TheLoai;
        $loaitin->save();


        return redirect('admin/loaitin/sua/'.$id)->with('thongbao','sửa thành công');
  }





  public function getXoa($id){
    $loaitin= LoaiTin::find($id); // tìm thể loại có $id truyền vào
    $loaitin->delete();
    

    return redirect('admin/loaitin/danhsach')->with('thongbao','xóa thành công');
  }
}
