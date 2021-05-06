<div class="container">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="#">Home</a></li>
         <li><a href="<?=base_url().$this->uri->segment(1);?>"><?php echo $this->uri->segment(1); ?></a></li>
         <li>Data & Alamat</li>
      </ul>
   </div>
   <div class="col-md-12" id="checkout">
		<div class="box">
			<form id="form_step1" name="form_step1" method="post">
					<h1>Checkout</h1>
					<ul class="nav nav-pills nav-justified">
						<li class="active"><a href="#"><i class="fa fa-map-marker"></i><br>Data & Alamat</a>
						</li>
						<li class="disabled"><a href="#"><i class="fa fa-truck"></i><br>Metode Pengiriman</a>
						</li>
						<li class="disabled"><a href="#"><i class="fa fa-money"></i><br>Metode Pembayaran</a>
						</li>
						<li class="disabled"><a href="#"><i class="fa fa-eye"></i><br>Review</a>
						</li>
					</ul>

					<div class="content">
						<p class="lead">Data Customer</p>
						<div class="row">
							<div class="col-sm-6">
									<div class="form-group">
										<label>Email</label>
										<input type="email" class="form-control" name="email" id="email" value="<?php echo ($data_cart) ? $data_cart->email : ''; ?>"> 
										<span class="help-block"></span>
									</div>
							</div>
							<div class="col-sm-6">
									<div class="form-group">
										<label>HP / Telepon</label>
										<input type="text" class="form-control" id="hp" name="hp" value="<?php echo ($data_cart) ? $data_cart->telp : ''; ?>">
										<span class="help-block"></span>
									</div>
							</div>
						</div>
						<hr>
						<!-- /.row -->
						<p class="lead">Data Pengiriman</p>
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label>Nama Lengkap</label>
									<input type="text" class="form-control" id="nama" name="nama" value="<?php echo ($data_cart) ? $data_cart->nama : ''; ?>">
									<span class="help-block"></span>
								</div>
							</div>
						</div>
						<!-- /.row -->

						<div class="row">
							<div class="col-sm-6 col-md-3">
								<div class="form-group">
									<label>Provinsi</label>
									<select class="form-control select2" id="provinsi" name="provinsi"></select>
									<span class="help-block"></span>
								</div>
							</div>
							<div class="col-sm-6 col-md-3">
								<div class="form-group">
									<label for="zip">Kabupaten/Kota</label>
									<select class="form-control select2" id="kota" name="kota" onchange="selectKota()"></select>
									<span class="help-block"></span>
								</div>
							</div>
							<div class="col-sm-6 col-md-3">
								<div class="form-group">
									<label for="state">Kecamatan</label>
									<select class="form-control select2" id="kecamatan" name="kecamatan" onchange="selectKec()"></select>
									<span class="help-block"></span>
								</div>
							</div>
							<div class="col-sm-6 col-md-3">
								<div class="form-group">
									<label for="country">Kelurahan/Desa</label>
									<select class="form-control select2" id="kelurahan" name="kelurahan"></select>
									<span class="help-block"></span>
								</div>
							</div>

							<div class="col-sm-12">
									<div class="form-group">
										<label for="phone">Alamat</label>
										<input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo ($data_cart) ? $data_cart->alamat : ''; ?>">
										<span class="help-block"></span>
									</div>
							</div>
						</div>
						<!-- /.row -->
					</div>

					<div class="box-footer">
						<div class="pull-left">
							<a href="basket.html" class="btn btn-default"><i class="fa fa-chevron-left"></i>Kembali</a>
						</div>
						<div class="pull-right">
							<button type="submit" class="btn btn-primary">Lanjutkan Ke Metode Pengiriman<i class="fa fa-chevron-right"></i>
							</button>
						</div>
					</div>
			</form>
		</div>
		<!-- /.box -->
	</div>
</div><!-- /.container -->
