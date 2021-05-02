<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> 
			<div id="hot">

                <div class="box">
                    <div class="container">
                        <div class="col-md-12">
                            <h2>Produk terbaru minggu ini</h2>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="product-slider">
                        <?php $this->db->select('
                            tbl_produk.id_produk,
                            tbl_produk.id_sub_kategori,
                            tbl_produk.nama_produk,
                            tbl_produk.harga,
                            tbl_gambar_produk.nama_gambar
                        ');
                        $this->db->from('tbl_gambar_produk');
                        $this->db->join('tbl_produk', 'tbl_gambar_produk.id_produk = tbl_produk.id_produk', 'left');
                        $this->db->where('tbl_gambar_produk.jenis_gambar', 'display');
                        $this->db->where('tbl_produk.status', '1');
                        $this->db->order_by('tbl_gambar_produk.id_gambar', 'desc');
                        $this->db->limit(5);
                        $query = $this->db->get('');?>

                        <?php foreach ($query->result() as $val) { ?>
                            <div class="item">
                                <div class="product">
                                    <div class="flip-container">
                                        <div class="flipper">
                                            <div class="front">
                                                <a href="<?php echo site_url('produk/produk_detail/').$val->id_sub_kategori."/".$val->id_produk; ?>">
                                                    <img src="<?php echo config_item('assets'); ?>img/produk/<?php echo $val->nama_gambar; ?>" alt="" class="img-responsive">
                                                </a>
                                            </div>
                                            <div class="back">
                                                <a href="<?php echo site_url('produk/produk_detail/').$val->id_sub_kategori."/".$val->id_produk; ?>">
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
                                            <a href="<?php echo site_url('produk/produk_detail/').$val->id_sub_kategori."/".$val->id_produk; ?>">
                                            <?php echo $val->nama_produk; ?></a>
                                        </h3>
                                        <p class="price">Rp. <?php echo number_format($val->harga,0,",","."); ?></p>
                                    </div>
                                    <!-- /.text -->

                                    <!-- ribbon -->
                                    <div class="ribbon new">
                                        <div class="theribbon">NEW</div>
                                        <div class="ribbon-background"></div>
                                    </div>
                                    <!-- /.ribbon -->
                                </div>
                                <!-- /.product -->
                            </div>
                        <?php } ?>

                        <!-- <div class="item">
                            <div class="product">
                                <div class="flip-container">
                                    <div class="flipper">
                                        <div class="front">
                                            <a href="detail.html">
                                                <img src="<?php echo config_item('assets'); ?>img/product2.jpg" alt="" class="img-responsive">
                                            </a>
                                        </div>
                                        <div class="back">
                                            <a href="detail.html">
                                                <img src="<?php echo config_item('assets'); ?>img/product2_2.jpg" alt="" class="img-responsive">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="detail.html" class="invisible">
                                    <img src="<?php echo config_item('assets'); ?>img/product2.jpg" alt="" class="img-responsive">
                                </a>
                                <div class="text">
                                    <h3><a href="detail.html">White Blouse Armani</a></h3>
                                    <p class="price"><del>$280</del> $143.00</p>
                                </div>
                                /.text
                        
                                <div class="ribbon sale">
                                    <div class="theribbon">SALE</div>
                                    <div class="ribbon-background"></div>
                                </div>
                                /.ribbon
                        
                                <div class="ribbon new">
                                    <div class="theribbon">NEW</div>
                                    <div class="ribbon-background"></div>
                                </div>
                                /.ribbon
                        
                                <div class="ribbon gift">
                                    <div class="theribbon">GIFT</div>
                                    <div class="ribbon-background"></div>
                                </div>
                                /.ribbon
                            </div>
                            /.product
                        </div> -->

                    </div>
                    <!-- /.product-slider -->
                </div>
                <!-- /.container -->

            </div>