<div class="container">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="#">Home</a></li>
         <li><?php echo $this->uri->segment(1); ?></li>
         <li><?php echo $this->uri->segment(2); ?></li>
      </ul>

   </div>

   <div class="col-md-12">
      <div class="box" id="checkout_detail">
         <div class="box-body">
              <div class="table-responsive">
                <?php foreach ($hasil_header as $val ) : ?>
                <div class="col-xs-12">
                  <h2 style="text-align: center;"><strong>Detail Transaksi</strong></h2>
                </div>
                <div class="col-xs-4">
                  <h5 style="text-align: left;">Nama User : <?php echo $val->fname_user." ".$val->lname_user; ?></h5>
                  <h5 style="text-align: left;">Kode Ref : <?php echo $val->kode_ref; ?></h5>
                </div>
                <div class="col-xs-4">
                  <h4 style="text-align: center;">Tanggal Transaksi: <?php echo date("d-m-Y", strtotime($val->tgl_checkout)); ?></h4>
                </div>
                <div class="col-xs-4">
                  <?php if ($val->method_checkout == "COD") { ?>
                     <h5 style="text-align: right;">Metode Pembayaran: Cash On Delivery</h5>
                  <?php } else { ?>
                     <h5 style="text-align: right;">Metode Pembayaran: Transfer</h5>
                     <h5 style="text-align: right;">Kurir: <?php echo $val->jasa_ekspedisi." - ".$val->pilihan_paket." - ".$val->estimasi_datang; ?></h5>
                  <?php } ?>
                </div>
                <div class="col-xs-12">
                   <h5 style="text-align: left;">Alamat Kirim : <?php echo $val->alamat_kirim; ?></h5>
                </div>
                <?php endforeach ?>
                  <table id="tabelCheckoutDetail" class="table table-bordered table-hover" border="1" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th style="width: 30px; text-align: center;">No</th>
                        <th style="width: 50px; text-align: center;">Kode</th>
                        <th style="width: 200px; text-align: center;">Nama Produk</th>
                        <th style="width: 60px; text-align: center;">Satuan</th>
                        <th style="width: 30px; text-align: center;">Size</th>
                        <th style="width: 50px; text-align: center;">Berat</th>
                        <th style="width: 50px; text-align: center;">Harga Satuan</th>
                        <th style="width: 30px; text-align: center;">Qty</th>
                        <th style="width: 50px; text-align: center;">Harga Total</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $no = 1; ?>
                        <?php foreach ($hasil_data as $val ) : ?>
                        <tr>
                          <td><?php echo $no++; ?></td> 
                          <td><?php echo $val->id_produk; ?></td>
                          <td><?php echo $val->nama_produk; ?></td>
                          <td><?php echo $val->nama_satuan; ?></td>
                          <td><?php echo $val->ukuran_produk; ?></td>
                          <td><?php echo $val->berat_satuan; ?> gram</td>
                          <td><?php echo "Rp. ".number_format($val->harga,0,",","."); ?></td>
                          <td><?php echo $val->qty; ?></td>
                          <td><?php echo "Rp. ".number_format($val->harga * $val->qty,0,",","."); ?></td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                  </table>
                  <div style="padding-top: 30px; padding-bottom: 10px;">
                    <p class="text-muted"><strong>Catatan :</strong> Mohon transaksi ini dikonfirmasi agar dapat kami tindak lanjuti, Terima Kasih.</p>
                    <a class="btn btn-sm btn-danger" title="Kembali" onclick="javascript:history.back()">
                      <i class="fa fa-arrow-left"></i> Kembali
                    </a>

                    <?php foreach ($hasil_header as $value): ?>
                      <?php $link = $value->id_checkout;  ?>
                    <?php endforeach ?>

                    <a class="btn btn-sm btn-primary" title="Konfirmasi" 
                    href="<?php echo site_url('profil/konfirmasi_checkout/'.$link); ?>"><i class="fa fa-check-square-o"></i> Konfirmasi</a>
                  </div>
              </div>  
            </div>
            <!-- /.box-body -->
      </div><!-- /.box -->
   </div><!-- /.col-md-9 -->
</div><!-- /.container -->