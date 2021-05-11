<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TheLoai;
use App\LoaiTin;

class AjaxController extends Controller
{
  /*lấy id từ route*/
    public function getAjaxLoaiTin($idTheLoai){
      $loaitin = LoaiTin::where('idTheLoai',$idTheLoai)->get();
      foreach ($loaitin as $lt){
        echo "<option value='".$lt->id."'>".$lt->Ten."</option>";
      }
    }
}
