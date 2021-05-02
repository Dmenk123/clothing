<div class="container">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="#">Home</a></li>
         <li><?php echo $this->uri->segment(1); ?></li>
         <li>Tahap 1</li>
      </ul>
   </div>
   <div class="col-md-12" id="checkout">
      <div class="box">
            <h2>Tahap 1 : Alamat tujuan serta metode pembayaran dan pengiriman</h2>
            <div class="content">
               <div class="row">
                  <!-- alamat penagihan -->
                  <div class="col-sm-6" style="border:1px solid #ddd; padding:10px;">  
                        <p style="text-align: center;"><strong>Step 1: Tentukan Alamat Pengiriman</strong></p>
                        <?php foreach ($data_user as $value) { ?>
                           <p style="text-align: center;">
                              <span id="krmIdusr" class="hidden"><?php echo $value->id_user;?></span>
                              <span id="krmFname"><?php echo $value->fname_user;?></span>
                              <span id="krmLname"><?php echo $value->lname_user;?></span>
                           </p>
                           <p style="text-align: center;">
                              <span id="krmAlamat"><?php echo $value->alamat_user; ?></span>
                           </p>
                           <p style="text-align: center;">
                              <span id="krmIdKel" class="hidden"><?php echo $value->id_kelurahan; ?></span>
                              <span id="krmKel"><?php echo $value->nama_kelurahan; ?></span> -
                              <span id="krmIdKec" class="hidden"><?php echo $value->id_kecamatan; ?></span> 
                              <span id="krmKec"><?php echo $value->nama_kecamatan; ?></span>
                           </p>
                           <p style="text-align: center;">
                              <span id="krmIdKota" class="hidden"><?php echo $value->id_kota; ?></span>
                              <span id="krmKota"><?php echo $value->nama_kota; ?></span> - 
                              <span id="krmIdProv" class="hidden"><?php echo $value->id_provinsi; ?></span>
                              <span id="krmProv"><?php echo $value->nama_provinsi; ?></span>
                           </p>
                           <p style="text-align: center;">INDONESIA - 
                              <span id="krmKdpos"><?php echo $value->kode_pos; ?></span>
                           </p>
                           <p style="text-align: center;">Nomor Telp : 
                              <span id="krmTelp"><?php echo $value->no_telp_user; ?></span>
                           </p>
                           <p><strong>Catatan :</strong> Alamat pengiriman dapat anda ubah sesuai dengan kehendak anda, dan barang akan dikirim sesuai alamat yang tertulis pada alamat pengiriman</p>
                     <div class="text-center">
                        <button class="btn btn-primary" onclick='editAlamatKirim("<?php echo $value->id_user; ?>")'>Ubah alamat penagihan</button>
                     </div>
                     <?php } ?>
                  </div>
                  <!-- Metode pengiriman -->
                  <div class="col-sm-6" style="border:1px solid #ddd; padding:10px;">
                     <p style="text-align: center;"><strong>Step 2: Tentukan Metode Pembayaran</strong></p>
                     <div class="form-group col-md-12">
                        <label for="labelMetodeBayar">Pilih Metode Bayar</label>
                        <select class="form-control" id="checkout2_byr" name="checkout2Byr" style="width: 100%;" required>
                           <option value="">-- Mohon Pilih Metode Pembayaran --</option>
                           <option value="cod">COD (Cash On Delivery - Hanya Lokasi SURABAYA)</option>
                           <option value="transfer">Transfer BNI - a/n Rizki Yuanda ( 045-075-0200 )</option>
                        </select> 
                     </div>
                  </div>
                  <!-- set ekspedisi -->
                  <div id="step3_area" class="col-sm-6" style="border:1px solid #ddd; padding:10px;">
                     <!-- <p style="text-align: center;"><strong>Step 2: Tentukan Metode Pembayaran</strong></p>
                     <div class="form-group col-md-12"> -->
                        
                     <!-- </div> -->
                  </div>
               </div><!-- /.row -->
            </div><!-- /.content -->
            
            <div class="box-footer">
               <div class="pull-left">
                  <a href="<?php echo site_url('cart'); ?>" class="btn btn-default"><i class="fa fa-chevron-left"></i>Kembali</a>
               </div>
               <div class="pull-right">
                  <form action="<?php echo site_url('checkout/summary'); ?>" method="post" name="form_summary" id="formSummary">
                     <input type="hidden" name="FIduserKrm">
                     <input type="hidden" name="FFnameKrm">
                     <input type="hidden" name="FLnameKrm">
                     <input type="hidden" name="FAlamatKrm">
                     <input type="hidden" name="FKelKrm">
                     <input type="hidden" name="FTxtKelKrm">
                     <input type="hidden" name="FKecKrm">
                     <input type="hidden" name="FTxtKecKrm">
                     <input type="hidden" name="FKotaKrm">
                     <input type="hidden" name="FTxtKotaKrm">
                     <input type="hidden" name="FProvKrm">
                     <input type="hidden" name="FTxtProvKrm">
                     <input type="hidden" name="FKdposKrm">
                     <input type="hidden" name="FTelpKrm">
                     <input type="hidden" name="FMethodKrm">
                     <input type="hidden" name="FProvKurir">
                     <input type="hidden" name="FKotaKurir">
                     <input type="hidden" name="FBeratKurir">
                     <input type="hidden" name="FNamaKurir">
                     <input type="hidden" name="FPaketKurir">
                     <input type="hidden" name="FEtdKurir">
                     <input type="hidden" name="FHargaKurir">
                     <button type="submit" class="btn btn-primary">Selanjutnya<i class="fa fa-chevron-right"></i>
                     </button>
                  </form>
               </div>
            </div>
      </div><!-- /.box -->
   </div><!-- /.col-md-9 -->
</div><!-- /.container -->