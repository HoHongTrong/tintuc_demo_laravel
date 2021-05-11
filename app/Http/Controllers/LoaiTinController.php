<?php

namespace App\Http\Controllers;

use App\LoaiTin;
use Illuminate\Http\Request;
use App\TheLoai;

use App\Http\Requests;

class LoaiTinController extends Controller {
  public function getList() {
    $loaitin = LoaiTin::all();
    return view('admin.loaitin.list', ['loaitin' => $loaitin]);
  }
//-------------------Add-------------------------
  public function getAdd() {
    $theloai = TheLoai::all();
    return view('admin.loaitin.add', ['theloai' => $theloai]);
  }

  public function postAdd(Request $request) {
    $this->validate($request,
      [
        'Ten'=>'required|unique:TheLoai,Ten|min:3|max:100'],
      [
        'Ten.required' => 'Bạn chưa tên loại tin',
        'Ten.unique'=>'Tên đã tồn tại',
        'Ten.min' => 'Độ dài ít nhất 3 ký tự',
        'Ten.max' => 'Độ dài lớn nhất 100 ký tự'
      ]);

    $loaitin = new LoaiTin;
    $loaitin->Ten = $request->Ten;
    $loaitin->TenKhongDau = changeTitle($request->Ten);
    $loaitin->idTheLoai = $request->TheLoai;
    $loaitin->save();
    return redirect('admin/loaitin/add')->with('thongbao','Thêm thành công');
  }
//---------------End Add----------------------------

//-------------Edit-------------------------------------
  public function getEdit($id) {
    $theloai = TheLoai::all();
    $loaitin = LoaiTin::find($id);
    Return view('admin.loaitin.edit', ['loaitin' => $loaitin,'theloai'=>$theloai]);
  }

  public function postEdit(Request $request, $id) {
    $this->validate($request,
      [
        'Ten' => 'required|unique:LoaiTin,Ten|min:3|max:100'
      ],
      [
        'Ten.required' => 'Bạn chưa nhập tên thể loại',
        'Ten.unique' => 'Tên đã tồn tại',
        'Ten.min' => 'Độ dài ít nhất 3 ký tự',
        'Ten.max' => 'Độ dài lớn nhất 100 ký tự'
      ]);
    $loaitin = LoaiTin::find($id);
    $loaitin->Ten = $request->Ten;
    $loaitin->TenKhongDau = changeTitle($request->Ten);
    $loaitin->idTheLoai = $request->TheLoai;
    $loaitin->save();
    return redirect('admin/loaitin/edit/' . $id)->with('thongbao', 'sữa thành công');
  }
  //------------------End Edit----------------


//------------Delete-------------------
  public function getDelete($id) {
    $loaitin = LoaiTin::find($id);
    $loaitin->delete();
    return redirect('admin/loaitin/list')->with('thongbao', 'xóa thành công');
  }
}
