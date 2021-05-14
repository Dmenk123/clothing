<div class="container">
    <div class="col-md-12">
       
        <!-- *** BOX INFO BAR *** -->
        <div class="box info-bar">
            <div class="row">
				<!-- <div class="col-md-12">
					<form class="navbar-form" role="search" action="<?= base_url('produk/katalog'); ?>" method="get">
						<div class="form-group" style="width: 100%;">
							<input type="text" class="form-control" placeholder="Temukan Produk Anda disini ......" name="key" style="width: 95%;" value="<?=$this->input->get('key');?>">
							<button type="submit" class="btn btn-primary form-control"><i class="fa fa-search"></i></button>
						</div>
					</form>
				</div> -->
                <div class="col-sm-12 col-md-4 products-showing">
                    <?php 
                        $hitung_hasil = count($results);
                        //print_r($hitung_hasil);
                        //load config pagination value
                        $per_page = $this->pagination->per_page;
                        if ($per_page >= $total_baris) {
                            $per_page = $hitung_hasil;
                        }
						
                        if ($per_page == 0) {
                            $total_baris = 0;
                        }
                     ?>
                    <?php echo "Menampilkan "."<strong>".$per_page."</strong>"." dari total "."<strong>".$total_baris."</strong>"." produk "; ?>
                </div>

                <div class="col-sm-12 col-md-8  products-number-sort">
                    <div class="row">
                        <form class="form-inline">
                            <div class="col-md-6 col-sm-6">
                                <div class="products-number">
                                    <select name="show-by" class="form-control" id="select_show" style="width: 100%;">
                                        <option value="6">Tampilkan : 6</option>
                                        <option value="12">Tampilkan : 12</option>
                                        <option value="18">Tampilkan : 18</option>
										<option value="24">Tampilkan : 24</option>
										<option value="30">Tampilkan : 30</option>
                                    </select>
                                </div>
                                <div class="hidden">
                                    <span id="id_show"> <?php echo $id_show; ?></span>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="products-sort-by">
                                    <select name="sort-by" class="form-control" id="select_sort" style="width: 100%;">
                                        <option value="created">Urut berdasarkan : Terbaru</option>
                                        <option value="harga">Urut berdasarkan : Harga</option>
                                        <option value="nama_produk">Urut berdasarkan : Nama</option>
                                    </select>
                                </div>
                                <div class="hidden">
                                    <span id="id_sort"> <?php echo $id_sort; ?></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- *** END BOX INFO BAR *** -->

        <!-- *** ROW PRODUCT *** -->
        <div class="container" id="tampilan-pc">
        <div class="col-md-12 row products">
				<?php foreach ($results as $val) { ?>
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
		
			<div class="col-sm-12 row products" style="display:flex;flex-wrap:wrap;padding-left:0px!important;padding-right:0px!important;">
				<?php foreach ($results as $val) { ?>
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
        <!-- /.products -->

        <!-- pages -->
        <div class="pages">
            <ul class="pagination">
            <?php foreach ($links as $link) {
                echo "<li>". $link."</li>";
            } ?>
            </ul>
        </div>
        <!-- /.pages -->
    </div>
    <!-- /.col-md-9 -->
</div>
<!-- /.container -->
