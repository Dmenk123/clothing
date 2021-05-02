<div class="container">
    <div class="col-md-12">
        <ul class="breadcrumb">
            <li><a href="<?php echo site_url('home'); ?>">Home </a></li>
            <li><?php echo $this->uri->segment('1'); ?></li>
            <li><?php echo $this->uri->segment('2'); ?></li>
        </ul>
    </div>
        
    <div class="col-md-12" id="basket">
        <div class="box">
                <h1>Detail Belanja Anda</h1>
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
                            </tr>
                        </thead>
                        <tbody id="show_detail">
                        <?php foreach ($this->cart->contents() as $items) { ?>
                            <?php $link_img = $items['options']['Gambar_produk'];  ?>
                            <tr>
                                <td><img src="<?php echo site_url("assets/img/produk/$link_img"); ?>"></td>
                                <td><?php echo $items['name']; ?></td>
                                <td><?php echo $items['options']['Size_produk']; ?></td>
                                <td><?php echo $items['qty']; ?></td>
                                <td><?php echo $items['options']['Berat_produk']; ?> gram</td>
                                <td><?php echo $items['options']['Berat_produk'] * $items['qty']; ?> gram</td>
                                <td>Rp. <?php echo number_format($items['price'],0,",","."); ?></td>
                                <td>Rp. <?php echo number_format($items['subtotal'],0,",","."); ?></td>
                            </tr>
                        <?php } ?>

                        <?php 
                            foreach($this->cart->contents() as $item)
                            {
                               $beratTotal += $item['options']['Berat_produk'] * $item['qty'];
                            }
                        ?>
                            <tr>
                                <th colspan="5">Berat Total Produk</th>
                                <td colspan="4"><?php echo number_format($beratTotal,0,",","."); ?> gram </td>
                            </tr>
                            <tr>
                                <th colspan="7"><span style="font-size:20px;">Total Harga Produk</span></th>
                                <td colspan="2">
                                    <span style="font-size:20px; text-decoration:underline;">
                                        Rp. <?php echo number_format($this->cart->total(),0,",","."); ?>
                                    </span>
                                </td>
                            </tr>

                            <?php if ($data_input['method_krm'] == 'cod') { ?>
                            <tr>
                                <th colspan="3">Metode Pembayaran</th>
                                <td colspan="6">COD (Cash On Delivery)</td>
                            </tr>
                            <tr>    
                                <th colspan="3">Pengiriman Atas Nama</th>
                                <td colspan="6"><?php echo $data_input['fname_krm']." ".$data_input['lname_krm'];?></td>
                            </tr>
                            <tr>    
                                <th colspan="3">Alamat Pengiriman</th>
                                <td colspan="6"><?php echo $data_input['alamat_krm'].", ".$data_input['nm_kel_krm']." - ".$data_input['nm_kec_krm'].", ".$data_input['nm_kota_krm']." - ".$data_input['nm_prov_krm']; ?></td>
                            </tr>
                            <tr>                                    
                                <th colspan="7">Ongkos Kirim (Free biaya kirim)</th>
                                <td colspan="2">Rp.  </td>  
                            </tr>
                            <tr>                                    
                                <th colspan="7"><span style="font-size:20px;">Total Keseluruhan</span></th>
                                <th>
                                    <span style="font-size:20px; text-decoration:underline;">
                                        Rp. <?php echo number_format($this->cart->total(),0,",","."); ?>
                                    </span>
                                </th>  
                            </tr>
                            <?php }else { ?>
                            <tr>
                                <th colspan="3">Metode Pembayaran</th>
                                <td colspan="6"><strong>TRANSFER BNI a/n RIZKI YUANDA | No: 5264-2201-4152-9366</strong></td>
                            </tr>
                            <tr>
                                <th colspan="3">Kode Refrensi Transaksi (Kode ini digunakan saat konfirmasi pembayaran)</th>
                                <td colspan="6"><strong><?php echo $data_input['no_ref']; ?></strong></td>
                            </tr>
                            <tr>    
                                <th colspan="3">Pengiriman Atas Nama</th>
                                <td colspan="6"><?php echo $data_input['fname_krm']." ".$data_input['lname_krm'];?></td>
                            </tr>
                            <tr>    
                                <th colspan="3">Alamat Pengiriman</th>
                                <td colspan="6"><?php echo $data_input['alamat_krm'].", ".$data_input['nm_kel_krm']." - ".$data_input['nm_kec_krm'].", ".$data_input['nm_kota_krm']." - ".$data_input['nm_prov_krm']; ?></td>
                            </tr>
                            <tr>
                                <th colspan="3">Jasa Ekspedisi</th>
                                <td colspan="6"><?php echo strtoupper($data_input['nama_kurir']); ?></td>
                            </tr>
                            <tr>
                                <th colspan="3">Pilihan Paket</th>
                                <td colspan="6"><?php echo strtoupper($data_input['paket_kurir']); ?></td>
                            </tr>
                            <tr>    
                                <th colspan="3">Estimasi Kedatangan Barang (TIKI & JNE menggunakan satuan hari)</th>
                                <td colspan="6"><?php echo $data_input['etd_kurir']; ?></td>
                            </tr>
                            <tr>    
                                <th colspan="7">Harga Pengiriman</th>
                                <td colspan="2">
                                    <?php if ($data_input['harga_kurir'] != null) { ?>
                                        <span style="font-size:20px; text-decoration:underline;">
                                            Rp. <?php echo number_format($data_input['harga_kurir'],0,",","."); ?>
                                        </span>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="7"><span style="font-size:20px;">Total Keseluruhan</span></th>
                                <th>
                                    <span style="font-size:20px; text-decoration:underline;">
                                        Rp. <?php echo number_format($this->cart->total() + $data_input['harga_kurir'],0,",","."); ?>
                                    </span>
                                </th>
                            </tr>    
                            <?php } ?>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->

                <form id="form_checkout2" action="#">
                    <input type="hidden" class="form-control" name="frmIduser" value="<?php echo $data_input['iduser_krm']; ?>">
                    <input type="hidden" class="form-control" name="frmBeaProduk" value="<?php echo $this->cart->total(); ?>">
                    <input type="hidden" class="form-control" name="frmMethod" value="<?php echo $data_input['method_krm']; ?>">
                    <input type="hidden" class="form-control" name="frmRef" value="<?php echo $data_input['no_ref']; ?>">
                    <input type="hidden" class="form-control" name="frmKurir" value="<?php echo $data_input['nama_kurir']; ?>">
                    <input type="hidden" class="form-control" name="frmPaket" value="<?php echo $data_input['paket_kurir']; ?>">
                    <input type="hidden" class="form-control" name="frmEtd" value="<?php echo $data_input['etd_kurir']; ?>">
                    <input type="hidden" class="form-control" name="frmOngkir" value="<?php echo $data_input['harga_kurir']; ?>">
                    <input type="hidden" class="form-control" name="frmBeaTotal" value="<?php echo $this->cart->total() + $data_input['harga_kurir']; ?>">
                    <input type="hidden" class="form-control" name="frmFnameKrm" value="<?php echo $data_input['fname_krm']; ?>">
                    <input type="hidden" class="form-control" name="frmLnameKrm" value="<?php echo $data_input['lname_krm']; ?>">
                    <input type="hidden" class="form-control" name="frmAlamatKrm" value="<?php echo $data_input['alamat_krm'].", ".$data_input['nm_kel_krm']." - ".$data_input['nm_kec_krm'].", ".$data_input['nm_kota_krm']." - ".$data_input['nm_prov_krm']; ?>">
                    <?php foreach ($this->cart->contents() as $items) { ?>
                        <input type="hidden" class="form-control" name="rowId[]" value="<?php echo $items['rowid']; ?>">
                        <input type="hidden" class="form-control" name="frmIdproduk[]" value="<?php echo $items['id']; ?>">
                        <input type="hidden" class="form-control" name="frmIdsatuan[]" value="<?php echo $items['options']['Id_satuan_produk']; ?>">
                        <input type="hidden" class="form-control" name="frmIdstok[]" value="<?php echo $items['options']['Id_stok_produk']; ?>">
                        <input type="hidden" class="form-control" name="frmIdqty[]" value="<?php echo $items['qty']; ?>">
                    <?php } ?>
                </form>
                <div class="box-footer">
                    <div class="pull-left">
                        <a href="<?php echo site_url('checkout') ?>" class="btn btn-default"><i class="fa fa-chevron-left"></i> Kembali</a>
                    </div>
                    <div class="pull-right">
                        <button type="button" class="btn btn-primary" onclick="proses_pembayaran()">Selesai<i class="fa fa-chevron-right"></i></button>
                    </div>
                </div>
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
                      
</div><!-- /.container -->