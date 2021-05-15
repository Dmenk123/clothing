<div class="container">
    <div class="col-md-12">
        <div class="row" id="productMain">
            <?php foreach ($img_detail_big as $val) { ?>
            <?php $link_img = $val->nama_gambar; ?>
            <div class="col-sm-6">
                <div id="mainImage">
                    <img src="<?php echo site_url('assets/img/produk/img_detail/'.$link_img.''); ?>" alt="" class="img-responsive" style="width: 100%;">
                </div>
            </div> <!-- end div.col sm-6 -->
            <?php } ?>

            <div class="col-sm-6">
                <?php foreach ($detail_produk as $val) { ?>
                    <div class="box">
                        <h2 style="color: #4fbfa8;" class="text-center"><?php echo $val->nama_produk; ?></h2>
                        <p class="price">Rp. <?php echo number_format($val->harga,0,",","."); ?></p>
                        <div class="col-sm-4" style="text-align: center;">
                            <label><strong>Size : </strong></label>
                        </div>
                        <div class="col-sm-8" style="padding-bottom: 10px;">
                            <input type="hidden" name="txt_id_produk" class="txtIdProduk" value="<?php echo $val->id_produk; ?>">
                            <select class="form-control selectSize"  id="size_<?php echo $val->id_produk;?>" name="select_size" required>
                                <option value="">Pilih Ukuran Produk</option>
                            </select>
                        </div>
                        <div class="col-sm-4" style="text-align: center;">
                            <label><strong>Qty : </strong></label>
                        </div>
                        <div class="col-sm-8" style="padding-bottom: 10px;">
                            <!-- <select class="form-control selectQty" id="qty_<?php echo $val->id_produk;?>" name="select_qty" required>
                                <option value="">Pilih Qty Produk</option>
                            </select> -->
							<input type="number" class="form-control" id="qty_<?php echo $val->id_produk;?>" name="select_qty">
                        </div>
                        <p class="text-center buttons">
                            <button class="btn btn-primary btn-block add_cart" data-idproduk="<?php echo $val->id_produk;?>" data-namaproduk="<?php echo $val->nama_produk;?>" data-hargaproduk="<?php echo $val->harga;?>" data-gambarproduk="<?php echo $val->nama_gambar;?>"><i class="fa fa-shopping-cart"></i>Add To Cart</button>
                        </p>
                    </div> <!-- end div.box -->
                <?php } ?>

                <div class="row" id="thumbs">
                    <?php foreach ($img_detail_thumb as $val) { ?>
                    <?php $link_img = $val->nama_gambar; ?>
                    <div class="col-xs-4">
                        <a href="<?php echo site_url('assets/img/produk/img_detail/'.$link_img.''); ?>" class="thumb">
                            <img src="<?php echo site_url('assets/img/produk/img_detail/'.$link_img.''); ?>" alt="" class="img-responsive">
                        </a>
                    </div> <!-- end div.col xs-4 -->
                    <?php } ?> 
                </div> <!-- end div.row -->
            </div> <!-- end div.col sm-6 -->
        </div> <!-- end div.row #product-main -->

        <div class="box" id="details">
            <p>
                <h4>Produk Detail</h4>
                <?php foreach ($detail_produk as $key => $value) { ?>
                    <p><?php echo $value->keterangan_produk; ?></p>
                <?php } ?>
        </div> <!-- end div.box #product-detail -->
    </div><!-- /.col-md-9 -->
</div><!-- /.container -->    

<div id="hot">

    <div class="box">
    <div class="container" id="tampilan-pc">
		<div class="col-md-12">
			<h2>Produk Rekomendasi</h2>
		</div>
		<div class="col-md-12 row">
				<?php foreach ($produk_terlaris as $val) { ?>
					<div class="col-md-3">
						<div class="card">
							<div class="card-head">
								<a href="<?php echo site_url('produk/produk_detail/').$val->slug; ?>">
									<img src="<?php echo config_item('assets'); ?>img/produk/<?php echo $val->nama_gambar; ?>" alt="" class="img-responsive2">
								</a>

							</div>
							<div class="card-body">
								<div class="product-desc">
									<span class="product-title">
										<b><?php echo $val->nama_produk; ?></b>
										<!-- <span class="badge">
											New
										</span> -->
									</span>
									<span class="product-caption">
										Basket ball collection
									</span>
									<span class="product-rating">
										<i class="fa fa-star yellow"></i>
										<i class="fa fa-star yellow"></i>
										<i class="fa fa-star yellow"></i>
										<i class="fa fa-star yellow"></i>
										<i class="fa fa-star grey"></i>
									</span>
								</div>
								<div class="product-properties">
									<span class="product-size">
										<h4><b><?php echo 'Rp '.number_format($val->harga,0,",","."); ?></b></h4>
										<!-- <ul class="ul-size">
											<li><a href=""></a>7</li>
											<li><a href=""></a>8</li>
											<li><a href=""></a>9</li>
											<li><a href="" class="active"></a>10</li>
											<li><a href=""></a>11</li>
										</ul> -->
									</span>
									<!-- <span class="product-color">
										<h4>Colors</h4>
										<ul class="ul-color">
											<li><a href="" class="orange"></a></li>
											<li><a href="" class="green"></a></li>
											<li><a href="" class="yellow"></a></li>
										</ul>
									</span> -->
									<br>
									<span class="product-price">
										<a href="<?php echo site_url('produk/produk_detail/').$val->slug; ?>">
											<b>Beli Sekarang</b>
										</a>
									</span>
								</div>
							</div>
						</div>

					</div>
				<?php } ?>
		</div>
	</div>
  

    <div class="container" id="tampilan-hp" style="display:none;padding-left:0px!important;padding-right:0px!important;">
			<div class="col-md-12">
				<h4 style="text-align:center">Produk Rekomendasi</h4>
			</div>
			<div class="col-sm-12 row" style="display:flex;flex-wrap:wrap;padding-left:0px!important;padding-right:0px!important;">
				<?php foreach ($produk_terlaris as $val) { ?>
					<div class="col-sm-6" style="width: calc(50% - 1rem);">
						<div class="card">
							<div class="card-head">
								<a href="<?php echo site_url('produk/produk_detail/').$val->slug; ?>">
									<img src="<?php echo config_item('assets'); ?>img/produk/<?php echo $val->nama_gambar; ?>" alt="" class="img-responsive2">
								</a>

							</div>
							<div class="card-body">
								<div class="product-desc">
									<span class="product-title">
										<b><?php echo $val->nama_produk; ?></b> 
										<!-- <span class="badge">
											New
										</span> -->
									</span>
									<span class="product-caption">
										Basket ball collection
									</span>
									<span class="product-rating">
										<i class="fa fa-star yellow"></i>
										<i class="fa fa-star yellow"></i>
										<i class="fa fa-star yellow"></i>
										<i class="fa fa-star yellow"></i>
										<i class="fa fa-star grey"></i>
									</span>
								</div>
								<div class="product-properties">
									<span class="product-size">
										<h4><b><?php echo 'Rp '.number_format($val->harga,0,",","."); ?></b></h4>
										<!-- <ul class="ul-size">
											<li><a href=""></a>7</li>
											<li><a href=""></a>8</li>
											<li><a href=""></a>9</li>
											<li><a href="" class="active"></a>10</li>
											<li><a href=""></a>11</li>
										</ul> -->
									</span>
									<!-- <span class="product-color">
										<h4>Colors</h4>
										<ul class="ul-color">
											<li><a href="" class="orange"></a></li>
											<li><a href="" class="green"></a></li>
											<li><a href="" class="yellow"></a></li>
										</ul>
									</span> -->
									<br>
									<span class="product-price">
										<a href="<?php echo site_url('produk/produk_detail/').$val->slug; ?>">
											<b>Beli Sekarang</b>
										</a>
									</span>
								</div>
							</div>
						</div>

					</div>
				<?php } ?>
			</div>
	</div>
  
</div>

