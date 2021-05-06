<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> 
			<div id="hot">

                <div class="box">
                    <div class="container">
                        <div class="col-md-12">
                            <h2>Produk terbaru minggu ini</h2>
                        </div>
                        <div class="feature-row" style="margin-bottom:60px;">
                            <div class="feature-row__item">
                            
                                
                                
                        <style>#FeatureRowImage-feature-row {
                            max-width: 817.5px;
                            max-height: 545px;
                        }

                        #FeatureRowImageWrapper-feature-row {
                            max-width: 817.5px;
                        }
                        </style>

                                <div id="FeatureRowImageWrapper-feature-row" class="feature-row__image-wrapper js">
                                <div style="padding-top:66.66666666666666%;">
                                    <img id="FeatureRowImage-feature-row" class="feature-row__image lazyautosizes lazyloaded" data-widths="[180, 360, 540, 720, 900, 1080, 1296, 1512, 1728, 2048]" data-aspectratio="1.5" data-sizes="auto" alt="" data-srcset="//cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_180x.jpg?v=1612791388 180w, //cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_360x.jpg?v=1612791388 360w, //cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_540x.jpg?v=1612791388 540w, //cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_720x.jpg?v=1612791388 720w, //cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_900x.jpg?v=1612791388 900w, //cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_1080x.jpg?v=1612791388 1080w, //cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_1296x.jpg?v=1612791388 1296w, //cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_1512x.jpg?v=1612791388 1512w, //cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_1728x.jpg?v=1612791388 1728w, //cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_2048x.jpg?v=1612791388 2048w" sizes="545px" srcset="//cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_180x.jpg?v=1612791388 180w, //cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_360x.jpg?v=1612791388 360w, //cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_540x.jpg?v=1612791388 540w, //cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_720x.jpg?v=1612791388 720w, //cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_900x.jpg?v=1612791388 900w, //cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_1080x.jpg?v=1612791388 1080w, //cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_1296x.jpg?v=1612791388 1296w, //cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_1512x.jpg?v=1612791388 1512w, //cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_1728x.jpg?v=1612791388 1728w, //cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_2048x.jpg?v=1612791388 2048w">
                                </div>
                                </div>

                                <noscript>
                                <img src="//cdn.shopify.com/s/files/1/0528/1975/5157/files/beautiful-girl-face-perfect-skine_600x600@2x.jpg?v=1612791388" alt="" class="feature-row__image" />
                                </noscript>
                            
                            </div>
                        
                            

                            <div class="feature-row__item feature-row__text feature-row__text--left">
                            
                                <h2 class="h3">Maintain your sweetness</h2>
                            
                            
                                <div class="rte rte-setting featured-row__subtext"><p>Life's goal is a flower of which sweetness is Honey.</p><p>Welcome to our store, Honey and Bath, your solution for beauty and wellness products.</p></div>
                            
                            
                            </div>

                            
                        </div>

                        <!-- produk -->
                        <div class="product-slider">
                        <?php $this->db->select('
                            tbl_produk.id_produk,
                            tbl_produk.id_sub_kategori,
                            tbl_produk.nama_produk,
                            tbl_produk.harga,
							tbl_produk.slug,
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
                                            <?php echo $val->nama_produk; ?></a>
                                        </h3>
                                        <p class="price">Rp. <?php echo number_format($val->harga,0,",","."); ?></p>
										<p class="buttons">
											<a href="<?php echo site_url('produk/produk_detail/').$val->slug; ?>" class="btn btn-primary">Beli Sekarang</a>
										</p>
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
                        <!-- produk -->
                     
                    </div>
                </div>

             
                <!-- /.container -->

            </div>
