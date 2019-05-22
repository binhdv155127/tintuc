<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;  // đùng để đăng nhập
use App\Comment;
use App\User;

class UserController extends Controller
{
    public function getDanhSach(){
        // muốn dùng model the loại thì phải use nó

        $user=User::all(); // câu truy vấn lấy ra csdl thể loại trong mysql 
         // sau khi lấy xong danh sách thể loại thì ta cần truyền sang bên view
          return view('admin.user.danhsach',['user'=>$user]); // thể loại đầu là mình tự đặt còn $ biến là bên trên
          // truyền tham số sang bên vieew có thể dùng compact
    }


    public function getThem(){
        return view('admin.user.them');
    }

    public function postThem(Request $request){
        $this->validate($request, // bắt lỗi
        [
            'name'=>'required|min:3' ,  // biến Tên là truyền từ bên form sang
            'email'=>'required|email|unique:users,email' , // không được trùng trong bảng users, email trong csdl
            'password'=>'required|min:3|max:32' ,
            'passwordAgain'=>'required|same:password' ,
        ],
        [
            'name.required'=>'bạn chưa nhập tên',
            'name.min'=>'tên phài dài từ 3 đến 32 kí tự',
            
            'email.required'=>'bạn chưa nhập email',
            'email.email'=>'bạn chưa nhập đúng định dạng email',
            'email.unique'=>'email đã tồn tại',
            'password.required'=>'bạn chưa nhập pass',
            'password.min'=>'mk phài dài từ 3 đến 32 kí tự',
            'password.max'=>'mk phài tối đa 32 kí tự',
            'passwordAgain.required'=>'bạn chư nhập lại mk',
            'passwordAgain.same'=>'mk nhập lại chưa khớp',
            
            
            
            

        ]);
// sau khi bắt lỗi xong, thì mình lấy cái Ten nhập vào từ form, lưu vào model của mình
        $user= new User;
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password= bcrypt($request->password);
        $user->quyen=$request->quyen;
        
        $user->save();


        return redirect('admin/user/them')->with('thongbao','them thành công');
    }





  public function getSua($id){
    $user= User::find($id); // tìm thể loại có $id truyền vào
    // sau khi tìm xong thì truyền dữ liệu qua vieww để sửa
    return view('admin.user.sua',['user'=>$user]);
  }

  public function postSua(Request $request,$id){  // id là cái truyền tham số trên url , còn $request là cái mình nhập vào form
    $user= User::find($id); // tìm thể loại có $id truyền vào

    $this->validate($request, // bắt lỗi
        [
            'name'=>'required|min:3' ,  // biến Tên là truyền từ bên form sang

        ],
        [
            'name.required'=>'bạn chưa nhập tên',
            'name.min'=>'tên phài dài từ 3 đến 32 kí tự',
            
            
            
            

        ]);
// sau khi bắt lỗi xong, thì mình lấy cái Ten nhập vào từ form, lưu vào model của mình
        $user= User::find($id); // tìm thể loại có $id truyền vào
        $user->name=$request->name;
        $user->quyen=$request->quyen;
        



        if($request->changePassword=="on"){ // kiểm tra xem checked box bên sửa có nhấn vòa không, nếu nhấn thì mới thực hiện
            $this->validate($request, // bắt lỗi
            [
                
                'password'=>'required|min:3|max:32' ,
                'passwordAgain'=>'required|same:password' ,
            ],
            [
                
                'password.required'=>'bạn chưa nhập pass',
                'password.min'=>'mk phài dài từ 3 đến 32 kí tự',
                'password.max'=>'mk phài tối đa 32 kí tự',
                'passwordAgain.required'=>'bạn chư nhập lại mk',
                'passwordAgain.same'=>'mk nhập lại chưa khớp',
                
                
            ]); 
            $user->password= bcrypt($request->password);
        }


       
        $user->save();


        return redirect('admin/user/sua/'.$id)->with('thongbao','sửa thành công');
  }


  public function getXoa($id){
    {
        $user = User::find($id);
        $comment = Comment::where('idUser',$id); //Tìm các comment của user
        $comment->delete(); //Xóa các comment của user
        $user->delete(); //Xóa user
        return redirect('admin/user/danhsach')->with('thongbao','Xóa tài khoản thành công');
      }
  }



  // ddawng nhaapj


  public function getdangnhapAdmin(){
    return view('admin.login');
  }
  public function postdangnhapAdmin(Request $request){
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
        return redirect('admin/theloai/danhsach');
    }else{
        return redirect('admin/dangnhap')->with('thongbao','dang nhập ko thành công');
    }
  }
  public function getDangXuatAdmin(){
      Auth::logout();
      return redirect('admin/dangnhap');
  }
}
