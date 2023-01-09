<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Vidiem BackEnd </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>css/skins/_all-skins.min.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/morris.js/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/jvectormap/jquery-jvectormap.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Sweet Alert -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/sweetalert/css/sweetalert.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/iCheck/all.css">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/fullcalendar/dist/fullcalendar.min.css">
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/fullcalendar/dist/fullcalendar.print.min.css" media="print">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
        href="<?= LAYOUT_URL; ?>plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/select2/dist/css/select2.min.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <!-- bootstrap slider -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/bootstrap-slider/slider.css">
    <!-- Dashboard Common Style -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>css/dashboard.css">
    <!-- Developer Style -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>css/developer.css">
    <!-- Video Player Style -->
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/video-player/css/video_player.css">
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/summernote/summernote.css">
    <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/multiselect/css/multi-select.css">
    <script>
    var tmp_base_url = '<?= base_url(); ?>';
    </script>
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body
    class="hold-transition <?= $this->session->userdata('user_theme_color'); ?> sidebar-mini <?= $this->session->userdata('user_menu_style'); ?>">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="<?= base_url('Admin/dashboard'); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">Vidiem</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Vidiem</b></span>
      </a>
          <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle sidebar-toggler" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

          <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                  <!-- Messages: style can be found in dropdown.less-->
                  <!-- User Account: style can be found in dropdown.less -->
                  <li class="dropdown user user-menu">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          <img src="<?= base_url('uploads/profile/'.$this->session->userdata('user_image')); ?>"
                              class="user-image" alt="User Image">
                          <span class="hidden-xs"><?= ucfirst($this->session->userdata('user_name')); ?></span>
                      </a>
                      <ul class="dropdown-menu">
                          <!-- User image -->
                          <li class="user-header">
                              <img src="<?= base_url('uploads/profile/'.$this->session->userdata('user_image')); ?>"
                                  class="img-circle" alt="User Image">
                              <p>
                                  <?= ucfirst($this->session->userdata('user_name')); ?>
                                  <!-- <small>Member since Nov. 2012</small> -->
                              </p>
                          </li>
                          <!-- Menu Body -->
                          <!-- Menu Footer-->
                          <li class="user-footer">
                              <div class="pull-left">
                                  <a href="<?= base_url('Admin/profile'); ?>"
                                      class="btn btn-default btn-flat">Profile</a>
                              </div>
                              <div class="pull-right">
                                  <a href="javascript:void(0);"
                                      class="btn btn-default btn-flat logout_trigger">Sign out</a>
                              </div>
                          </li>
                      </ul>
                  </li>
                  <!-- Control Sidebar Toggle Button -->
              </ul>
          </div>
      </nav>
    </header>