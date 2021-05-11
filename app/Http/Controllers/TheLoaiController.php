<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\TheLoai;
use PhpParser\Node\Stmt\Return_;

class TheLoaiController extends Controller
{

  public function getList()
  {
    $theloai = TheLoai::all();
    return view('admin.theloai.list', ['theloai' => $theloai]);
  }

//-------------------Add-------------------------
  public function getAdd()
  {
    return view('admin.theloai.add');
  }

  public function postAdd(Request $request)
  {
    $this->validate($request,
      ['Ten' => 'required|min:3|max:100'],
      [
        'Ten.required' => 'Bạn chưa nhập tên thể loại',
        'Ten.min' => 'Độ dài ít nhất 3 ký tự',
        'Ten.max' => 'Độ dài lớn nhất 100 ký tự'
      ]);
    $theloai = new TheLoai();
    $theloai->Ten = $request->Ten;
    $theloai->TenKhongDau = changeTitle($request->Ten);
    $theloai->save();
    return redirect('admin/theloai/add')->with('thongbao', 'thêm thành công');
  }
  //------------------End Add-------------

  //-------------Edit-------------------------------------
  public function getEdit($id)
  {
    $theloai = TheLoai::find($id);
    Return view('admin.theloai.edit',['theloai' => $theloai]);
  }
  public function postEdit(Request $request,$id)
  {
    $theloai = TheLoai::find($id);
    $this->validate($request,
      [
        'Ten'=>'required|unique:TheLoai,Ten|min:3|max:100'],
      [
        'Ten.required' => 'Bạn chưa nhập tên thể loại',
        'Ten.unique'=>'Tên đã tồn tại',
        'Ten.min' => 'Độ dài ít nhất 3 ký tự',
        'Ten.max' => 'Độ dài lớn nhất 100 ký tự'
      ]);
    // tiến hành sữa
    $theloai->Ten = $request->Ten;
    $theloai->TenKhongDau = changeTitle($request->Ten);
    $theloai->save();
    return redirect('admin/theloai/edit/'.$id)->with('thongbao','sữa thành công');
  }
  //------------------End Edit----------------

//------------Delete-------------------
  public function getDelete($id){
    $theloai = TheLoai::find($id);
    $theloai->delete();
    return redirect('admin/theloai/list')->with('thongbao','xóa thành công');
  }
}
