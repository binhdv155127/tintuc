@extends('admin.layout.index')

@section('content')
    <!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">tin tức
                    <small>thêm</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
                    @if (count($errors)>0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $err)
                            {{$err}} <br>
                        @endforeach

                    </div>
                @endif

                @if (session('thongbao'))
                    <div class="alert alert-success">
                            {{session('thongbao')}}
                    </div>
                @endif
                <form action="admin/tintuc/them" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    <div class="form-group">
                        <label>Thể loại</label>
                        <select class="form-control" name="TheLoai" id="TheLoai">
                           @foreach ($theloai as $tl)
                        <option value="{{$tl->id}}">{{$tl->Ten}}</option>
                           @endforeach
                            
                        </select>
                    </div>
                    <div class="form-group">
                            <label>Loại tin</label>
                            <select class="form-control" name="LoaiTin" id="LoaiTin">
                                    @foreach ($loaitin as $lt)
                                 <option value="{{$lt->id}}">{{$lt->Ten}}</option>
                                    @endforeach
                            </select>
                    </div>
                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <input class="form-control" name="TieuDe" placeholder="nhập tiêu đê" />
                    </div>
                    
                    <div class="form-group">
                        <label>Tóm tắt</label>
                        <textarea id="demo" name="TomTat" class="form-control ckeditor" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Nội dung</label>
                        <textarea id="demo" name="NoiDung" class="form-control ckeditor" rows="5"></textarea>
                    </div>


                    <div class="form-group">
                        <label>hình ảnh</label>
                        <input type="file" name="Hinh"  class="form-control">
                    </div>



                    <div class="form-group">
                        <label>Nổi Bật</label>
                        <label class="radio-inline">
                            <input name="NoiBat" value="0" checked="" type="radio">không
                        </label>
                        <label class="radio-inline">
                            <input name="NoiBat" value="1" type="radio">có
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Thêm</button>
                    <button type="reset" class="btn btn-default">làm mới</button>
                <form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection


{{-- nhớ bên index phải có @yield rồi nhé --}}
@section('script')
    <script>
         $(document).ready(function(){
             $("#TheLoai").change(function(){ // sự kiện khi nhấn chọn thay đổi
                 var idTheLoai = $(this).val();// lấy id thể loại chính nó
                 $.get("admin/ajax/loaitin/"+idTheLoai,function(data){ //tạo 1 phương thức ajax và truyền theo pt get
                 // chỗ +idTheLoai là nối thêm id vào
                 //admin/ajax/loaitin/"+idTheLoai đường link khai báo trong route
                
                     $("#LoaiTin").html(data);
                 });
             });
         });
    </script>
@endsection