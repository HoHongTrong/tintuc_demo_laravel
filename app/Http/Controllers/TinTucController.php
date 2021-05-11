<?php

namespace App\Http\Controllers;

use App\LoaiTin;
use App\TheLoai;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\TinTuc;
use App\Comment;

class TinTucController extends Controller {

  public function getList() {
    $tintuc = TinTuc::orderBy('id', 'DESC')->get();//lấy ra id cuối cùng
    return view('admin.tintuc.list', ['tintuc' => $tintuc]);
  }

//-------------------Add-------------------------
  public function getAdd() {
    $theloai = TheLoai::all();
    $loaitin = LoaiTin::all();
    return view('admin.tintuc.add', [
      'theloai' => $theloai,
      'loaitin' => $loaitin
    ]);
  }

  public function postAdd(Request $request) {
    $this->validate($request,
      [
        'LoaiTin' => 'required',
        'TieuDe' => 'required|min:3|unique:TinTuc,TieuDe',/*unique:TinTuc,TieuDe tên bảng,trường*/
        'TomTat' =>'required',
        'NoiDung' =>'required',
      ],
      [
        'LoaiTin.required' => 'Bạn chưa nhập tên thể loại',
        'TieuDe.required' => 'Bạn chưa nhập tiêu đề',
        'TieuDe.min' => 'Độ dài ít nhất 3 ký tự',
        'TieuDe.unique' => 'Trùng tiêu đề',
        'TomTat.required' => 'Bạn chưa nhập tóm tắt',
        'NoiDung.required' => 'Bạn chưa nhập nội dung'
      ]);
    $tintuc = new TinTuc();
    $tintuc->TieuDe = $request->TieuDe;
    $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
    $tintuc->idLoaiTin = $request->LoaiTin;
    $tintuc->TomTat = $request->TomTat;
    $tintuc->NoiDung = $request->NoiDung;
    $tintuc->SoLuotXem = 0;
    if ($request->hasFile('Hinh')) {
      $file = $request->file('Hinh');
      $duoi = $file->getClientOriginalExtension();
      if ($duoi !='jpg' && $duoi !='png' )
      {
        return redirect('admin/tintuc/add')->with('thongbao', 'ban chỉ được nhập jpg,png');
      }
      $name = $file->getClientOriginalName();
      $Hinh = str_random(4) . "_" . $name;
      while (file_exists("upload/tintuc/" . $Hinh)) {
        $Hinh = str_random(4) . "_" . $name;
      }
      $file->move("upload/tintuc", $Hinh);
      $tintuc->Hinh = $Hinh;
    }
    else {
      $tintuc->Hinh = "";
    }
    $tintuc->save();

    return redirect('admin/tintuc/add')->with('thongbao', 'thêm tin tuc thành công');
  }
  //------------------End Add-------------

  //-------------Edit-------------------------------------
  public function getEdit($id) {
    $theloai = TheLoai::all();
    $loaitin = LoaiTin::all();
    $tintuc = TinTuc::find($id);
    Return view('admin.tintuc.edit', ['tintuc' => $tintuc,'theloai'=>$theloai,'loaitin'=>$loaitin]);
  }

  public function postEdit(Request $request, $id) {
    $tintuc = TinTuc::find($id);
    $this->validate($request,
      [
        'LoaiTin' => 'required',
        'TieuDe' => 'required|min:3|unique:TinTuc,TieuDe',/*unique:TinTuc,TieuDe tên bảng,trường*/
        'TomTat' =>'required',
        'NoiDung' =>'required',
      ],
      [
        'LoaiTin.required' => 'Bạn chưa chọn loại tin',
        'TieuDe.required' => 'Bạn chưa nhập tiêu đề',
        'TieuDe.min' => 'Độ dài ít nhất 3 ký tự',
        'TieuDe.unique' => 'Trùng tiêu đề',
        'TomTat.required' => 'Bạn chưa nhập tóm tắt',
        'NoiDung.required' => 'Bạn chưa nhập nội dung'
      ]);
    $tintuc->TieuDe = $request->TieuDe;
    $tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
    $tintuc->idLoaiTin = $request->LoaiTin;
    $tintuc->TomTat = $request->TomTat;
    $tintuc->NoiDung = $request->NoiDung;
    if ($request->hasFile('Hinh')) {
      $file = $request->file('Hinh');
      $duoi = $file->getClientOriginalExtension();
      if ($duoi !='jpg' && $duoi !='png' )
      {
        return redirect('admin/tintuc/add')->with('thongbao', 'ban chỉ được nhập jpg,png');
      }
      $name = $file->getClientOriginalName();
      $Hinh = str_random(4) . "_" . $name;
      while (file_exists("upload/tintuc/" . $Hinh)) {
        $Hinh = str_random(4) . "_" . $name;
      }
      $file->move("upload/tintuc", $Hinh);
      @unlink('upload/tintuc/'.$tintuc->Hinh);
      $tintuc->Hinh = $Hinh;
    }
    $tintuc->save();
    return redirect('admin/tintuc/edit/'.$id)->with('thongbao', 'sữa thành công');
  }
  //------------------End Edit----------------

//------------Delete-------------------
  public function getDelete($id) {
    $tintuc = TinTuc::find($id);
    $tintuc->delete();
    return redirect('admin/tintuc/list')->with('thongbao', 'xóa thành công');
  }
}
