<div class="container">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="#">Home</a></li>
         <li><a href="<?=base_url().$this->uri->segment(1);?>"><?php echo $this->uri->segment(1); ?></a></li>
         <li>Metode Pengiriman</li>
      </ul>
   </div>
   <div class="col-md-12" id="checkout">
		<div class="box">
			<form id="form_step2" name="form_step2" method="post">
				<h1>Checkout</h1>
				<ul class="nav nav-pills nav-justified">
					<li class=""><a href="<?=base_url('checkout');?>"><i class="fa fa-map-marker"></i><br>Data & Alamat</a>
					</li>
					<li class="active"><a href="#"><i class="fa fa-truck"></i><br>Jasa Ekspedisi</a>
					</li>
					<li class="disabled"><a href="#"><i class="fa fa-money"></i><br>Metode Pembayaran</a>
					</li>
				</ul>

				<div class="content">
					<div class="row">
						<div class="col-sm-4 div-link" onclick="showHarga('jne')">
							<div class="box shipping-method">
								<p style="text-align: center;">
									<img src="<?=base_url('assets/img/logo_ekspedisi/jne.png')?>" alt="" width="100%" height="150">
									<br>
									<strong>JNE</strong>
								</p>

							</div>
						</div>
						<div class="col-sm-4 div-link" onclick="showHarga('pos')">
							<div class="box shipping-method">

								<p style="text-align: center;">
									<img src="<?=base_url('assets/img/logo_ekspedisi/pos.png')?>" alt="" width="100%" height="150">
									<br>
									<strong>POS Indonesia</strong>
								</p>

							</div>
						</div>

						<div class="col-sm-4 div-link" onclick="showHarga('tiki')">
							<div class="box shipping-method">

								<p style="text-align: center;">
									<img src="<?=base_url('assets/img/logo_ekspedisi/tiki.png')?>" alt="" width="100%" height="150">
									<br>
									<strong>TIKI</strong>
								</p>

							</div>
						</div>
					</div>
					<!-- /.row -->

					<div class="row" id="div-harga-kurir">
						<div class="col-sm-12 div-link">
							<div class="box shipping-method" id="tabel-harga-kurir"></div>
						</div>
					</div>
					<!-- /.row -->
				</div>

				<div class="content" style="padding-top: 3%;">
					<div id="div-kurir-terpilih">

					</div>
				</div>

				<div class="box-footer">
					<div class="pull-left">
						<a href="<?= base_url('checkout'); ?>" class="btn btn-default"><i class="fa fa-chevron-left"></i>Kembali</a>
					</div>
					<div class="pull-right">
						<button type="submit" class="btn btn-primary">Lanjutkan Ke Metode Pembayaran<i class="fa fa-chevron-right"></i></button>
					</div>
				</div>
			</form>
		</div>
		<!-- /.box -->
	</div>
</div><!-- /.container -->
