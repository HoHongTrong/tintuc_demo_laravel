<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class UserController extends Controller {
  public function getList() {
    $user = User::all();
    return view('admin.user.list', ['user' => $user]);
  }

//-------------------Add-------------------------
  public function getAdd() {
    return view('admin.user.add');
  }

  public function postAdd(Request $request) {
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
    $user->quyen = $request->quyen;
    $user->save();
    return redirect('admin/user/add')->with('thongbao', 'thêm user thành công');
  }
  //------------------End Add----------------------------

  //-------------  Edit --------------------------
  public function getEdit($id) {
    $user = User::find($id);
    return view('admin.user.edit', ['user' => $user]);
  }

  public function postEdit(Request $request, $id) {
    $this->validate($request, [
      'name' => 'required|min:3',

    ],
      [
        'name.required' => 'Bạn chưa nhập tên',
        'name.min' => 'Tên người dùng có ít nhất 3 kí tự',

      ]);
    $user = User::find($id);
    $user->name = $request->name;
    $user->quyen = $request->quyen;

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
    return redirect('admin/user/edit/'.$id)->with('thongbao','bạn sữa thành công');

  }
  //------------------End Edit----------------

//------------Delete-------------------
  public function getDelete($id) {
    $user = User::find($id);
    $user->delete();
    return redirect('admin/user/list')->with('thongbao', 'xóa user thành công');
  }


  public function getloginAdmin(){
    return view('admin.login');
  }
  public function postloginAdmin(Request $request){
    $this->validate($request,[
      'email'=>'required',
      'password'=>'required|min:3|max:32'
    ],[
      'email.required'=>'Bạn chưa nhập email',
      'password.min'=>'Tên người dùng có ít nhất 3 kí tự',
      'password.max'=>'Tên người dùng có nhiều nhất 32 kí tự'
    ]);

    if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
    {
      return redirect('admin/theloai/list');
    }
    else{
      return redirect('admin/login')->with('thongbao','đăng nhập không thành công');
    }
  }
  public function getlogoutAdmin(){
    Auth::logout();
    return redirect('admin/login');
  }
}
