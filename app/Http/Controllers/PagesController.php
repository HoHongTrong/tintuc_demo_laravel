<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TheLoai;
use App\Slide;
use App\LoaiTin;
use App\TinTuc;
use App\User;

class PagesController extends Controller {
  // tất cả các function sẽ nhận biến trong construct
  function __construct() {
    $theloai = TheLoai::all();
    $slide = Slide::all();
    view()->share('theloai', $theloai);
    view()->share('slide', $slide);

    if (Auth::check()) {
      view()->share('nguoidung', Auth::user());
    }
  }

  public function trangchu() {
    return view('pages.trangchu');
  }

  public function lienhe() {
    return view('pages.lienhe');
  }

  public function loaitin($id) {
    $loaitin = LoaiTin::find($id);
    $tintuc = TinTuc::where('idLoaiTin', $id)->paginate(5);
    return view('pages.loaitin', ['loaitin' => $loaitin, 'tintuc' => $tintuc]);
  }

  public function tintuc($id) {
    $tintuc = TinTuc::find($id);
    $tinnoibat = TinTuc::where('NoiBat', 1)
      ->take(4)
      ->get();
    $tinlienquan = TinTuc::where('idLoaiTin', $tintuc->idLoaiTin)
      ->take(4)
      ->get();

    return view('pages.tintuc',
      [
        'tintuc' => $tintuc,
        'tinnoibat' => $tinnoibat,
        'tinlienquan' => $tinlienquan
      ]);
  }

  public function getdangnhap() {
    return view('pages.dangnhap');
  }

  public function postdangnhap(Request $request) {
    $this->validate($request, [
      'email' => 'required',
      'password' => 'required|min:3|max:32'
    ], [
      'email.required' => 'Bạn chưa nhập email',
      'password.min' => 'Tên người dùng có ít nhất 3 kí tự',
      'password.max' => 'Tên người dùng có nhiều nhất 32 kí tự'
    ]);

    if (Auth::attempt([
      'email' => $request->email,
      'password' => $request->password
    ])
    ) {
      return redirect('trangchu');
    }
    else {
      return redirect('dangnhap')->with('thongbao', 'đăng nhập không thành công');
    }
  }

  public function postdangxuat() {
    Auth::logout();
    return redirect('trangchu');
  }

  public function getNguoiDung() {
    return view('pages.nguoidung');
  }

  public function postNguoiDung(Request $request) {
    $this->validate($request, [
      'name' => 'required|min:3',

    ],
      [
        'name.required' => 'Bạn chưa nhập tên',
        'name.min' => 'Tên người dùng có ít nhất 3 kí tự',

      ]);
    $user = Auth::user();
    $user->name = $request->name;

    if ($request->changePassword == "on") {
      $this->validate($request, [
        'password' => 'required|min:3|max:32',
        'passwordAgain' => 'required|same:password'
      ],
        [
          'password.required' => 'Bạn chưa nhập password',
          'password.min' => 'Tên người dùng có ít nhất 3 kí tự',
          'password.max' => 'Tên người dùng có nhiều nhất 32 kí tự',
          'passwordAgain.required' => 'Bạn chưa nhập lại password',
          'passwordAgain.same' => 'password chưa đúng'
        ]);
      $user->password = bcrypt($request->password);
    }
    $user->save();
    return redirect('nguoidung')->with('thongbao', 'bạn sữa thành công');
  }


  public function getdangky() {
    return view('pages.dangky');
  }

  public function postdangky(Request $request) {
    $this->validate($request, [
      'name' => 'required|min:3',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:3|max:32',
      'passwordAgain' => 'required|same:password'
    ],
      [
        'name.required' => 'Bạn chưa nhập tên',
        'name.min' => 'Tên người dùng có ít nhất 3 kí tự',
        'email.required' => 'Bạn chưa nhập email',
        'email.email' => 'Bạn chưa nhập đúng định dạng email',
        'email.unique' => 'Email đã tồn tại',
        'password.required' => 'Bạn chưa nhập password',
        'password.min' => 'Tên người dùng có ít nhất 3 kí tự',
        'password.max' => 'Tên người dùng có nhiều nhất 32 kí tự',
        'passwordAgain.required' => 'Bạn chưa nhập lại password',
        'passwordAgain.same' => 'password chưa đúng'
      ]);
    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->quyen = 0;
    $user->save();
    return redirect('dangky')->with('thongbao', 'chúc mừng bạn đăng kí thành công');
  }

}
