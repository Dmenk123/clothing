<div class="container">
   
      <ul class="breadcrumb">
         <li><a href="#">Home</a></li>
         <li><?php echo $this->uri->segment(1); ?></li>
         <li><?php echo $this->uri->segment(2); ?></li>
      </ul>
  

   <div class="col-md-12">
         <form method="post" enctype="multipart/form-data" id="form_update_profil" name="formUpdateProfil">
         <div class="form-group col-md-12">
            <h2>Edit Data Profil User</h2>
         </div>
         <?php if (isset($data_user)) { ?>
            <input type="hidden" class="form-control" id="idUser" name="frm_id_user" value="<?php echo $data_user->id_user; ?>">  
            <div class="form-group col-md-6">
               <label class="lblFnameErr">Nama Depan*</label>
               <input type="text" class="form-control" id="fname_user" name="frm_fname_user" value="<?php echo $data_user->fname_user; ?>">
            </div>
            <div class="form-group col-md-6">
               <label class="lblLnameErr">Nama Belakang</label>
               <input type="text" class="form-control" id="lname_user" name="frm_lname_user" value="<?php echo $data_user->lname_user; ?>">
            </div>
            <div class="form-group col-md-6">
               <label class="lblEmailErr">Email*</label>
               <input type="email" class="form-control" id="email_user" name="frm_email_user" value="<?php echo $data_user->email; ?>">
               <input type="hidden" id="email_hdn" value="<?php echo $data_user->email; ?>">
            </div>
            <div class="form-group col-md-6">
               <label class="lblPassErr">Password*</label>
               <input type="text" class="form-control" id="pass_user" name="frm_pass_user" value="<?php echo $data_user->password; ?>">
            </div>
            <div class="form-group col-md-6">
               <label class="lblTgllhrErr">Tgl Lahir*</label>
               <input type="text" class="form-control" id="tgllhr_user" name="frm_tgllhr_user">
            </div>
            <div class="form-group col-md-6">
               <label class="lblTelpErr">Nomor Telp*</label>
               <input type="text" class="form-control numberinput" id="telp_user" name="frm_telp_user" value="<?php echo $data_user->no_telp_user; ?>">
            </div>
            <div class="form-group col-md-6">
               <label class="lblProvErr">Provinsi Tempat tinggal*</label>
               <select class="form-control" id="prov_user" name="frm_prov_user" style="width: 100%;"></select>
            </div>
            <div class="form-group col-md-6">
               <label class="lblKotaErr">Kota/Kabupaten Tempat tinggal*</label>
               <select class="form-control" id="kota_user" name="frm_kota_user" style="width: 100%;"></select>
            </div>
            <div class="form-group col-md-6">
               <label class="lblKecErr">Kecamatan Tempat tinggal*</label>
               <select class="form-control" id="kec_user" name="frm_kec_user" style="width: 100%;"></select>
            </div>
            <div class="form-group col-md-6">
               <label class="lblKelErr">Kelurahan/Desa Tempat tinggal*</label>
               <select class="form-control" id="kel_user" name="frm_kel_user" style="width: 100%;"></select>
            </div>
            <div class="form-group col-md-12">
               <label class="lblAlamatErr">Alamat Tempat tinggal*</label>
               <textarea class="form-control" id="alamat_user" name="frm_alamat_user" style="width: 100%;"><?php echo $data_user->alamat_user; ?></textarea>
            </div>
            <div class="form-group col-md-6">
               <label class="lblKdposErr">Kode Pos*</label>
               <input type="text" class="form-control numberinput" id="kode_pos" name="frm_kode_pos" value="<?php echo $data_user->kode_pos; ?>">
            </div>
            <div class="form-group col-md-6">
               <label class="lblFotoErr">Foto Profil</label>
               <input type="file" id="foto" name="frm_foto" accept=".png, .jpg, .jpeg" value="<?php echo $data_user->foto_user; ?>">
               <p class="help-block"><strong>Catatan : Apabila tidak ingin merubah foto, Mohon lewati pilihan ini</strong></p>
            </div>
            <div class="form-group col-md-6">
               <input type="submit" value="Update" id="btnUpdateProfil" class="btn btn-primary"/>
               <button type="button" class="btn btn-danger" onclick="javascript:history.back()">kembali</button>
            </div>
         <?php } ?>          
         </form>
   </div>
</div><!-- /.container -->