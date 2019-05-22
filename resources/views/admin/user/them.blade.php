@extends('admin.layout.index')

@section('content')
    <!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User
                    <small>Thêm</small>
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
 
                <form action="admin/user/them" method="POST">
                        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                    <div class="form-group">
                        <label>Họ tên</label>
                        <input class="form-control" name="name" placeholder="nhập tên" />
                    </div>
                    <div class="form-group">
                        <label>email</label>
                        <input type="EMAIL" class="form-control" name="email" placeholder="nhập mail" />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" placeholder="nhập pass" />
                    </div>
                    <div class="form-group">
                            <label>nhập lại Password</label>
                            <input type="password" class="form-control" name="passwordAgain" placeholder="nhập lại pass" />
                        </div>
                   
                    <div class="form-group">
                        <label>quyền user</label>
                        <label class="radio-inline">
                            <input name="quyen" value="0" checked="" type="radio">thường
                        </label>
                        <label class="radio-inline">
                            <input name="quyen" value="1" type="radio">admin
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">thêm</button>
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
