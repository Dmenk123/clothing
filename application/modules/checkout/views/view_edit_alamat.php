<div class="container">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="#">Home</a></li>
         <li><?php echo $this->uri->segment(1); ?></li>
         <li>Tahapan 1 : Alamat pengiriman dan penagihan</li>
      </ul>
   </div>
   <div class="col-md-12" id="checkout">
      <div class="box">
         <form method="post" action="checkout2.html">
            <h1>Tahapan 1 : Alamat pengiriman dan penagihan</h1>
            <ul class="nav nav-pills nav-justified">
               <li class="active"><a href="#"><i class="fa fa-map-marker"></i><br>Alamat</a>
               </li>
               <li class="disabled"><a href="#"><i class="fa fa-truck"></i><br>Delivery Method</a>
               </li>
               <li class="disabled"><a href="#"><i class="fa fa-money"></i><br>Payment Method</a>
               </li>
               <li class="disabled"><a href="#"><i class="fa fa-eye"></i><br>Order Review</a>
               </li>
            </ul>

            <!-- <div class="content">
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="firstname">Firstname</label>
                        <input type="text" class="form-control" id="firstname">
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="lastname">Lastname</label>
                        <input type="text" class="form-control" id="lastname">
                     </div>
                  </div>
               </div>/.row
            
               <div class="row">
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="company">Company</label>
                        <input type="text" class="form-control" id="company">
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="street">Street</label>
                        <input type="text" class="form-control" id="street">
                     </div>
                  </div>
               </div>/.row
            
               <div class="row">
                  <div class="col-sm-6 col-md-3">
                     <div class="form-group">
                        <label for="city">Company</label>
                        <input type="text" class="form-control" id="city">
                     </div>
                  </div>
                  <div class="col-sm-6 col-md-3">
                     <div class="form-group">
                        <label for="zip">ZIP</label>
                        <input type="text" class="form-control" id="zip">
                     </div>
                  </div>
                  <div class="col-sm-6 col-md-3">
                     <div class="form-group">
                        <label for="state">State</label>
                        <select class="form-control" id="state"></select>
                     </div>
                  </div>
                  <div class="col-sm-6 col-md-3">
                     <div class="form-group">
                        <label for="country">Country</label>
                        <select class="form-control" id="country"></select>
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="phone">Telephone</label>
                        <input type="text" class="form-control" id="phone">
                     </div>
                  </div>
                  <div class="col-sm-6">
                     <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email">
                     </div>
                  </div>
               </div>/.row
            </div>/.content -->

            <div class="content">
               <div class="row">
                  <div class="col-sm-6" style="border:1px solid #ddd; padding:10px;">
                     <form action="#" id="form_edit_alamat_tagih">
                        <p style="text-align: center;"><strong>Alamat Pengiriman : </strong></p> 
                        <?php foreach ($data_user as $value) { ?>
                           <p style="text-align: center;"><?php echo $value->fname_user." ".$value->lname_user;?></p>
                           <p style="text-align: center;"><?php echo $value->alamat_user; ?></p>
                           <p style="text-align: center;"><?php echo $value->nama_kelurahan." - ".$value->nama_kecamatan; ?></p>
                           <p style="text-align: center;"><?php echo $value->nama_kota." - ".$value->nama_provinsi; ?></p>
                           <p style="text-align: center;">Indonesia - <?php echo $value->kode_pos; ?></p>
                           <p style="text-align: center;">Nomor Telp : <?php echo $value->no_telp_user; ?></p>
                           <p><strong>Catatan :</strong> Alamat penagihan merupakan alamat user pada akun ini, digunakan apabila memilih pembayaran COD (bayar pada pengiriman) hanya berlaku pada wilayah surabaya dan sekitarnya</p>
                           <input type="hidden" name="id_usr" value="<?php echo $value->id_user; ?>">
                           <input type="hidden" name="cek_step" value="step1_ok">
                        <?php } ?>
                     </form>
                     <div class="text-center">
                        <button type="submit" class="btn btn-primary" onclick="edit_alamat_tagih()">Ubah alamat penagihan</button>
                     </div>
                  </div>

                  <div class="col-sm-6" style="border:1px solid #ddd; padding:10px;">
                     <form action="#" id="form_edit_alamat_kirim">
                        <p style="text-align: center;"><strong>Alamat Pengiriman : </strong></p> 
                        <?php foreach ($data_user as $value) { ?>
                           <p style="text-align: center;"><?php echo $value->fname_user." ".$value->lname_user;?></p>
                           <p style="text-align: center;"><?php echo $value->alamat_user; ?></p>
                           <p style="text-align: center;"><?php echo $value->nama_kelurahan." - ".$value->nama_kecamatan; ?></p>
                           <p style="text-align: center;"><?php echo $value->nama_kota." - ".$value->nama_provinsi; ?></p>
                           <p style="text-align: center;">Indonesia - <?php echo $value->kode_pos; ?></p>
                           <p style="text-align: center;">Nomor Telp : <?php echo $value->no_telp_user; ?></p>
                           <p style="padding-bottom: 20px;"><strong>Catatan :</strong> Alamat pengirimian bisa berbeda apabila barang tersebut di peruntukkan kepada orang lain (misal untuk hadiah, dll)</p>
                           <input type="hidden" name="id_usr" value="<?php echo $value->id_user; ?>">
                           <input type="hidden" name="cek_step" value="step1_ok">
                        <?php } ?>
                     </form>
                     <div class="text-center">
                        <button type="submit" class="btn btn-primary" onclick="edit_alamat_kirim()">Ubah alamat pengiriman</button>
                     </div>
                  </div>
               </div><!-- /.row -->
            </div><!-- /.content -->
            
            <div class="box-footer">
               <div class="pull-left">
                  <a href="basket.html" class="btn btn-default"><i class="fa fa-chevron-left"></i>Back to basket</a>
               </div>
               <div class="pull-right">
                  <button type="submit" class="btn btn-primary">Continue to Delivery Method<i class="fa fa-chevron-right"></i>
                  </button>
               </div>
            </div>
         </form>
      </div><!-- /.box -->
   </div><!-- /.col-md-9 -->
</div><!-- /.container -->