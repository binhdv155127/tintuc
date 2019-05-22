<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\TinTuc;
use App\LoaiTin;
use App\Comment;

class TinTucController extends Controller
{
    public function getDanhSach(){
        // muốn dùng model the loại thì phải use nó

        $tintuc=TinTuc::orderBy('id','DESC')->get(); // câu truy vấn lấy ra csdl thể loại trong mysql 
         // sau khi lấy xong danh sách thể loại thì ta cần truyền sang bên view
          return view('admin.tintuc.danhsach',['tintuc'=>$tintuc]); // thể loại đầu là mình tự đặt còn $ biến là bên trên
          // truyền tham số sang bên vieew có thể dùng compact
    }


    public function getThem(){
        $theloai= TheLoai::all();
        $loaitin= LoaiTin::all();
        return view('admin.tintuc.them',['theloai'=>$theloai,'loaitin'=>$loaitin]);
    }

    public function postThem(Request $request){
        $this->validate($request, // bắt lỗi
        [
            'LoaiTin'=>'required' ,  // biến Tên là truyền từ bên form sang
            'TieuDe'=>'required|min:3|unique:TinTuc,TieuDe', 
            'TomTat'=>'required' ,
            'NoiDung'=>'required' ,
        ],
        [
            'LoaiTin.required'=>'bạn chưa chọn lt',
            'TieuDe.required'=>'bạn chưa chọn td',
            'TieuDe.min'=>'tên phài dài từ 3 đến 100 kí tự',
            'TieuDe.unique'=>'td đã tồn tại',
            'TomTat.required'=>'bạn chưa nhập tt',
            'NoiDung.required'=>'bạn chưa nhập nd',


        ]);
// sau khi bắt lỗi xong, thì mình lấy cái Ten nhập vào từ form, lưu vào model của mình
        $tintuc= new TinTuc;
        $tintuc->TieuDe=$request->TieuDe;
        $tintuc->TieuDeKhongDau=changeTitle($request->TieuDe);
        $tintuc->idLoaiTin=$request->LoaiTin;
        $tintuc->TomTat=$request->TomTat;
        $tintuc->NoiDung=$request->NoiDung;
        $tintuc->SoLuotXem=0;

        if ($request->hasFile('Hinh')) {
             $file=$request->file('Hinh'); // lưu hình vào biến file

             $duoi=$file->getClientOriginalExtension();
             if($duoi!='jpg'&& $duoi!='png' && $duoi='jpeg'){
                return redirect('admin/tintuc/them')->with('loi','bạn chỉ được thêm đuôi jpg, npg');
             }

             $name=$file->getClientOriginalName(); // lấy tên file ảnh
             $Hinh=str_random(4)."_".$name; // đặt tên ảnh ko bị trùng
             while (file_exists("upload/tintuc/".$Hinh)) { // kiểm tra xem trong folder tintuc đã có ảnh nào có tên là $Hình chưa, nếu có rồi thì đổi tiếp tên khác
                $Hinh=str_random(4)."_".$name;
             }
             $file->move("upload/tintuc",$Hinh);
             $tintuc->Hinh=$Hinh;
        } else {
           $tintuc->Hinh="";
        }
        
        $tintuc->save(); // hàm này để lưu vào csdl


        return redirect('admin/tintuc/them')->with('thongbao','them thành công');
    }





  public function getSua($id){
    $tintuc= TinTuc::find($id); // tìm tin túc có đúng có $id truyền vào
    // sau khi tìm xong thì truyền dữ liệu qua vieww để sửa
    $theloai= TheLoai::all();
    $loaitin= LoaiTin::all();
    return view('admin.tintuc.sua',['tintuc'=>$tintuc,'theloai'=>$theloai,'loaitin'=>$loaitin]);
  }

  public function postSua(Request $request,$id){  // id là cái truyền tham số trên url , còn $request là cái mình nhập vào form
    $tintuc= TinTuc::find($id); // tìm thể loại có $id truyền vào

    $this->validate($request,
    [
        'LoaiTin'=>'required' ,  // biến Tên là truyền từ bên form sang
        'TieuDe'=>'required|min:3|unique:TinTuc,TieuDe', 
        'TomTat'=>'required' ,
        'NoiDung'=>'required' ,
    ],
    [
        'LoaiTin.required'=>'bạn chưa chọn lt',
        'TieuDe.required'=>'bạn chưa chọn td',
        'TieuDe.min'=>'tên phài dài từ 3 đến 100 kí tự',
        'TieuDe.unique'=>'td đã tồn tại',
        'TomTat.required'=>'bạn chưa nhập tt',
        'NoiDung.required'=>'bạn chưa nhập nd',


    ]);
        $tintuc->TieuDe=$request->TieuDe;
        $tintuc->TieuDeKhongDau=changeTitle($request->TieuDe);
        $tintuc->idLoaiTin=$request->LoaiTin;
        $tintuc->TomTat=$request->TomTat;
        $tintuc->NoiDung=$request->NoiDung;
    

        if ($request->hasFile('Hinh')) {
             $file=$request->file('Hinh');

             $duoi=$file->getClientOriginalExtension();
             if($duoi!='jpg'&& $duoi!='png' && $duoi='jpeg'){
                return redirect('admin/tintuc/them')->with('loi','bạn chỉ được thêm đuôi jpg, npg');
             }

             $name=$file->getClientOriginalName();
             $Hinh=str_random(4)."_".$name;
             while (file_exists("upload/tintuc/".$Hinh)) {
                $Hinh=str_random(4)."_".$name;
             }
             unlink("upload/tintuc/".$tintuc->Hinh);
             $file->move("upload/tintuc",$Hinh);
             $tintuc->Hinh=$Hinh;
        } 
        $tintuc->save(); // hàm này để lưu vào csdl


        return redirect('admin/tintuc/sua/'.$id)->with('thongbao','sửa thành công');
  }


  public function getXoa($id){
    $tintuc= TinTuc::find($id); // tìm thể loại có $id truyền vào
    $tintuc->delete();
    

    return redirect('admin/tintuc/danhsach')->with('thongbao','xóa thành công');
  }
}
