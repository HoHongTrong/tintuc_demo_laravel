@extends('admin.layout.index')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">Slide
          <small>Thêm</small>
        </h1>
      </div>
      <!-- /.col-lg-12 -->
      <div class="col-lg-7" style="padding-bottom:120px">

        @if(count($errors)>0)
          <div class="alert alert-danger">
            @foreach($errors->all() as $err)
              {{$err}}<br/>
            @endforeach
          </div>
        @endif

        @if(session('thongbao'))
          <div class="alert alert-success">
            {{session('thongbao')}}
          </div>
        @endif

        {{-- enctype="multipart/form-data" dùng để upload hình lên --}}
        <form action="admin/slide/add" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{csrf_token()}}"/>
          <div class="form-group">
            <label>Tên:</label>
            <input class="form-control" name="Ten" placeholder="Nhập tên slide"/>
          </div>
          <div class="form-group">
            <label>Nội Dung</label>
            <textarea id="demo" name="NoiDung" class="form-control ckeditor" rows="2"></textarea>
          </div>
          <div class="form-group">
            <label>Link:</label>
            <input class="form-control" name="link" placeholder="Nhập link"/>
          </div>
          <div class="form-group">
            <label>Hình Ảnh</label>
            <input type="file" name="Hinh"/>
          </div>

          <button type="submit" class="btn btn-default">Add</button>
          <button type="reset" class="btn btn-default">Reset</button>
        </form>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

  @endsection