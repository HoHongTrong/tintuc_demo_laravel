<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Comment;
use App\TinTuc;
class CommentController extends Controller
{
    public function getDelete($id,$idtintuc){
      $comment = Comment::find($id);
      $comment->delete();
      return redirect('admin/tintuc/edit/'.$idtintuc)->with('thongbao','xóa comment thành công');
    }

    public function postComment($id, Request $request){
      $idTinTuc = $id;
      $tintuc = TinTuc::find($id);
      $comment = new Comment();
      $comment->idTinTuc = $idTinTuc;
      $comment->idUser = Auth::user()->id;
      $comment->NoiDung = $request->NoiDung;
      $comment->save();
      return redirect("tintuc/{id}/".$tintuc->TieuDeKhongDau.".html")->with('thongbao','viết bình luận thành công');
    }
}
