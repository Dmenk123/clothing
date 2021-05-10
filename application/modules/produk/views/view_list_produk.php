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
        <div class="row products">
            <?php foreach ($results as $val) { ?>
            <div class="col-md-4 col-sm-6">
                <div class="product">
                    <a href="<?php echo site_url('produk/produk_detail/').$val->slug; ?>">
                        <?php $link_img = $val->nama_gambar; ?>
                            <img src="<?php echo site_url('assets/img/produk/'.$link_img.''); ?>" alt="" class="img-responsive">
                    </a>
                    <div class="text">
                        <p style="text-align: center; font-size: 16px;"><a href="<?php echo site_url('produk/produk_detail/').$val->slug; ?>" style="color: black;"><?php echo $val->nama_produk; ?></a></p>
                        <p class="price"><strong>Rp. <?php echo number_format($val->harga,0,",","."); ?></strong></p>
                        <!-- <p class="buttons">
                            <a href="<?php echo site_url('produk/produk_detail/').$val->slug; ?>" class="btn btn-primary">Beli Sekarang</a>
                        </p> -->
                    </div>
                    <!-- /.text -->
                </div>
                <!-- /.product -->
            </div>
            <?php } ?>
            <!-- /.col -->
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
