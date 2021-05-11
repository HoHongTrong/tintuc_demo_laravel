@extends('admin.layout.index')
@section('content')

  <!-- Page Content -->
  <div id="page-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">Tin Tức
            <small>List</small>
          </h1>
        </div>
        <!-- /.col-lg-12 -->
        @if(session('thongbao'))
          <div class="alert alert-success">
            {{session('thongbao')}}
          </div>
        @endif
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
          <thead>
          <tr align="center">
            <th>ID</th>
            <th>Tiêu Đề</th>
            <th>Tóm Tắt</th>
            <th>Thể Loại</th>
            <th>Loại Tin</th>
            <th>Xem</th>
            <th>Nổi Bật</th>
            <th>Delete</th>
            <th>Edit</th>
          </tr>
          </thead>
          <tbody>
          @foreach($tintuc as $tt)
            <tr class="odd gradeX" align="center">
              <td>{{$tt->id}}</td>
              <td>
                <p>{{$tt->TieuDe}}</p>
                <img width="100px" height="100px" src="upload/tintuc/{{$tt->Hinh}}"/>
              </td>
              <td>{{$tt->TomTat}}</td>
              <td>{{$tt->loaitin->theloai->Ten}}</td>
              <td>{{$tt->loaitin->Ten}}</td>
              <td>{{$tt->SoLuotXem}}</td>
              <td>
                @if($tt->NoiBat == 0)
                  {{'không'}}
                @else
                  {{'có'}}
                @endif
              </td>

              <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/tintuc/delete/{{$tt->id}}">
                  Delete</a></td>
              <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/tintuc/edit/{{$tt->id}}">Edit</a>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /#page-wrapper -->

@endsection