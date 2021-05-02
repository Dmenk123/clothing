<div class="container">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="#">Home</a>
         </li>
         <li><?php echo $this->uri->segment(1); ?></li>
      </ul>
   </div><!-- /.col -->

   <div class="col-md-6">
      <div class="box">
         <h1>Register</h1>
         <p class="lead">Anda apakah saat ini belum memiliki akun ?</p>
         <p>Silahkan daftar akun baru untuk memulai belanja, dan dapatkan keuntungan dengan mendapatkan diskon yang menarik</p>
         <p class="text-muted">Jika terdapat masalah atau pertanyaan, mohon hubungi ke <a href="<?php echo site_url('kontak'); ?>">kontak kami</a>, Kami dengan senang hati siap membantu anda.</p>
         <hr>
         <form id="form_register" method="POST" name="formRegister" enctype="multipart/form-data">   
            <div class="form-group">
               <label for="Nama Depan">Nama Depan*</label>
               <input type="text" class="form-control" id="regNama" name="reg_nama">
            </div>
            <div class="form-group">
               <label for="Nama Belakang">Nama Belakang</label>
               <input type="text" class="form-control" id="regNamaBlkg" name="reg_nama_blkg">
            </div>
            <div class="form-group">
               <label for="Nomor telepon">Nomor Telp*</label>
               <input type="text" class="form-control numberinput" id="regTelp" name="reg_telp" placeholder="contoh : 081234567890">
            </div>
            <div class="form-group">
               <label for="Email">Email*</label>
               <input type="email" class="form-control" id="regEmail" name="reg_email" placeholder="anda@domain.com">
            </div>
            <div class="form-group">
               <label for="Password">Password*</label>
               <input type="password" class="form-control" id="regPassword" name="reg_password">
            </div>
            <div class="form-group">
               <label for="Retype Password">Tulis Ulang Password*</label>
               <input type="password" class="form-control" id="regRePassword" name="reg_re_password">
               <span id='message'></span>
            </div>
            <div class="form-group">
               <label for="Tanggal Lahir">Tgl Lahir*</label>
               <input type="text" class="form-control" id="regTglLahir" name="reg_tgl_lahir" placeholder="DD-MM-YYYY">
            </div>
            <div class="form-group">
               <label for="Provinsi tempat tinggal">Provinsi Tempat tinggal*</label>
               <select class="form-control" id="regProvinsi" name="reg_provinsi" style="width: 100%;"></select>
            </div>
            <div class="form-group">
               <label for="Alamat tempat tinggal">Kota/Kabupaten Tempat tinggal*</label>
               <select class="form-control" id="regKota" name="reg_kota" style="width: 100%;"></select>
            </div>
            <div class="form-group">
               <label for="Kecamatan tempat tinggal">Kecamatan Tempat tinggal*</label>
               <select class="form-control" id="regKecamatan" name="reg_kecamatan" style="width: 100%;"></select>
            </div>
            <div class="form-group">
               <label for="Kelurahan tempat tinggal">Kelurahan/Desa Tempat tinggal*</label>
               <select class="form-control" id="regKelurahan" name="reg_kelurahan" style="width: 100%;"></select>
            </div>
            <div class="form-group">
               <label for="Alamatss tempat tinggal">Alamat Tempat tinggal*</label>
               <textarea class="form-control" id="regALamat" name="reg_alamat"></textarea>
            </div>
            <div class="form-group">
               <label for="Kode Pos">Kode Pos*</label>
               <input type="text" class="form-control" id="regKodePos" name="reg_kode_pos">
            </div>
            <div class="form-group">
               <label for="Foto Profil">Foto Profil</label>
               <input type="file" id="regFotoProfil" name="reg_foto_profil" accept=".png, .jpg, .jpeg">
            </div>
            <div class="form-group">
               <label for="Kode Pos">Captcha* (Case sensitive - Besar kecil huruf berpengaruh)</label>
               <p>
                  <span id="imgCaptcha"><?php echo $img; ?></span> 
                  <a href="javascript:void(0);" class="refreshCaptcha">[Kode Tidak Jelas]</a>
               </p>
               <input type="text" class="form-control" id="regCaptcha" name="reg_captcha">
            </div>
            <div class="form-group">
               <label for="Wajib Diisi"><strong>Keterangan : (*) Wajib diisi.</strong></label>
            </div>
            <div class="text-center">
               <input type="submit" value="Register" id="btnRegister" class="btn btn-primary"/>
            </div>
         </form>
         
      </div><!-- /.box -->
   </div><!-- /.col -->

   <div class="col-md-6">
      <div class="box">
         <h1>Login</h1>
         <p class="lead">Sudah memiliki akun ?</p>
         <p class="text-muted">Silahkan mengisi email dan password anda pada form yang tersedia untuk mulai belanja.</p>
         <hr>
         <form id="form_login2" action="#">
            <div class="form-group">
               <label for="email">Email</label>
               <input type="text" class="form-control" id="email-modal" name="emailModal" placeholder="email">
            </div>
            <div class="form-group">
               <label for="password">Password</label>
               <input type="password" class="form-control" id="password-modal" name="passwordModal" placeholder="password">
            </div>
         </form>   
         <div class="text-center">
            <button class="btn btn-primary" onclick="login_proc2()"><i class="fa fa-sign-in"></i> Log in</button>
         </div>
      </div><!-- /.box -->
   </div><!-- /.col -->
</div><!-- /.container -->