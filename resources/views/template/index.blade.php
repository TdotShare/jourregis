<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Jourregis RMUTI</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{URL::asset("assets/logo/irdrmuti_thmb.gif")}}" type="image/gif" sizes="16x16">


  <!-- Font Awesome -->
  <link rel="stylesheet" href={{URL::asset("template/plugins/fontawesome-free/css/all.min.css")}}>
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href={{URL::asset("template/dist/css/adminlte.min.css")}}>
  <link rel="stylesheet" href={{URL::asset("css/custom.css")}}>

  <link href="https://fonts.googleapis.com/css2?family=Mitr:wght@200;300;400;500&display=swap" rel="stylesheet">

  <link rel="stylesheet" href={{URL::asset("template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css")}}>
  <link rel="stylesheet"
    href={{URL::asset("template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css")}}>

  @yield('script_header')

</head>

<body class="hold-transition sidebar-mini" style="font-family: 'Mitr', sans-serif;">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="{{route("home_index_page")}}" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">

          @if (session('auth') != null)
          <a href="{{route("logout_data")}}" class="nav-link">Logout</a>
          @else
          <a href="{{route("login_page")}}" class="nav-link">Login</a>
          @endif

        </li>
      </ul>


    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #300328;">
      <!-- Brand Logo -->

      <a href="#" class="brand-link">
        <img src="{{URL::asset("assets/logo/irdrmuti_cri.png")}}" alt="AdminLTE Logo"
          class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Jourregis RMUTI</span>
      </a>

      <!-- Sidebar -->
      @component('template.menu')

      @endcomponent
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          @yield('breadcrumb')
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Default box -->
          @yield('content')
        </div>

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0 - 06/2022
      </div>
      <strong>Copyright &copy; <a href="https://ird.rmuti.ac.th/main/"> สถาบันวิจัยและพัฒนา 2022  </a></strong>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src={{URL::asset("template/plugins/jquery/jquery.min.js")}}></script>
  <!-- Bootstrap 4 -->
  <script src={{URL::asset("template/plugins/bootstrap/js/bootstrap.bundle.min.js")}}></script>

  <!-- AdminLTE App -->
  <script src={{URL::asset("template/dist/js/adminlte.min.js")}}></script>


  <!-- DataTables -->
  <script src={{URL::asset("template/plugins/datatables/jquery.dataTables.min.js")}}></script>
  <script src={{URL::asset("template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js")}}></script>
  <script src={{URL::asset("template/plugins/datatables-responsive/js/dataTables.responsive.min.js")}}></script>
  <script src={{URL::asset("template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js")}}></script>

  @yield('script_footer')

  {{-- <script>
    // $(function () {
    //   $("#dataTable").DataTable({
    //     "responsive": true,
    //   });
    //   $('#example2').DataTable({
    //     "paging": true,
    //     "lengthChange": false,
    //     "searching": false,
    //     "ordering": true,
    //     "info": true,
    //     "autoWidth": false,
    //     "responsive": true,
    //   });
    // });
  </script> --}}
</body>

</html>