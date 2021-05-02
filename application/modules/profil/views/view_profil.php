<div class="container">
   <div class="col-md-12">
      <ul class="breadcrumb">
         <li><a href="#">Home</a></li>
         <li><?php echo $this->uri->segment(1); ?></li>
      </ul>

   </div>

   <div class="col-md-12">
      <div class="box" id="contact">
         <h2>Pengaturan Profil</h2>
        <p class="text-muted">Berikut merupakan data profil anda, anda dapat mengatur profil anda dengan menekan tombol <strong>Edit</strong>.</p>
         <div class="row">
            <?php foreach ($data_user as $value) { ?>
            <div class="col-md-9">
               <p><strong>Nama Lengkap :</strong> <?php echo $value->fname_user." ".$value->lname_user; ?> 
                  <br><strong>Email :</strong> <?php echo $value->email; ?>
                  <br><strong>Alamat :</strong> <?php echo $value->alamat_user.", ".$value->nama_kelurahan." - ".$value->nama_kecamatan.", ".$value->nama_kota." - ".$value->nama_provinsi; ?>
                  <br><strong>Nomor Telp :</strong> <?php echo $value->no_telp_user; ?>
                  <br><strong>Tanggal Lahir :</strong> <?php echo $value->tgl_lahir_user; ?>
                  <br><strong>Terakhir Login :</strong> <?php echo $value->last_login; ?>
               </p> 
            </div>
            <div class="col-md-3">
               <span>
                  <img src="<?php echo config_item('assets');?>img/foto_profil/<?php echo $value->foto_user; ?>" style="border-radius: 50%; height: 50%; width: 50%;">
               </span>   
            </div>
            <?php } ?>
         </div><!-- /.row -->
         <div>
               <?php $link = site_url('profil/edit_profil/').$this->session->userdata('id_user'); ?>
               <a class="btn btn-sm btn-primary" href="<?php echo $link; ?>" title="Edit"> Edit Profil</a>
         </div>
         <hr>
         <h2>Progress Transaksi Anda</h2>
         <p class="text-muted">Berikut merupakan tabel transaksi yang belum dikonfirmasi untuk pembelian. Transaksi anda akan dinyatakan valid apabila telah melakukan konfirmasi. anda dapat membatalkan transaksi dengan menekan tombol <strong>Nonaktif (Warna Merah)</strong> & menekan <strong>tombol detail (Warna hijau)</strong> untuk melihat detail serta melakukan konfirmasi</p>
         <div class="row">
            <div class="col-md-12">
               <div class="table-responsive"> 
                  <table id="tabelCheckoutHistory" class="table table-bordered table-hover">
                     <thead>
                        <tr>
                           <th style="text-align: center;">Tanggal</th>
                           <th style="text-align: center;">Kode</th>
                           <th style="text-align: center;">Metode</th>
                           <th style="text-align: center;">Harga Total</th>
                           <th style="text-align: center;">Ekspedisi</th>
                           <th style="width: 100px; text-align: center;">Paket</th>
                           <th style="text-align: center;">ETD</th>
                           <th style="text-align: center;">Ongkir</th>
                           <th style="text-align: center;">Ongkos Total</th>
                           <th style="text-align: center;">Kode Ref</th>
                           <th style="width: 200px; text-align: center;">Aksi</th>
                        </tr>
                     </thead>
                  <tbody>
                  </tbody>
                </table>
              </div><!-- responsive -->
           </div> <!-- /.col-md-12 -->
         </div><!-- /.row -->
      </div><!-- /.box -->
   </div><!-- /.col-md-9 -->
</div><!-- /.container -->