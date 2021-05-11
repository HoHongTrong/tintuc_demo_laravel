@extends('layout.index')
@section('content')

  <!-- Page Content -->
  <div class="container">

    @include('layout.slide')

    <div class="space20"></div>


    <div class="row main-left">
      @include('layout.menu')

      <div class="col-md-9">
        <div class="panel panel-default">
          <div class="panel-heading" style="background-color:#337AB7; color:white;" >
            <h2 style="margin-top:0px; margin-bottom:0px;">Liên hệ</h2>
          </div>

          <div class="panel-body">
            <!-- item -->
            <h3><span class="glyphicon glyphicon-align-left"></span> Thông tin liên hệ</h3>

            <div class="break"></div>
            <h4><span class= "glyphicon glyphicon-home "></span> Địa chỉ : </h4>
            <p> HCM </p>

            <h4><span class="glyphicon glyphicon-envelope"></span> Email : </h4>
            <p>hohongtrong@gmail.com </p>

            <h4><span class="glyphicon glyphicon-phone-alt"></span> Điện thoại : </h4>
            <p> 01262640099</p>



            <br><br>
            <h3><span class="glyphicon glyphicon-globe"></span> Bản đồ</h3>
            <div class="break"></div><br>
            <iframe src="https://www.google.com/maps/place/26+%C4%90%C6%B0%E1%BB%9Dng+D5,+Ph%C6%B0%E1%BB%9Dng+25,+B%C3%ACnh+Th%E1%BA%A1nh,+H%E1%BB%93+Ch%C3%AD+Minh,+Vi%E1%BB%87t+Nam/@10.8053812,106.7045851,15z/data=!4m5!3m4!1s0x317528a33a7008b1:0x29600139298229dc!8m2!3d10.8066983!4d106.7123199" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>

          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div>
  <!-- end Page Content -->

  @endsection