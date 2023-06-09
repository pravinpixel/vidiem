<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Vidiem Dealer Admin Counter </title>
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
  <link rel="stylesheet" href="<?= LAYOUT_URL; ?>plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
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
   <style>
    .dealer-top-name{
      color: white;
      font-size: 18px;
      text-transform: uppercase;
      position: relative;
      top: 12px;
    }
    .dealer-top-name .title{
      font-size: 20px;
      font-weight: 800;
    }
   </style>
 <script>
    var tmp_base_url='<?= base_url(); ?>';
  </script>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition <?= $this->session->userdata('user_theme_color'); ?> sidebar-mini <?= $this->session->userdata('user_menu_style'); ?>">
<div class="wrapper">

  <header class="main-header"> 
    <!-- Logo -->
    <div class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="<?= base_url(); ?>assets/back-end/img/logo-small.jpg" alt="" /></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?= base_url(); ?>assets/back-end/img/logo.png" alt="" /></span>
    </div>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle sidebar-toggler" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <a href="#" class="dealer-top-name"> 
        <span class="title">
          <?= $this->session->userdata('dealer_session')['dealer']['display_name'] ?? '' ?>
           
           
        </span>
        
        <span > &nbsp;| &nbsp;VIDIEM BY YOU ORDER MANAGEMENT ( <?= $this->session->userdata('dealer_session')['location']['location_name'] ?? ''  ?> - <?= $this->session->userdata('dealer_session')['location']['location_code'] ?? ''  ?>) </span>
      </a>
       <?php
          if($user_type=='admin' && $dealer_type=='ard' )
          {
          ?>

         
             <span class="label label-warning">ARD</span>
           
    
       
          <?php } else if($user_type=='counter_person' && $dealer_type=='ard') {  ?>
              
         
        <span class="label label-warning">Sub Dealer</span>
           
 
          <?php } ?>
      <div class="navbar-custom-menu">
       <ul class="nav navbar-nav">
          
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- <img src="<?= base_url('uploads/profile/'.$this->session->userdata('user_image')); ?>" class="user-image" alt="User Image"> -->
              <span class="hidden-xs"><?= ucfirst($this->session->userdata('dealer_session')['user']['user_id']); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="javascript:void(0);" class="btn btn-default btn-flat logout_dealer_trigger">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>
    </nav>
  </header>
