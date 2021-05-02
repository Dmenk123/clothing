<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> 
	<div class="navbar navbar-default yamm" role="navigation" id="navbar">
        <div class="container">
            <div class="navbar-header">

                <a class="navbar-brand home" href="index.html" data-animate-hover="bounce">
                    <img src="<?php echo config_item('assets'); ?>img/logo.png" alt="Obaju logo" class="hidden-xs">
                    <img src="<?php echo config_item('assets'); ?>img/logo-small.png" alt="Obaju logo" class="visible-xs"><span class="sr-only">Obaju - go to homepage</span>
                </a>
                <div class="navbar-buttons">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-align-justify"></i>
                    </button>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#search">
                        <span class="sr-only">Toggle search</span>
                        <i class="fa fa-search"></i>
                    </button>
                    <a class="btn btn-default navbar-toggle" href="basket.html">
                        <i class="fa fa-shopping-cart"></i>  <span class="hidden-xs">3 items in cart</span>
                    </a>
                </div>
            </div>
            <!--/.navbar-header -->

            <!-- nav-collapse -->
            <div class="navbar-collapse collapse" id="navigation">
                <ul class="nav navbar-nav navbar-left">
                <?php if ($this->uri->segment('1') == 'home') { ?>
                    <li class="active"><a href="<?php echo site_url('home'); ?>">Home</a></li>
                    <!-- list Men -->
                    <li class="dropdown yamm-fw">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pria <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="yamm-content">
                                    <div class="row">
                                        <?php foreach ($menu_navbar_pria as $val) { ?>
                                        <div class="col-sm-3">
                                            <h5><?php echo $val->nama_kategori; ?></h5>
                                            <ul>
                                                <?php if ($val->id_kategori === "1") { ?>
                                                    <?php foreach ($submenu_pria_pakaian as $val) { ?>
                                                        <li>
                                                            <a href='<?php echo site_url("produk_pria/$val->path_sub_kategori"); ?>'><?php echo $val->nama_sub_kategori; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>

                                                <?php if ($val->id_kategori === "2") { ?>
                                                    <?php foreach ($submenu_pria_celana as $val) { ?>
                                                        <li>
                                                            <a href='<?php echo site_url("produk_pria/$val->path_sub_kategori"); ?>'><?php echo $val->nama_sub_kategori; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- /.yamm-content -->
                            </li>
                        </ul>
                    </li>
                    <!-- list women -->
                    <li class="dropdown yamm-fw">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Wanita <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="yamm-content">
                                    <div class="row">
                                        <?php foreach ($menu_navbar_wanita as $val) { ?>
                                        <div class="col-sm-3">
                                            <h5><?php echo $val->nama_kategori; ?></h5>
                                            <ul>
                                                <?php if ($val->id_kategori === "1") { ?>
                                                    <?php foreach ($submenu_wanita_pakaian as $val) { ?>
                                                        <li>
                                                            <a href='<?php echo site_url("produk_wanita/$val->path_sub_kategori"); ?>'><?php echo $val->nama_sub_kategori; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if ($val->id_kategori === "2") { ?>
                                                    <?php foreach ($submenu_wanita_celana as $val) { ?>
                                                        <li>
                                                            <a href='<?php echo site_url("produk_wanita/$val->path_sub_kategori"); ?>'><?php echo $val->nama_sub_kategori; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <?php } ?>
                                        <!-- <div class="col-sm-3">
                                            <div class="banner">
                                                <a href="#">
                                                    <img src="<?php echo config_item('assets'); ?>img/banner.jpg" class="img img-responsive" alt="">
                                                </a>
                                            </div>
                                            <div class="banner">
                                                <a href="#">
                                                    <img src="<?php echo config_item('assets'); ?>img/banner2.jpg" class="img img-responsive" alt="">
                                                </a>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <!-- /.yamm-content -->
                            </li>
                        </ul>
                    </li>
                <?php }elseif ($this->uri->segment('1') == 'produk_pria') { ?>
                    <li><a href="<?php echo site_url('home'); ?>">Home</a></li>
                    <!-- list Men -->
                    <li class="dropdown yamm-fw active">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pria <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="yamm-content">
                                    <div class="row">
                                        <?php foreach ($menu_navbar_pria as $val) { ?>
                                        <div class="col-sm-3">
                                            <h5><?php echo $val->nama_kategori; ?></h5>
                                            <ul>
                                                <?php if ($val->id_kategori === "1") { ?>
                                                    <?php foreach ($submenu_pria_pakaian as $val) { ?>
                                                        <li>
                                                            <a href='<?php echo site_url("produk_pria/$val->path_sub_kategori"); ?>'><?php echo $val->nama_sub_kategori; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>

                                                <?php if ($val->id_kategori === "2") { ?>
                                                    <?php foreach ($submenu_pria_celana as $val) { ?>
                                                        <li>
                                                            <a href='<?php echo site_url("produk_pria/$val->path_sub_kategori"); ?>'><?php echo $val->nama_sub_kategori; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- /.yamm-content -->
                            </li>
                        </ul>
                    </li>
                    <!-- list women -->
                    <li class="dropdown yamm-fw">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Wanita <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="yamm-content">
                                    <div class="row">
                                        <?php foreach ($menu_navbar_wanita as $val) { ?>
                                        <div class="col-sm-3">
                                            <h5><?php echo $val->nama_kategori; ?></h5>
                                            <ul>
                                                <?php if ($val->id_kategori === "1") { ?>
                                                    <?php foreach ($submenu_wanita_pakaian as $val) { ?>
                                                        <li>
                                                            <a href='<?php echo site_url("produk_wanita/$val->path_sub_kategori"); ?>'><?php echo $val->nama_sub_kategori; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if ($val->id_kategori === "2") { ?>
                                                    <?php foreach ($submenu_wanita_celana as $val) { ?>
                                                        <li>
                                                            <a href='<?php echo site_url("produk_wanita/$val->path_sub_kategori"); ?>'><?php echo $val->nama_sub_kategori; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- /.yamm-content -->
                            </li>
                        </ul>
                <?php }elseif ($this->uri->segment('1') == 'produk_wanita') {?>
                    <li><a href="<?php echo site_url('home'); ?>">Home</a></li>
                    <!-- list Men -->
                    <li class="dropdown yamm-fw">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pria <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="yamm-content">
                                    <div class="row">
                                        <?php foreach ($menu_navbar_pria as $val) { ?>
                                        <div class="col-sm-3">
                                            <h5><?php echo $val->nama_kategori; ?></h5>
                                            <ul>
                                                <?php if ($val->id_kategori === "1") { ?>
                                                    <?php foreach ($submenu_pria_pakaian as $val) { ?>
                                                        <li>
                                                            <a href='<?php echo site_url("produk_pria/$val->path_sub_kategori"); ?>'><?php echo $val->nama_sub_kategori; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>

                                                <?php if ($val->id_kategori === "2") { ?>
                                                    <?php foreach ($submenu_pria_celana as $val) { ?>
                                                        <li>
                                                            <a href='<?php echo site_url("produk_pria/$val->path_sub_kategori"); ?>'><?php echo $val->nama_sub_kategori; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- /.yamm-content -->
                            </li>
                        </ul>
                    </li>
                    <!-- list women -->
                    <li class="dropdown yamm-fw active">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Wanita <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="yamm-content">
                                    <div class="row">
                                        <?php foreach ($menu_navbar_wanita as $val) { ?>
                                        <div class="col-sm-3">
                                            <h5><?php echo $val->nama_kategori; ?></h5>
                                            <ul>
                                                <?php if ($val->id_kategori === "1") { ?>
                                                    <?php foreach ($submenu_wanita_pakaian as $val) { ?>
                                                        <li>
                                                            <a href='<?php echo site_url("produk_wanita/$val->path_sub_kategori"); ?>'><?php echo $val->nama_sub_kategori; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if ($val->id_kategori === "2") { ?>
                                                    <?php foreach ($submenu_wanita_celana as $val) { ?>
                                                        <li>
                                                            <a href='<?php echo site_url("produk_wanita/$val->path_sub_kategori"); ?>'><?php echo $val->nama_sub_kategori; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- /.yamm-content -->
                            </li>
                        </ul>    
                <?php }else{ ?>
                    <li class="active"><a href="<?php echo site_url('home'); ?>">Home</a></li>
                    <!-- list Men -->
                    <li class="dropdown yamm-fw">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pria <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="yamm-content">
                                    <div class="row">
                                        <?php foreach ($menu_navbar_pria as $val) { ?>
                                        <div class="col-sm-3">
                                            <h5><?php echo $val->nama_kategori; ?></h5>
                                            <ul>
                                                <?php if ($val->id_kategori === "1") { ?>
                                                    <?php foreach ($submenu_pria_pakaian as $val) { ?>
                                                        <li>
                                                            <a href='<?php echo site_url("produk_pria/$val->path_sub_kategori"); ?>'><?php echo $val->nama_sub_kategori; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>

                                                <?php if ($val->id_kategori === "2") { ?>
                                                    <?php foreach ($submenu_pria_celana as $val) { ?>
                                                        <li>
                                                            <a href='<?php echo site_url("produk_pria/$val->path_sub_kategori"); ?>'><?php echo $val->nama_sub_kategori; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- /.yamm-content -->
                            </li>
                        </ul>
                    </li>
                    <!-- list women -->
                    <li class="dropdown yamm-fw">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Wanita <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="yamm-content">
                                    <div class="row">
                                        <?php foreach ($menu_navbar_wanita as $val) { ?>
                                        <div class="col-sm-3">
                                            <h5><?php echo $val->nama_kategori; ?></h5>
                                            <ul>
                                                <?php if ($val->id_kategori === "1") { ?>
                                                    <?php foreach ($submenu_wanita_pakaian as $val) { ?>
                                                        <li>
                                                            <a href='<?php echo site_url("produk_wanita/$val->path_sub_kategori"); ?>'><?php echo $val->nama_sub_kategori; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if ($val->id_kategori === "2") { ?>
                                                    <?php foreach ($submenu_wanita_celana as $val) { ?>
                                                        <li>
                                                            <a href='<?php echo site_url("produk_wanita/$val->path_sub_kategori"); ?>'><?php echo $val->nama_sub_kategori; ?></a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- /.yamm-content -->
                            </li>
                        </ul>    
                <?php } ?>
                </ul>
            </div>
            <!--/.nav-collapse -->

            <div class="navbar-buttons">

                <div class="navbar-collapse collapse right" id="basket-overview">
                    <a href="basket.html" class="btn btn-primary navbar-btn"><i class="fa fa-shopping-cart"></i><span class="hidden-sm">3 items in cart</span></a>
                </div>
                <!--/.nav-collapse -->

                <div class="navbar-collapse collapse right" id="search-not-mobile">
                    <button type="button" class="btn navbar-btn btn-primary" data-toggle="collapse" data-target="#search">
                        <span class="sr-only">Toggle search</span>
                        <i class="fa fa-search"></i>
                    </button>
                </div>

            </div>

            <div class="collapse clearfix" id="search">

                <form class="navbar-form" role="search">
                    <div class="form-group">
                        <select class="form-control">
                            <option value="">All</option>
                            <?php foreach ($menu_select_search as $value) { ?>
                               <option value="<?php echo $value->id_sub_kategori; ?>"><?php echo $value->ket_sub_kategori; ?></option>
                            <?php } ?>
                        </select>
                        <input type="text" class="form-control" placeholder="Search">
                        <button type="submit" class="btn btn-primary form-control"><i class="fa fa-search"></i></button>
		          </div>
                </form>

            </div>
            <!--/.nav-collapse -->

        </div>
        <!-- /.container -->
    </div>