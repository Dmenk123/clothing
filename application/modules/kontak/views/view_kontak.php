<div class="container">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="#">Home</a></li>
         <li><?php echo $this->uri->segment(1); ?></li>
      </ul>

   </div>

   <div class="col-md-12">
      <div class="box" id="contact">
         <h1>Kontak kami</h1>
         <p class="lead">Apakah anda mempunyai kritik dan saran ? atau terdapat masalah pada produk kami ?</p>
         <p>Mohon hubungi kami, segala masukkan dari anda sangat berharga buat kami.</p>
         <hr>
         <div class="row">
            <div class="col-sm-4">
               <h3><i class="fa fa-map-marker"></i> Alamat kami</h3>
                  <p>Jalan Ngagel tirto Gg II-B no 6
                     <br>Kelurahan Ngagel Rejo
                     <br>Kecamatan Wonokromo
                     <br>Surabaya - Jawa Timur
                     <br>60245
                     <br>
                     <strong>Indonesia</strong>
                  </p>
            </div><!-- /.col-sm-4 -->
            <div class="col-sm-4">
               <h3><i class="fa fa-phone"></i> Call / Whatsapp</h3>
               <p class="text-muted">Anda dapat menghubungi / chat via Whatsapp pada nomor dibawah ini : </p>
               <p><strong>+6281-703-403-470</strong></p>
            </div><!-- /.col-sm-4 -->
            <div class="col-sm-4">
               <h3><i class="fa fa-envelope"></i> Email</h3>
               <p class="text-muted">Anda dapat menghubungi kami pada email dibawah ini : </p>
               <p><strong><a href="mailto:">rizkiyuandaa@gmail.com</a></strong></p>
            </div><!-- /.col-sm-4 -->
         </div><!-- /.row -->
         <hr>
         <div id="map">
            <?php echo $map['html'];?>
         </div>
         
         <hr>
         <h2>Form Kritik / Saran</h2>
         <p class="text-muted">Silahkan beri masukan ataupun terdapat masalah pada produk kami pada form dibawah, kami akan membalas masukkan anda pada email anda.</p>
         <div class="row">
            <form id="form_kontak" name="formPesan" action="#">
               <div class="col-sm-12">
                  <div class="form-group">
                     <label for="firstname">Nama depan*</label>
                     <input type="text" class="form-control" id="firstname" name="msg_fname">
                  </div>
               </div>
               <div class="col-sm-12">
                  <div class="form-group">
                     <label for="lastname">Nama belakang</label>
                     <input type="text" class="form-control" id="lastname" name="msg_lname">
                  </div>
               </div>
               <div class="col-sm-12">
                  <div class="form-group">
                     <label for="email">Email*</label>
                     <input type="text" class="form-control" id="email" name="msg_email">
                  </div>
               </div>
               <div class="col-sm-12">
                  <div class="form-group">
                     <label for="subject">Subjek pesan*</label>
                     <input type="text" class="form-control" id="subject" name="msg_subject">
                  </div>
               </div>
               <div class="col-sm-12">
                  <div class="form-group">
                     <label for="message">Pesan*</label>
                     <textarea id="message" class="form-control" name="msg_message"></textarea>
                  </div>
               </div>
            </form>
            <div class="col-sm-12 text-center">
               <button type="submit" onclick="kirim_pesan_proc()" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Kirim Pesan</button>
            </div>
         </div><!-- /.row -->
         
      </div>
   </div><!-- /.col-md-9 -->
</div><!-- /.container -->