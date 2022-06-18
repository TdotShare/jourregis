<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>InstIRD RMUTI</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{URL::asset("assets/logo/irdrmuti_thmb.gif")}}" type="image/gif" sizes="16x16">
  <!-- Font Awesome -->
  <link rel="stylesheet" href={{URL::asset("template/plugins/fontawesome-free/css/all.min.css")}}>
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href={{URL::asset("template/plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}>
  <!-- Theme style -->
  <link rel="stylesheet" href={{URL::asset("template/dist/css/adminlte.min.css")}}>

  <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500&display=swap" rel="stylesheet">
</head>

<body class="hold-transition login-page" style="font-family: 'Mitr', sans-serif;">
  <div class="login-box"  style="width: 50%;">
    <div class="login-logo">
     <b>ระบบการลงทะเบียนเข้าร่วม่โครงการอบรมเชิงปฏิบัติการการเขียนบทความวิจัยเพื่อตีพิมพ์ลงในวารสารวิชาการระดับนานาชาติ : ด้านวิศวกรรมศาสตร์และเทคโนโลยี</b>

     <hr>
     <span>ระหว่างวันที่ 2-5 สิงหาคม 2565
      ณ อำเภอปากช่อง จังหวัดนครราชสีมา
      </span>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <a href="{{route('home_index_page')}}" ><p class="login-box-msg">กลับหน้าหลัก</p></a>

        @if (session('alert'))


        <div class="alert alert-{{session('status')}} alert-dismissible fade show" role="alert">
          {{ session('message') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        @endif

        <a href="{{route("login_rmuti_page")}}"><button  class="btn btn-warning btn-block"> <i class="fas fa-university"></i> Login With RMUTI</button></a>

      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src={{URL::asset("template/plugins/jquery/jquery.min.js")}}></script>
  <!-- Bootstrap 4 -->
  <script src={{URL::asset("template/plugins/bootstrap/js/bootstrap.bundle.min.js")}}></script>
  <!-- AdminLTE App -->
  <script src={{URL::asset("template/dist/js/adminlte.min.js")}}></script>

</body>

</html>