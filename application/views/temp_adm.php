<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dmenk Clothing e-shop">
    <meta name="author" content="Rizki Yuanda | rizkiyuandaa@gmail.com">
    <meta name="dmenk-toko-online-ecommerce" content="">

    <title>
        Dmenk Clothing E-Shop
    </title>

    <meta name="dmenk-toko-online-ecommerce" content="">

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="<?php echo config_item('assets'); ?>img/logo.png" />
    
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?php echo config_item('assets'); ?>adminlte/css/bootstrap.min.css">
    <!-- jquery-ui.css -->
    <link rel="stylesheet" href="<?php echo config_item('assets'); ?>jQueryUI/themes/base/jquery-ui.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo config_item('assets'); ?>adminlte/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo config_item('assets'); ?>adminlte/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo config_item('assets'); ?>adminlte/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo config_item('assets'); ?>adminlte/css/skins/skin-black.css">
    <!-- <link rel="stylesheet" href="<?php echo config_item('assets'); ?>dist/css/skins/_all-skins.min.css"> -->
    <!-- your stylesheet with modifications -->
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo config_item('assets'); ?>css/custom_adm.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo config_item('assets'); ?>datepicker/datepicker3.css">
    <!-- select2 -->
    <link rel="stylesheet" href="<?php echo config_item('assets'); ?>select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo config_item('assets'); ?>select2/select2-bootstrap.css">
    <!-- css notifikasi -->
    <link rel="stylesheet" href="<?php echo config_item('assets'); ?>adminlte/css/notifikasi.css">

  <?php 
    //load file css per modul
    if(isset($css)){
      $this->load->view($css);
  }?>
  
</head>
<!-- configure skin theme in body class -->
<body class="hold-transition skin-black sidebar-mini">
  <div class="wrapper">
    <!-- <div id="all"> -->
    <!-- Content Wrapper. Contains page content -->
    <!-- *** NAVBAR *** -->
    <!--  _________________________________________________________ -->

    <?php $this->load->view('temp_navbar_adm') ?>
    <!-- /#navbar -->

    <!-- *** SIDEBAR *** -->
    <!--_________________________________________________________ -->

    <?php $this->load->view('temp_sidebar_adm') ?>
    <!-- /#sidebar -->
    <!-- Left side column. contains the logo and sidebar -->
    <!-- Content Wrapper. Contains page content -->


    <!-- content -->
    <!-- load content from controller -->
    <!-- cek id level to unset notif stok if true -->
    <div class="content-wrapper">
      <?php if ($this->session->flashdata('cek_stok')) { ?>
      <div class="alert alert-danger" style="height: 45px; margin: 0px;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong><p class="icon fa fa-warning" align="center"> Peringatan : <?php echo $this->session->flashdata('cek_stok'); ?></p></strong>
      </div>
      <?php } ?>
      
      <?php 
      if (isset($content)) {
      	$this->load->view($content); 
      } ?>
    </div>
    <!-- /.content-wrapper -->

    <!-- _________________________________________________________ -->
      <!-- *** FOOTER *** -->
      <?php $this->load->view('temp_footer_adm'); ?>
      <!-- /#footer -->
      <!-- *** FOOTER END *** -->
  </div>
  <!-- ./wrapper -->
  
  <!-- load modal per modul -->
  <?php
  if(isset($modal)){
    $this->load->view($modal);
  } ?>

  <!-- jQuery 2.2.3 -->
  <script src="<?php echo config_item('assets'); ?>jQuery/jquery-2.2.3.min.js"></script>
  <!-- jquery validation -->
  <script src="<?php echo config_item('assets'); ?>js/jquery-validation.js"></script>
  <!-- jQuery UI  -->
  <script src="<?php echo config_item('assets'); ?>jQueryUI/jquery-ui.min.js"></script>
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo config_item('assets'); ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- Sparkline -->
  <script src="<?php echo config_item('assets'); ?>sparkline/jquery.sparkline.min.js"></script>
  <!-- datepicker -->
  <script src="<?php echo config_item('assets'); ?>datepicker/bootstrap-datepicker.js"></script>
  <!-- select2 -->
  <script src="<?php echo config_item('assets'); ?>select2/select2.min.js"></script>
  <!-- chartjs -->
  <script src="<?php echo config_item('assets'); ?>chartjs/Chart.min.js"></script>
  <!-- Slimscroll -->
  <script src="<?php echo config_item('assets'); ?>slimScroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="<?php echo config_item('assets'); ?>fastclick/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="<?php echo config_item('assets'); ?>adminlte/app.min.js"></script>
  <!-- DataTables -->
  <script src="<?php echo config_item('assets')?>datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo config_item('assets')?>datatables/dataTables.bootstrap.min.js"></script>
  
  <!-- load js per modul -->
  <?php
  if(isset($js)){
    $this->load->view($js);
  } ?>

  <!-- load modal login js -->
  <?php $this->load->view('modal_js'); ?>

  <script>
    $(document).ready(function() {
      //update dt_read after click
      $(document).on('click', '.linkNotif', function(){
          var id = $(this).attr('id');
          $.ajax({
              url : "<?php echo site_url('inbox_adm/update_read_email/')?>" + id,
              type: "POST",
              dataType: "JSON",
              success: function(data)
              {
                  location.href = "<?php echo site_url('inbox_adm')?>";
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
          });
      });
    });
    //end jquery

    setInterval(function(){
      $("#load_row").load('<?=base_url()?>inbox_adm/load_email_row_notif')
    }, 10000); //menggunakan setinterval jumlah notifikasi akan selalu update setiap 10 detik diambil dari controller notifikasi fungsi load_row
     
    setInterval(function(){
        $("#load_data").load('<?=base_url()?>inbox_adm/load_email_data_notif')
    }, 10000); //yang ini untuk selalu cek isi data notifikasinya sama setiap 10 detik diambil dari controller notifikasi fungsi load_data

    //fix to issue select2 on modal when opening in firefox, thanks to github
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
  </script>
  
</body>
</html>
