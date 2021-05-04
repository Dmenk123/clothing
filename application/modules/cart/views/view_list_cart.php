<div class="container">
    <div class="col-md-12">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('home'); ?>">Home </a></li>
            <li><?php echo $this->uri->segment('1'); ?></li>
            <!-- <li><?php foreach ($get_data_page as $row) { echo $row->nama_sub_kategori; } ?></li> -->
        </ul>
    </div>
        
    <div class="col-md-9" id="basket">
        <div class="box">
            <form method="post" action="checkout1.html">
                <h1>Keranjang Belanja Anda</h1>
                <!-- hitung produk pada cart --> 
                <?php $rows = count($this->cart->contents()); ?>
                <p class="text-muted">Barang pada keranjang belanja anda : <span id="countItems"><?php echo $rows; ?></span> items</p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Ukuran</th>
                                <th>Qty</th>
                                <th>Berat Satuan</th>
                                <th>Berat Total</th>
                                <th>Harga Satuan</th>
                                <th>Harga Total</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody id="detail_cart">
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
                <div class="box-footer">
                    <div class="pull-left">
                        <a href="<?php echo site_url('home') ?>" class="btn btn-default"><i class="fa fa-chevron-left"></i> Kembali belanja</a>
                    </div>
                    <div class="pull-right">
                        <!-- <button class="btn btn-default"><i class="fa fa-refresh"></i> Update basket</button> -->
                        <?php $link = site_url('checkout'); ?>
                        <button type="button" onClick='location.href="<?php echo $link; ?>"' class="btn btn-primary btnNextStep1">Lanjutkan <i class="fa fa-chevron-right"></i></button>
                    </div>
                </div>
            </form>
        </div><!-- /.box -->
                    
        <div class="row same-height-row">
			<!-- <div class="box" style="padding-top: 0px;padding-bottom: 0px;margin-bottom: 20px;">
				<div class="container">
					<div class="col-md-9">
						<h4>Rekomendasi Untuk Anda</h4>
					</div>
				</div>
			</div> -->
			<?php foreach ($produk_terlaris as $key => $val): ?>
				<?php if($key == count($produk_terlaris)-1) {
					break;
				}?>

				<div class="col-md-3 col-sm-6">
					<div class="product same-height">
						<div class="flip-container">
							<div class="flipper">
								<div class="front">
									<a href="<?php echo site_url('produk/produk_detail/').$val->slug; ?>">
										<img src="<?php echo config_item('assets'); ?>img/produk/<?php echo $val->nama_gambar; ?>" alt="" class="img-responsive">
									</a>
								</div>
								<div class="back">
									<a href="<?php echo site_url('produk/produk_detail/').$val->slug; ?>">
										<img src="<?php echo config_item('assets'); ?>img/produk/<?php echo $val->nama_gambar; ?>" alt="" class="img-responsive">
									</a>
								</div>
							</div>
						</div>
						<a href="detail.html" class="invisible">
							<img src="<?php echo config_item('assets'); ?>img/produk/<?php echo $val->nama_gambar; ?>" alt="" class="img-responsive">
						</a>
						<div class="text">
							<h3>
                                <a href="<?php echo site_url('produk/produk_detail/').$val->slug; ?>">
                                    <?php echo $val->nama_produk; ?>
                                </a>
                            </h3>
							<p class="price"><strong>Rp. <?php echo number_format($val->harga,0,",","."); ?></strong></p>
							<p class="buttons">
								<a href="<?php echo site_url('produk/produk_detail/').$val->slug; ?>" class="btn btn-primary">Beli Sekarang</a>
							</p>
						</div>
					</div><!-- /.product -->
				</div>
			<?php endforeach ?>
        </div>
    </div><!-- /.col-md-9 -->
                
    <div class="col-md-3">
        <div class="box" id="order-summary">
            <div class="box-header">
                <h3 align="center">Biaya Total</h3>
            </div>
            <p class="text-muted">Berlaku tambahan pengirimian apabila menggunakan jasa ekspedisi.</p>
            <div class="table-responsive">
                <table class="table">
                    <tbody id="detail_summary">              
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- /.col-md-3 -->                      
</div><!-- /.container -->
