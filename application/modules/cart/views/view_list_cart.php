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
            <div class="col-md-3 col-sm-6">
                <div class="box same-height">
                    <h3>You may also like these products</h3>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="product same-height">
                    <div class="flip-container">
                        <div class="flipper">
                            <div class="front">
                                <a href="detail.html">
                                    <img src="img/product2.jpg" alt="" class="img-responsive">
                                </a>
                            </div>
                            <div class="back">
                                <a href="detail.html">
                                    <img src="img/product2_2.jpg" alt="" class="img-responsive">
                                </a>
                            </div>
                        </div>
                    </div>
                    <a href="detail.html" class="invisible">
                        <img src="img/product2.jpg" alt="" class="img-responsive">
                    </a>
                    <div class="text">
                        <h3>Fur coat</h3>
                            <p class="price">$143</p>
                    </div>
                </div><!-- /.product -->
            </div>
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