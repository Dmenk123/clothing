<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> 
	<div class="navbar navbar-default yamm" role="navigation" id="navbar" style="margin-bottom:15px;padding-bottom:1%;">
        <div class="container">
            <div class="navbar-header">

                <!-- <a class="navbar-brand home" href="index.html" data-animate-hover="bounce"> -->
                <a class="navbar-brand home" href="<?php echo site_url('home'); ?>">
                    <img src="<?php echo config_item('assets'); ?>img/loggo.png" alt="" class="">
                    <img src="<?php echo config_item('assets'); ?>img/logo-smalle.png" alt="" class="visible-xs"><span class="sr-only"></span>
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
                        <i class="fa fa-shopping-cart"></i>  <span class="hidden-xs"><?php echo $rows; ?> items in cart</span>
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
				<form class="navbar-form" role="search" action="<?= base_url('produk/katalog'); ?>" method="get" style="width:100%;margin-left: 0px;margin-right: 0px;">
                    <div class="form-group col-md-12 row">
						<div class="col-md-11">
							<input type="text" class="form-control" placeholder="Temukan Produk Anda disini ......" name="key" style="width: 100%;" value="<?=$this->input->get('key');?>">
						</div>
						<div class="col-md-1">
							<button type="submit" class="btn btn-primary form-control pull-left"><i class="fa fa-search"></i></button>
						</div>
		          </div>
                </form>

            </div>
            <!--/.nav-collapse -->

        </div>
        <!-- /.container -->
    </div>
