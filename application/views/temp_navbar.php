<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> 
	<div class="navbar navbar-default yamm" role="navigation" id="navbar">
        <div class="container">
            <div class="navbar-header">

                <!-- <a class="navbar-brand home" href="index.html" data-animate-hover="bounce"> -->
                <a class="navbar-brand home" href="<?php echo site_url('home'); ?>">
                    <img src="<?php echo config_item('assets'); ?>img/logo.png" alt="dmenk e-shop logo" class="hidden-xs">
                    <img src="<?php echo config_item('assets'); ?>img/logo-small.png" alt="dmenk e-shop logo" class="visible-xs"><span class="sr-only">Obaju - go to homepage</span>
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
                    <a class="btn btn-default navbar-toggle" href="<?php echo site_url('cart'); ?>">
                        <i class="fa fa-shopping-cart"></i>  <span class="hidden-xs">3 items in cart</span>
                    </a>
                </div>
            </div>
            <!--/.navbar-header -->

            <!-- nav-collapse -->
            <div class="navbar-collapse collapse" id="navigation">
                <ul class="nav navbar-nav navbar-left">
                    <!-- Home -->
                    <li class="" id="li_nav_home"><a href="<?php echo site_url('home'); ?>">Home</a></li>
                    <!-- list Men -->
                    <li class="dropdown yamm-fw" id="li_nav_produk">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pilihan Produk <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="yamm-content">
                                    <div class="row">
                                        <?php foreach ($menu_navbar as $val) { ?>
                                        <div class="col-sm-3">
                                            <h5><?php echo $val->nama_kategori; ?></h5>
                                            <?php for ($i=1; $i <=$count_kategori; $i++) { ?>
                                                <?php if ($val->id_kategori == $i) { ?>
                                                    <?php foreach ($submenu[$i] as $result) { ?>
                                                        <ul>
                                                            <li>
                                                                <a href='<?php echo site_url("produk/sub_kategori/$result->id_sub_kategori"); ?>'><?php echo $result->nama_sub_kategori; ?></a>
                                                            </li>
                                                        </ul>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <!-- /.yamm-content -->
                            </li>
                        </ul>
                    </li>
                    <!-- Kontak -->
                    <li class="" id="li_nav_kontak"><a href="<?php echo site_url('kontak'); ?>">Kontak Kami</a></li>
                    <!-- faq -->
                    <li class="" id="li_nav_faq"><a href="<?php echo site_url('faq'); ?>">FAQ</a></li>
                    <!-- login, register, user set -->
                    <?php $nama_sesi = $this->session->userdata('fname_user');
                    if (isset($nama_sesi)) { ?>
                        <li>
                            <a href="javascript:void(0);" onclick="logout_proc()">Logout</a>
                        </li>
                        <li id="li_nav_sesi">
                            <a href="<?php echo site_url('profil'); ?>"><?php echo $nama_sesi; ?>
                                <?php if (isset($notif_count)) { ?>
                                    <?php if ($notif_count > 0) { ?>
                                        <span class="badge badge-danger" id="load_row"><?php echo $notif_count; ?></span>
                                    <?php } ?>
                                <?php } ?>  
                            </a>
                        
                        </li>
                    <?php }else { ?>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#login-modal">Login</a>
                        </li>
                        <li id="li_nav_register">
                            <a href="<?php echo site_url('register'); ?>">Register</a>
                        </li>
                    <?php } ?> 
                </ul>
            </div>
            <!--/.nav-collapse -->

            <div class="navbar-buttons">
                <?php $rows = count($this->cart->contents()); ?>
                <div class="navbar-collapse collapse right" id="basket-overview">
                    <a href="<?php echo site_url('cart'); ?>" class="btn btn-primary navbar-btn"><i class="fa fa-shopping-cart"></i><span class="hidden-sm"><?php echo $rows; ?> items in cart</span></a>
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
                <?php $sub = $this->uri->segment(3); ?>
                <form class="navbar-form" role="search" action="<?php echo site_url('produk/cari_produk/'.$sub); ?>" method="get">
                    <div class="form-group">
                        <select class="form-control" name="select">
                            <?php foreach ($menu_select_search as $value) { ?>
                               <option value="<?php echo $value->id_sub_kategori; ?>"><?php echo $value->nama_sub_kategori; ?></option>
                            <?php } ?>
                        </select>
                        <input type="text" class="form-control" placeholder="Search" name="key">
                        <button type="submit" class="btn btn-primary form-control"><i class="fa fa-search"></i></button>
		          </div>
                </form>

            </div>
            <!--/.nav-collapse -->

        </div>
        <!-- /.container -->
    </div>