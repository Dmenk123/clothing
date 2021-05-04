<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> 
	<div class="navbar navbar-default yamm" role="navigation" id="navbar">
        <div class="container">
            <div class="navbar-header">

                <!-- <a class="navbar-brand home" href="index.html" data-animate-hover="bounce"> -->
                <a class="navbar-brand home" href="<?php echo site_url('home'); ?>">
                    <img src="<?php echo config_item('assets'); ?>img/loggo.png" alt="dmenk e-shop logo" class="hidden-xs">
                    <img src="<?php echo config_item('assets'); ?>img/logo-smalle.png" alt="dmenk e-shop logo" class="visible-xs"><span class="sr-only">Obaju - go to homepage</span>
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
                    <!-- Katalog -->
                    <li class="" id="li_nav_kontak"><a href="<?php echo site_url('produk/katalog'); ?>">Katalog</a></li>
                    <!-- Kontak -->
                    <li class="" id="li_nav_kontak"><a href="<?php echo site_url('kontak'); ?>">Kontak Kami</a></li>
                    <!-- faq -->
                    <li class="" id="li_nav_faq"><a href="<?php echo site_url('faq'); ?>">FAQ</a></li>
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
