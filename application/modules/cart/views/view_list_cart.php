<div class="container" style="width:100%!important">
    <div class="col-md-12">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('home'); ?>">Home </a></li>
            <li><?php echo $this->uri->segment('1'); ?></li>
            <!-- <li><?php foreach ($get_data_page as $row) { echo $row->nama_sub_kategori; } ?></li> -->
        </ul>
    </div>
        
    <div class="col-md-12 col-sm-12" id="basket">
        <div class="box">
            <form method="post" action="checkout1.html">
                <h2 style="color:#4fbfa8;">Keranjang Belanja Anda</h2>
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
					<div class="col-12 row">
						<div class="col-xs-6 col-md-6">
							<a href="<?php echo site_url('home') ?>" class="btn btn-warning pull-left tombol-ckt"><i class="fa fa-chevron-left"></i> Kembali belanja</a>
						</div>
						<div class="col-xs-6 col-md-6">
							<?php $link = site_url('checkout'); ?>
							<button type="button" onClick='location.href="<?php echo $link; ?>"' class="btn btn-primary btnNextStep1 tombol-ckt pull-right">Lanjutkan <i class="fa fa-chevron-right"></i></button>
						</div>
					</div>
                </div>
            </form>
        </div><!-- /.box -->
                    
        <div class="row same-height-row" style="margin-top: 20px;">
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
						</div>
					</div>
				</div>
			<?php endforeach ?>
        </div>
    </div><!-- /.col-md-9 -->               
</div><!-- /.container -->
