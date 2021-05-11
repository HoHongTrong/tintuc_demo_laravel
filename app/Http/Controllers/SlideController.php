<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Slide;

class SlideController extends Controller {
  public function getList() {
    $slide = Slide::all();
    return view('admin.slide.list', ['slide' => $slide]);
  }

//-------------------Add-------------------------
  public function getAdd() {

    return view('admin.slide.add');
  }

  public function postAdd(Request $request) {
    $this->validate($request, [
      'Ten' => 'required',
      'NoiDung' => 'required'
    ],
      [
        'Ten.required' => 'Nhập tên slide',
        'NoiDung.required' => 'Nhập nội dung',
      ]);
    $slide = new Slide();
    $slide->Ten = $request->Ten;
    $slide->NoiDung = $request->NoiDung;
    if ($request->has('link')) {
      $slide->link = $request->link;
    }
    if ($request->hasFile('Hinh')) {
      $file = $request->file('Hinh');
      $duoi = $file->getClientOriginalExtension();
      if ($duoi != 'jpg' && $duoi != 'png') {
        return redirect('admin/slide/add')->with('thongbao', 'ban chỉ được nhập jpg,png');
      }
      $name = $file->getClientOriginalName();
      $Hinh = str_random(4) . "_" . $name;
      while (file_exists("upload/slide/" . $Hinh)) {
        $Hinh = str_random(4) . "_" . $name;
      }
      $file->move("upload/slide", $Hinh);
      $slide->Hinh = $Hinh;
    }
    else {
      $slide->Hinh = "";
    }
    $slide->save();
    return redirect('admin/slide/add')->with('thongbao', 'Thêm slide thành công');

  }
  //------------------End Add-------------

  //-------------  Edit --------------------------
  public function getEdit($id) {
    $slide = Slide::find($id);
    return view('admin.slide.edit', ['slide' => $slide]);

  }

  public function postEdit(Request $request, $id) {
    $this->validate($request, [
      'Ten' => 'required',
      'NoiDung' => 'required'
    ],
      [
        'Ten.required' => 'Nhập tên slide',
        'NoiDung.required' => 'Nhập nội dung',
      ]);
    $slide = Slide::find($id);
    $slide->Ten = $request->Ten;
    $slide->NoiDung = $request->NoiDung;
    if ($request->has('link')) {
      $slide->link = $request->link;
    }
    if ($request->hasFile('Hinh')) {
      $file = $request->file('Hinh');
      $duoi = $file->getClientOriginalExtension();
      if ($duoi != 'jpg' && $duoi != 'png') {
        return redirect('admin/slide/add')->with('thongbao', 'ban chỉ được nhập jpg,png');
      }
      $name = $file->getClientOriginalName();
      $Hinh = str_random(4) . "_" . $name;
      while (file_exists("upload/slide/" . $Hinh)) {
        $Hinh = str_random(4) . "_" . $name;
      }
      $file->move("upload/slide", $Hinh);
      unlink('upload/slide/'.$slide->Hinh);
      $slide->Hinh = $Hinh;
    }
    $slide->save();
    return redirect('admin/slide/edit/'.$id)->with('thongbao', 'Sữa slide thành công');

  }
  //------------------End Edit----------------

//------------Delete-------------------
  public function getDelete($id) {
    $slide = Slide::find($id);
    $slide->delete();
    return redirect('admin/slide/list')->with('thongbao', 'xóa slide thành công');
  }
}
