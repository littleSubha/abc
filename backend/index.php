<?php
    header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Referrer-Policy: origin-when-cross-origin");
    header('X-Frame-Options: SAMEORIGIN');
    header("X-Frame-Options: DENY");
    header("X-Frame-Options: ALLOW-FROM http://localhost");
    header('X-Content-Type-Options: nosniff');
    header("Content-Security-Policy: frame-ancestors 'none'", false);
    header('X-Webkit-CSP: default-src \'self\'');
    header("Strict-Transport-Security: max-age=31415926");
    header("X-XSS-Protection: 0");
    header('X-Powered-By:');

    $this->login_id=$this->session->userdata('user_id');
    $this->login_name=$this->session->userdata('USM_USNM');
    $this->user_id=$this->session->userdata('USM_USID');
    $this->menu_id=$this->session->userdata('MNM_FRNM');
    $this->system_name=gethostname();
    $this->load->model('MenuModel','menu',true); 
     
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin|<?= $title;?></title>
        <link rel="shortcut icon" href="<?= base_url('assets/images/');?>faveicon.png" type="image/x-icon">
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= base_url('assets/admin');?>/plugins/fontawesome-free/css/all.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="<?= base_url('assets/admin');?>/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">



        <!-- Select2 -->
        <link rel="stylesheet" href="<?= base_url('assets/admin');?>/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/admin');?>/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <!-- Bootstrap4 Duallistbox -->
        <link rel="stylesheet" href="<?= base_url('assets/admin');?>/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
        <!-- BS Stepper -->
        <link rel="stylesheet" href="<?= base_url('assets/admin');?>/plugins/bs-stepper/css/bs-stepper.min.css">
        <!-- dropzone CSS -->
        <!-- <link rel="stylesheet" href="<?= base_url('assets/admin');?>/plugins/dropzone/min/dropzone.min.css"> -->




         <!-- DataTables -->
        
        <link rel="stylesheet" href="<?= base_url('assets/admin');?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/admin');?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/admin');?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
       

         <!-- summer note -->
     
   

        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url('assets/admin');?>/dist/css/adminlte.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/admin');?>/plugins/summernote/summernote-bs4.min.css">
        <link rel="stylesheet" href="<?= base_url('assets/admin');?>/my-style.css">
        <?php if($page_name == 'dashboard'){ ?> 
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <?php } ?>
        <!-- Jquery Js -->
        <script src="<?= base_url('assets/admin');?>/plugins/jquery/jquery.min.js"></script>
        <script src="<?= base_url('assets');?>/js/sweetalert2@11.js"></script>
        <script src="<?= base_url('assets');?>/js/my_js.js"></script>
        <script src="<?= base_url('assets');?>/js/validator.min.js"></script>

    </head>
    <body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
    <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <?php include 'includes/top_nav.php'; ?>
        </nav>
    <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url('dashboard');?>" class="brand-link">
                <img src="<?= base_url('assets/admin/');?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">User Information</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url('assets/admin/');?>dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Alexander Pierce</a>
                        <a href="#" class="d-block">Admin</a>
                    </div>
                    
                </div>

                <!-- SidebarSearch Form -->
                <!-- <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                    </div>
                </div> -->
       
                <!-- Sidebar Menu -->
                <?php include 'includes/menu.php'; ?>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header card-bg  elevation-4">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                       
                            <h1> <i class="fas fa-file-alt fa-lg mr-3"></i> <?= $title;?></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url('dashboard');?>">Home</a></li>
                                <li class="breadcrumb-item active"><?= $title;?></li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            
            <?php include $page_name.".php"; ?>

            <!-- /.content -->
        </div>
    <!-- /.content-wrapper -->
        <?php
            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $actual_url=get_main_url($actual_link);

            $msg = $this->session->flashdata('msg'); 
            $error = $this->session->flashdata('error'); 

            if(isset($error)){
                echo "<script> Swal.fire('Error!', '". $error."', 'error');</script>";
                //  echo "<script>setTimeout(() => {
                //     window.location.href='".$actual_url."';
                // }, 2000);</script>";
            }
            if(isset($msg)){ 
                echo "<script> Swal.fire('Success!', '".$msg."', 'success');</script>";
                // echo "<script>setTimeout(() => {
                //     window.location.href='".$actual_url."';
                // }, 2000);</script>";
            }
            
            

            function get_main_url($string){
                $pos = strpos($string, '?');
                return substr($string,0,$pos);
            }
        ?>
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.1.0
            </div>
            <strong>Copyright &copy; 2019-<?= date('Y');?> <!-- <a href="https://adminlte.io">AdminLTE.io</a>-->.</strong> All rights reserved. 
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <!-- <script src="<?= base_url('assets/admin');?>/plugins/jquery/jquery.min.js"></script> -->
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/admin');?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>


    <!-- Select2 -->
    <script src="<?= base_url('assets/admin');?>/plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="<?= base_url('assets/admin');?>/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- BS-Stepper -->
    <script src="<?= base_url('assets/admin');?>/plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <!-- <script src="<?= base_url('assets/admin');?>/plugins/dropzone/min/dropzone.min.js"></script> -->


    <!-- overlayScrollbars -->
    <script src="<?= base_url('assets/admin');?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/admin');?>/dist/js/adminlte.min.js"></script>
   
    <script src="<?= base_url('assets/admin');?>/plugins/summernote/summernote-bs4.min.js"></script> 
    <!-- PAGE PLUGINS --> 
    <script src="<?= base_url('assets/admin');?>/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/admin');?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets/admin');?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url('assets/admin');?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    
    <script src="<?= base_url('assets/admin');?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url('assets/admin');?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets/admin');?>/plugins/jszip/jszip.min.js"></script>
    <script src="<?= base_url('assets/admin');?>/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?= base_url('assets/admin');?>/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?= base_url('assets/admin');?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url('assets/admin');?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url('assets/admin');?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    
    <?php if($page_name == 'dashboard'){ ?> 
        
        <script src="<?= base_url('assets/admin');?>/dashboard.js"></script>
    <!-- jQuery Mapael -->
    <!-- <script src="<?= base_url('assets/admin');?>/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="<?= base_url('assets/admin');?>/plugins/raphael/raphael.min.js"></script>
    <script src="<?= base_url('assets/admin');?>/plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="<?= base_url('assets/admin');?>/plugins/jquery-mapael/maps/usa_states.min.js"></script> -->
    <!-- ChartJS -->
   
    <!-- dropzonejs -->
    <!-- <script src="<?= base_url('assets/admin');?>/plugins/dropzone/min/dropzone.min.js"></script> -->

    <?php } ?>


    <!-- AdminLTE for demo purposes -->
    <!-- <script src="<?= base_url('assets/admin');?>/dist/js/demo.js"></script> -->
    <script>
        
        // $(function () {
        //     $("#example1").DataTable({
        //         "responsive": true, "lengthChange": false, "autoWidth": false,
        //         //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        //     }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        //     $('#example2').DataTable({
        //         "paging": true,
        //         "lengthChange": false,
        //         "searching": false,
        //         "ordering": true,
        //         "info": true,
        //         "autoWidth": false,
        //         "responsive": true,
        //     });
        // });
        
</script>
<script type="text/javascript">
    $(function () {
        $("#example2").DataTable({
          "responsive": true, "lengthChange": false, "autoWidth": false, "ordering": true,"paging": false, "info": false, "searching": true,
          "buttons": ["excel", ]
        }).buttons().container().appendTo('#example2_wrapper .col-md-6:eq(0)');
        
        // $('#example1').DataTable({
        //     "paging": false,
        //     "lengthChange": false,
        //     "searching": false,
        //     "ordering": false,
        //     "info": false,
        //     "autoWidth": false,
        //     "responsive": true,
        // });
    });
    </script>
    </body>
</html>
