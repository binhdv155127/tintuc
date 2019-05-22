@extends('admin.layout.index')

@section('content')
    <!-- Page Content -->
    <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">slide
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
                        <form action="admin/slide/them" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                            
                           
                            <div class="form-group">
                                <label>tên</label>
                                <input class="form-control" name="Ten" placeholder="nhập tên slide" />
                            </div>
                            
                            <div class="form-group">
                                <label>nội dung</label>
                                <textarea id="demo" name="NoiDung" class="form-control ckeditor" rows="3"></textarea>
                            </div>
                            
        
                            <div class="form-group">
                                    <label>link</label>
                                    <input class="form-control" name="link" placeholder="nhập tên link" />
                                </div>
        
                            <div class="form-group">
                                <label>hình ảnh</label>
                                <input type="file" name="Hinh"  class="form-control">
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
<!-- /#page-wrapper -->
@endsection
