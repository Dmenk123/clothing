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
                        <h1 class="text-center"><a href="#details" class="scroll-to"><?php echo $val->nama_produk; ?></a></h1>
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
                            <select class="form-control selectQty" id="qty_<?php echo $val->id_produk;?>" name="select_qty" required>
                                <option value="">Pilih Qty Produk</option>
                            </select>
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
        <div class="container">
            <div class="col-md-12">
                <h2 class="text-center">Produk Rekomendasi</h2>
            </div>
        </div>
    </div>

        
    <div class="container">
        <div class="product-slider">
            <?php foreach ($produk_terlaris as $val): ?>
                <div class="item">    
                    <div class="product">
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
							<!-- <p class="buttons">
								<a href="<?php echo site_url('produk/produk_detail/').$val->slug; ?>" class="btn btn-primary">Beli Sekarang</a>
							</p> -->
                        </div>
                    </div><!-- /.product -->
                </div>                
            <?php endforeach ?>
        </div>
    </div>  

</div>

