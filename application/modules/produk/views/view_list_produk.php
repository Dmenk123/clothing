<div class="container">
    <div class="col-md-12">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('home'); ?>">Home </a></li>
            <li><?php echo $this->uri->segment('1'); ?></li>
            <li><?php foreach ($get_data_page as $row) { echo $row->nama_sub_kategori; } ?></li>
        </ul>
    </div>

    <div class="col-md-3">
    <!-- *** SIDEBAR MENUS AND FILTERS *** -->
    <?php 
        if (isset($content_sidebar)) 
        {
            $this->load->view($content_sidebar); 
        } 
    ?>
    </div>
    <!-- *** SIDEBAR MENUS AND FILTERS END *** -->    
        
    <div class="col-md-9">
        <div class="box">
            <?php foreach ($get_data_page as $value) { ?>
               <h1>Produk <?php echo $value->nama_sub_kategori;?></h1>
                    <p>Berbagai pilihan produk <?php echo $value->nama_sub_kategori;?> murah dan berkualitas yang tersedia, pliih gambar untuk detail produk.</p>
            <?php } ?>
        </div>

        <!-- *** BOX INFO BAR *** -->
        <div class="box info-bar">
            <div class="row">
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
                                        <option value="10">Tampilkan : 10</option>
                                        <option value="25">Tampilkan : 25</option>
                                        <option value="50">Tampilkan : 50</option>
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
                    <a href="<?php echo site_url('produk/produk_detail/').$val->id_sub_kategori.'/'.$val->id_produk; ?>">
                        <?php $link_img = $val->nama_gambar; ?>
                            <img src="<?php echo site_url('assets/img/produk/'.$link_img.''); ?>" alt="" class="img-responsive">
                    </a>
                    <div class="text">
                        <p style="text-align: center; font-size: 16px;"><a href="<?php echo site_url('produk/produk_detail/').$val->id_sub_kategori.'/'.$val->id_produk; ?>" style="color: black;"><?php echo $val->nama_produk; ?></a></p>
                        <p class="price"><strong>Rp. <?php echo number_format($val->harga,0,",","."); ?></strong></p>
                        <!-- <p class="buttons">
                            <a href="<?php echo site_url('produk/produk_detail/').$val->id_sub_kategori.'/'.$val->id_produk; ?>" class="btn btn-primary">Beli Sekarang</a>
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