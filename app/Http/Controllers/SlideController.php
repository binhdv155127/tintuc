<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Slide;

class SlideController extends Controller
{
    public function getDanhSach(){
        // muốn dùng model the loại thì phải use nó

        $slide=Slide::all(); // câu truy vấn lấy ra csdl thể loại trong mysql 
         // sau khi lấy xong danh sách thể loại thì ta cần truyền sang bên view
          return view('admin.slide.danhsach',['slide'=>$slide]); // thể loại đầu là mình tự đặt còn $ biến là bên trên
          // truyền tham số sang bên vieew có thể dùng compact
    }


    public function getThem(){
        return view('admin.slide.them');
    }

    public function postThem(Request $request){
        $this->validate($request, // bắt lỗi
        [
            'Ten'=>'required' ,  // biến Tên là truyền từ bên form sang
            'NoiDung'=>'required' ,
        ],
        [
            'Ten.required'=>'bạn chưa nhập ten',
            'NoiDung.required'=>'bạn chưa nhập nd',
            

        ]);
// sau khi bắt lỗi xong, thì mình lấy cái Ten nhập vào từ form, lưu vào model của mình
        $slide= new Slide;
        $slide->Ten=$request->Ten;
        $slide->NoiDung=$request->NoiDung;

        if ($request->has('link')) {
            $slide->link= $request->link;
            if ($request->hasFile('Hinh')) {
                $file=$request->file('Hinh');
   
                $duoi=$file->getClientOriginalExtension();
                if($duoi!='jpg'&& $duoi!='png' && $duoi='jpeg'){
                   return redirect('admin/slide/them')->with('loi','bạn chỉ được thêm đuôi jpg, npg');
                }
   
                $name=$file->getClientOriginalName();
                $Hinh=str_random(4)."_".$name;
                while (file_exists("upload/slide/".$Hinh)) {
                   $Hinh=str_random(4)."_".$name;
                }
                $file->move("upload/slide",$Hinh);
                $slide->Hinh=$Hinh;
           } else {
              $slide->Hinh="";
           }
        }
        
        $slide->save();


        return redirect('admin/slide/them')->with('thongbao','them thành công');
    }





  public function getSua($id){
    $slide= Slide::find($id); // tìm thể loại có $id truyền vào
    // sau khi tìm xong thì truyền dữ liệu qua vieww để sửa
    return view('admin.slide.sua',['slide'=>$slide]);
  }

  public function postSua(Request $request,$id){  // id là cái truyền tham số trên url , còn $request là cái mình nhập vào form
    $this->validate($request, // bắt lỗi
    [
        'Ten'=>'required' ,  // biến Tên là truyền từ bên form sang
        'NoiDung'=>'required' ,
    ],
    [
        'Ten.required'=>'bạn chưa nhập ten',
        'NoiDung.required'=>'bạn chưa nhập nd',
        

    ]);
// sau khi bắt lỗi xong, thì mình lấy cái Ten nhập vào từ form, lưu vào model của mình
    $slide= Slide::find($id);
    $slide->Ten=$request->Ten;
    $slide->NoiDung=$request->NoiDung;

    if ($request->has('link')) {
        $slide->link= $request->link;
        if ($request->hasFile('Hinh')) {
            $file=$request->file('Hinh');

            $duoi=$file->getClientOriginalExtension();
            if($duoi!='jpg'&& $duoi!='png' && $duoi='jpeg'){
               return redirect('admin/slide/them')->with('loi','bạn chỉ được thêm đuôi jpg, npg');
            }

            $name=$file->getClientOriginalName();
            $Hinh=str_random(4)."_".$name;
            while (file_exists("upload/slide/".$Hinh)) {
               $Hinh=str_random(4)."_".$name;
            }
            unlink("upload/slide/".$slide->Hinh);
            $file->move("upload/slide",$Hinh);
            $slide->Hinh=$Hinh;
       }
    }
    
    $slide->save();


    return redirect('admin/slide/sua/'.$id)->with('thongbao','sua thành công');
  }


  public function getXoa($id){
    $slide= Slide::find($id); // tìm thể loại có $id truyền vào
    $slide->delete();
    

    return redirect('admin/slide/danhsach')->with('thongbao','xóa thành công');
  }
}
