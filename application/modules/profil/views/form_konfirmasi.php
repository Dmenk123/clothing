<div class="container">
   
      <ul class="breadcrumb">
         <li><a href="#">Home</a></li>
         <li><?php echo $this->uri->segment(1); ?></li>
         <li><?php echo $this->uri->segment(2); ?></li>
      </ul>
  

   <div class="col-md-12">
      <div class="box">
         <h3>Form Konfirmasi Transaksi</h3>
         <?php foreach ($hasil_header as $value): ?>
            <?php if ($value->method_checkout == "COD") { ?>
               <form method="post" enctype="multipart/form-data" id="form_konfirm_ckt_cod" name="formConfirmCktCod">
                  <?php foreach ($hasil_data as $val): ?>
                     <input type="hidden" id="crfm_id_stok" name="crfmIdStok[]" value="<?php echo $val->id_stok; ?>" readonly>
                     <input type="hidden" id="crfm_qty" name="crfmQty[]" value="<?php echo $val->qty; ?>" readonly>
                  <?php endforeach ?>
                  <div class="form-group">
                     <label>Pemilik Akun</label>
                     <input type="text" class="form-control" id="crfm_nama_krm" name="crfmNamaKrm" value="<?php echo $value->fname_user." ".$value->lname_user; ?>" readonly>
                  </div>
                  <div class="form-group">
                     <label>No Transaksi</label>
                     <input type="text" class="form-control" id="cfrm_id_checkout" name="cfrmIdCheckout" value="<?php echo $value->id_checkout; ?>" readonly>
                  </div>
                  <div class="form-group">
                     <label>Metode Pembayaran</label>
                     <input type="text" class="form-control" id="cfrm_metode" name="cfrmMetode" value="<?php echo $value->method_checkout; ?>" readonly>
                  </div>
                  <div class="form-group">
                     <label for="Nama Belakang">Kode Ref</label>
                     <input type="text" class="form-control" id="cfrm_kode_ref" name="cfrmKodeRef" value="<?php echo $value->kode_ref; ?>" readonly>
                  </div>
                  <div class="form-group">
                     <label>Dikirim Kepada</label>
                     <input type="text" class="form-control" id="cfrm_nama_krm" name="cfrmNamaKrm" value="<?php echo $value->fname_kirim." ".$value->lname_kirim; ?>" readonly>
                  </div>
                  <div class="form-group">
                     <label>Alamat Kirim</label>
                     <textarea name="cfrmAlamatKrm" class="form-control" id="cfrm_alamat_krm" cols="30" rows="3" readonly><?php echo $value->alamat_kirim;?></textarea>
                  </div>
                  <div class="form-group">
                     <label>Harga Total</label>
                     <input type="text" class="form-control" id="cfrm_harga_total" name="cfrmHargaTotal" value="Rp. <?php echo number_format($value->harga_total_produk,0,",","."); ?>" readonly>
                     <input type="hidden" class="" id="cfrm_harga_total_hdn" name="cfrmHargaTotalHdn" value="<?php echo $value->harga_total_produk; ?>" readonly>
                  </div>
                  <div class="form-check">
                     <input type="checkbox" class="form-check-input" id="cfrm_check" name="cfrmCheck" value="agree"> 
                     <label class="form-check-label" for="checkConfirm">Saya Setuju, Mohon Transaksi Saya ditindaklanjuti.</label>
                  </div>
                  <div class="text-center">
                     <input type="submit" value="Konfirmasi" id="btnConfirmCod" class="btn btn-primary"/>
                  </div>
               </form>  
            <?php } else { ?>
               <form method="post" enctype="multipart/form-data" id="form_konfirm_ckt_tfr" name="formConfirmCktTfr">
                  <?php foreach ($hasil_data as $val): ?>
                     <input type="hidden" id="crfm_id_stok" name="crfmIdStok[]" value="<?php echo $val->id_stok; ?>" readonly>
                     <input type="hidden" id="crfm_qty" name="crfmQty[]" value="<?php echo $val->qty; ?>" readonly>
                  <?php endforeach ?>
                  <div class="form-group">
                     <label>Pemilik Akun</label>
                     <input type="text" class="form-control" id="crfm_nama_krm" name="crfmNamaKrm" value="<?php echo $value->fname_user." ".$value->lname_user; ?>" readonly>
                  </div>
                  <div class="form-group">
                     <label>No Transaksi</label>
                     <input type="text" class="form-control" id="cfrm_id_checkout" name="cfrmIdCheckout" value="<?php echo $value->id_checkout; ?>" readonly>
                  </div>
                  <div class="form-group">
                     <label>Metode Pembayaran</label>
                     <input type="text" class="form-control" id="cfrm_metode" name="cfrmMetode" value="<?php echo $value->method_checkout; ?>" readonly>
                  </div>
                  <div class="form-group">
                     <label for="Nama Belakang">Kode Ref</label>
                     <input type="text" class="form-control" id="cfrm_kode_ref" name="cfrmKodeRef" value="<?php echo $value->kode_ref; ?>" readonly>
                  </div>
                  <div class="form-group">
                     <label>Dikirim Kepada</label>
                     <input type="text" class="form-control" id="cfrm_nama_krm" name="cfrmNamaKrm" value="<?php echo $value->fname_kirim." ".$value->lname_kirim; ?>" readonly>
                  </div>
                  <div class="form-group">
                     <label>Kurir, pilihan paket dan estimasi kedatangan</label>
                     <input type="text" class="form-control" id="cfrm_ekspedisi" name="cfrmEkspedisi" value="<?php echo $value->jasa_ekspedisi." - ".$value->pilihan_paket." - ".$value->estimasi_datang; ?>" readonly>
                  </div>
                  <div class="form-group">
                     <label>Alamat Kirim</label>
                     <textarea name="cfrmAlamatKrm" class="form-control" id="cfrm_alamat_krm" cols="30" rows="3" readonly><?php echo $value->alamat_kirim;?></textarea>
                  </div>
                  <div class="form-group">
                     <label>Harga Produk | Ongkir</label>
                     <input type="text" class="form-control" id="cfrm_harga_total" name="cfrmHargaTotal" value="Rp. <?php echo number_format($value->harga_total_produk,0,",",".")." | Rp. ".number_format($value->ongkos_kirim,0,",","."); ?>" readonly>
                  </div>
                  <div class="form-group">
                     <label>Harga Total</label>
                     <input type="text" class="form-control" id="cfrm_harga_total" name="cfrmHargaTotal" value="Rp. <?php echo number_format($value->ongkos_total,0,",","."); ?>" readonly>
                     <input type="hidden" class="" id="cfrm_harga_total_hdn" name="cfrmHargaTotalHdn" value="<?php echo $value->ongkos_total; ?>" readonly>
                  </div>
                  <div class="form-group">
                     <label>Bukti Transfer <strong>(Anda dapat mengupload lebih dari 1 bukti, Minimal upload 1 bukti)</strong></label>
                     <br>
                     <label><span style="color: red;font-weight: bold">Wajib Diisi !!</span>
                        <input type="file" id="cfrm_bukti1" name="crfmBukti1" accept=".png, .jpg, .jpeg"></label>
                     <br>
                     <label><span style="color: blue;">Bukti tambahan (bila Ada)</span>
                        <input type="file" id="cfrm_bukti2" name="crfmBukti2" accept=".png, .jpg, .jpeg">
                     </label>
                     <br>
                     <label><span style="color: blue;">Bukti Tambahan (Bila Ada)</span>
                        <input type="file" id="cfrm_bukti3" name="crfmBukti3" accept=".png, .jpg, .jpeg">
                     </label>
                  </div>
                  <div class="form-check">
                     <input type="checkbox" class="form-check-input" id="cfrm_check" name="cfrmCheck" value="agree"> 
                     <label class="form-check-label" for="checkConfirm">Saya Setuju, Mohon Transaksi Saya ditindaklanjuti.</label>
                  </div>
                  <div class="text-center">
                     <input type="submit" value="Konfirmasi" id="btnConfirmTfr" class="btn btn-primary"/>
                  </div>
               </form>       
            <?php } ?> 
         <?php endforeach ?>
      </div><!-- /.box -->
   </div>
</div><!-- /.container -->