<div class="container" style="width:100%!important">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="#">Home</a></li>
         <li><a href="<?=base_url().$this->uri->segment(1);?>"><?php echo $this->uri->segment(1); ?></a></li>
         <li>Metode Pembayaran</li>
      </ul>
   </div>
   <div class="col-md-12" id="checkout">
		<div class="box">
			<h2 style="color:#4fbfa8;">Checkout</h2>
			<ul class="nav nav-pills nav-justified">
				<li class="miring"><a href="<?=base_url('checkout');?>"><i class="fa fa-map-marker"></i><br>Alamat</a>
				</li>
				<li class="miring"><a href="<?=base_url('checkout/step2');?>"><i class="fa fa-truck"></i><br>Ekspedisi</a>
				</li>
				<li class="active miring"><a href="#"><i class="fa fa-money"></i><br>Pembayaran</a>
				</li>
			</ul>

			<!-- <form class="ps-checkout__form" id="payment-form" method="post" action="<?=site_url()?>snap/finish">
				<input type="hidden" name="result_type" id="result-type" value=""></div>
				<input type="hidden" name="result_data" id="result-data" value=""></div>
				<input type="hidden" name="formulir-data" id="formulir-data" value=""></div>
			</form> -->

			<div class="content" style="margin-top:50px;">
				<!-- flashdata -->
				<?php if ($this->session->flashdata('feedback_success')) { ?>
					<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
					<?= $this->session->flashdata('feedback_success') ?>
					</div>
				<?php } elseif ($this->session->flashdata('feedback_failed')) { ?>
					<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h4><i class="icon fa fa-remove"></i> Gagal!</h4>
					<?= $this->session->flashdata('feedback_failed') ?>
				</div>
				<?php } ?>
				<!-- end flashdata -->
				<div class="text-center top-text">
					<h3 style="color: #4fbfa8;"><span>Pilih Metode</span> Pembayaran</h3>
					<!--<h4>Silahkan Pilih Metode Pembayaran</h4>-->
				</div>

				<div class="row div-tombol-payment">
					<div class="col-sm-6 col-md-6 col-xs-6">
						<div class="latest-post pull-right">
							<a class="img-thumb tombol_method_bayar" href="transfer"><img style="max-width: 80%;" src="<?= base_url('assets/img/transfer1aa.png')?>" alt="img" width="300" height="180" class="pull-right"></a>
						</div>
					</div>
					<div class="col-sm-6 col-md-6 col-xs-6">
						<div class="latest-post pull-left">
							<a class="img-thumb tombol_method_bayar" href="payment"><img style="max-width: 80%;" src="<?= base_url('assets/img/transfer2aa.png')?>" alt="img" width="300" height="180"></a>
						</div>
					</div>
				</div>
				
				<div id="lock-modal"></div>
				<div id="loading-circle"></div>
				
				

				<div class="col-12" id="main-form-bayar">
				
				</div>

			</div>
			
			<div class="box-footer">
				<div class="pull-left">
					<a href="<?= base_url('checkout/step2'); ?>" class="btn btn-default"><i class="fa fa-chevron-left"></i>Kembali</a>
				</div>
				<!-- <div class="pull-right">
					<button type="submit" class="btn btn-primary">Lanjutkan Ke Metode Pembayaran<i class="fa fa-chevron-right"></i></button>
				</div> -->
			</div>
		</div>
		<!-- /.box -->
	</div>
</div><!-- /.container -->
