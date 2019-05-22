<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;

class TheLoaiController extends Controller
{
    public function getDanhSach(){
        // muốn dùng model the loại thì phải use nó

        $theloai=TheLoai::all(); // câu truy vấn lấy ra csdl thể loại trong mysql 
         // sau khi lấy xong danh sách thể loại thì ta cần truyền sang bên view
          return view('admin.theloai.danhsach',['theloai'=>$theloai]); // thể loại đầu là mình tự đặt còn $ biến là bên trên
          // truyền tham số sang bên vieew có thể dùng compact
    }


    public function getThem(){
        return view('admin.theloai.them');
    }

    public function postThem(Request $request){
        $this->validate($request, // bắt lỗi
        [
            'Ten'=>'required|min:3|max:100|unique:TheLoai,Ten'   // biến Tên là truyền từ bên form sang
        ],
        [
            'Ten.required'=>'bạn chưa nhập',
            'Ten.unique'=>'tên đã tồn tại',
            'Ten.min'=>'tên phài dài từ 3 đến 100 kí tự',
            'Ten.max'=>'tên phài dài từ 3 đến 100 kí tự',

        ]);
// sau khi bắt lỗi xong, thì mình lấy cái Ten nhập vào từ form, lưu vào model của mình
        $theloai= new TheLoai;
        $theloai->Ten=$request->Ten;
        $theloai->TenKhongDau=changeTitle($request->Ten); //để tạo cái tiêu đề không dấu, hay link thân thiện thì laravel đã hổ trợ hàm str_slug() rồi. Em sử dụng $tieude=str_slug($request->Ten,'-')

        $theloai->save();


        return redirect('admin/theloai/them')->with('thongbao','them thành công');
    }





  public function getSua($id){
    $theloai= TheLoai::find($id); // tìm thể loại có $id truyền vào
    // sau khi tìm xong thì truyền dữ liệu qua vieww để sửa
    return view('admin.theloai.sua',['theloai'=>$theloai]);
  }

  public function postSua(Request $request,$id){  // id là cái truyền tham số trên url , còn $request là cái mình nhập vào form vì nó gửi lên từ form
    $theloai= TheLoai::find($id); // tìm thể loại có $id truyền vào

    $this->validate($request,
    [
        'Ten'=>'required|unique:TheLoai,Ten|min:3|max:100'// unique để tên ko bị trùng trong bảng thể loại, ở cột tên
    ],
    [
        'Ten.required'=>'bạn chưa nhập tên thể loại',
        'Ten.unique'=>'tên đã tồn tại',
        'Ten.min'=>'tên phài dài từ 3 đến 100 kí tự',
        'Ten.max'=>'tên phài dài từ 3 đến 100 kí tự',
    ]);
        $theloai->Ten=$request->Ten;
        $theloai->TenKhongDau=changeTitle($request->Ten);
        $theloai->save();


        return redirect('admin/theloai/sua/'.$id)->with('thongbao','sửa thành công');
  }


  public function getXoa($id){
    $theloai= TheLoai::find($id); // tìm thể loại có $id truyền vào
    $theloai->delete();
    

    return redirect('admin/theloai/danhsach')->with('thongbao','xóa thành công');
  }
}
