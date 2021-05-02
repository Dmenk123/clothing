<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="all,follow">
    <meta name="googlebot" content="index,follow,snippet,archive">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Dmenk Clothing e-shop">
    <meta name="author" content="Rizki Yuanda | rizkiyuandaa@gmail.com">
    <meta name="dmenk-toko-online-ecommerce" content="">

    <title>
        Dmenk Clothing E-Shop
    </title>

    <meta name="dmenk-toko-online-ecommerce" content="">

    <link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="<?php echo config_item('assets'); ?>img/logo.png" />
    <!-- styles -->
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo config_item('assets'); ?>css/bootstrap.min.css">
    <!-- font awesome -->
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo config_item('assets'); ?>css/font-awesome.css">
    <!-- jquery-ui.css -->
    <link rel="stylesheet" href="<?php echo config_item('assets'); ?>jQueryUI/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo config_item('assets'); ?>css/animate.min.css">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo config_item('assets'); ?>css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo config_item('assets'); ?>css/owl.theme.css">
    <!-- theme stylesheet -->
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo config_item('assets'); ?>css/style.default.css">
    <!-- your stylesheet with modifications -->
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo config_item('assets'); ?>css/custom.css">
    <!-- select2 -->
    <link rel="stylesheet" href="<?php echo config_item('assets'); ?>select2/select2.min.css">
    <link rel="stylesheet" href="<?php echo config_item('assets'); ?>select2/select2-bootstrap.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?php echo config_item('assets'); ?>datepicker/datepicker3.css">

    <script src="<?php echo config_item('assets'); ?>js/respond.min.js"></script>

    <link rel="stylesheet" type="text/css" media="all" href="<?php echo config_item('assets'); ?>icon/favicon.png">


</head>

<body>
    <!-- *** NAVBAR ***
 _________________________________________________________ -->

    <?php $this->load->view('temp_navbar'); ?>
    <!-- /#navbar -->

    <!-- *** NAVBAR END *** -->



    <div id="all">

        <div id="content">
            <!-- main-slider -->
            <?php 
                if (isset($content_slider)) 
                {
                    $this->load->view($content_slider); 
                } 
             ?>
            <!-- /#main-slider -->
<!--  __________________ _______________________________________ -->
            <!-- *** ADVANTAGES HOMEPAGE *** -->
            <?php 
                if (isset($content_advantage)) 
                {
                    $this->load->view($content_advantage); 
                } 
             ?>
            <!-- /#advantages -->
            <!-- *** ADVANTAGES END *** -->
<!--  _________________________________________________________ -->
            <!-- *** HOT PRODUCT SLIDESHOW *** -->
            <?php 
                if (isset($content_hot)) 
                {
                    $this->load->view($content_hot); 
                } 
             ?>
            <!-- /#hot -->
            <!-- *** HOT END *** -->
<!--  _________________________________________________________ -->
        <!-- *** Content page *** -->
            <?php 
                if (isset($content)) 
                {
                    $this->load->view($content); 
                } 
             ?>
            <!-- /#content_list_product -->
            <!-- *** content_list_product END *** -->
<!--  _________________________________________________________ -->
        </div>
        <!-- /#content -->

<!-- _________________________________________________________ -->
        <!-- *** FOOTER *** -->
        <?php $this->load->view('temp_footer'); ?>
        <!-- /#footer -->
        <!-- *** FOOTER END *** -->




        <!-- *** COPYRIGHT ***
 _________________________________________________________ -->
         <?php $this->load->view('temp_copyright'); ?>
        <!-- *** COPYRIGHT END *** -->

    </div>
    <!-- /#all -->

    <!-- modal login -->
    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Login">Customer login</h4>
                </div>
                <div class="modal-body">
                    <form id="form_login" action="#">
                        <div class="form-group">
                            <input type="text" class="form-control" id="email-modal" name="emailModal" placeholder="email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="password-modal" name="passwordModal" placeholder="password">
                        </div>
                    </form>
                    <p class="text-center">
                        <button class="btn btn-primary" onclick="login_proc()"><i class="fa fa-sign-in"></i> Log in</button>
                    </p>
                    <p class="text-center text-muted">
                        <a href="<?php echo site_url('register'); ?>">
                            <strong>Daftar Sekarang </strong>
                        </a>! Caranya cukup mudah hanya 1&nbsp;menit dan banyak penawaran yang akan kami berikan !
                    </p>
                    <p class="text-center text-muted">Atau Klik 
                        <a href="#" data-toggle="modal" data-target="#modal_forgot_pass">
                            <strong>disini</strong>
                        </a> apabila anda lupa password anda
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- modal forgot password -->
    <div class="modal fade" id="modal_forgot_pass" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Lupa Password ?</h4>
                </div>
                <div class="modal-body">
                    <form id="form_forgot_pass" action="#">
                        <div class="form-group">
                            <label for="lblEmailForgot" class="lblEmailForgotErr">Email</label>
                            <input type="text" class="form-control" id="email_forgot" name="emailForgot" placeholder="Mohon masukkan Email anda" required>
                        </div>
                    </form>
                    <p class="text-center text-muted">
                        Mohon Masukkan email anda sesuai dengan yang anda daftarkan pada D-menk Clothing E-shop, Kami akan mengirim link token pada email anda. Terima kasih
                    </p>
                    <p class="text-center" style="padding-top: 20px;">
                        <button class="btn btn-primary" onclick="forgotPassProc()"><i class="fa fa-check"></i> Ok</button>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- load modal per module -->
    <?php if(isset($modal)) { $this->load->view($modal); }?>
    <!-- *** SCRIPTS TO INCLUDE ***
 ____________________________________________________________________ -->
    <script src="<?php echo config_item('assets'); ?>js/jquery-1.11.0.min.js"></script>
    <script src="<?php echo config_item('assets'); ?>js/jquery-validation.js"></script>
    <!-- jQuery UI  -->
    <script src="<?php echo config_item('assets'); ?>jQueryUI/jquery-ui.min.js"></script>
    <script src="<?php echo config_item('assets'); ?>js/bootstrap.min.js"></script>
    <script src="<?php echo config_item('assets'); ?>js/jquery.cookie.js"></script>
    <script src="<?php echo config_item('assets'); ?>js/waypoints.min.js"></script>
    <script src="<?php echo config_item('assets'); ?>js/modernizr.js"></script>
    <script src="<?php echo config_item('assets'); ?>js/owl.carousel.min.js"></script>
    <script src="<?php echo config_item('assets'); ?>js/front.js"></script>
    <!-- select2 -->
    <script src="<?php echo config_item('assets'); ?>select2/select2.min.js"></script>
    <!-- datepicker -->
    <script src="<?php echo config_item('assets'); ?>datepicker/bootstrap-datepicker.js"></script>
    <!--  DataTables --> 
    <script src="<?=config_item('assets')?>datatables/jquery.dataTables.min.js"></script>
    <script src="<?=config_item('assets')?>datatables/dataTables.bootstrap.min.js"></script>
    
    <!-- load js per modul -->
    <?php if(isset($js)) { $this->load->view($js); }?>

    <!-- load modal login js -->
    <?php $this->load->view('modal_js'); ?>
</body>

</html>