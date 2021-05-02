   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>Dashboard
         <small><strong>Selamat Datang : <?php foreach ($data_user as $val) {
            echo $val->fname_user." ".$val->lname_user;
         } ?></strong></small>
      </h1>
      <ol class="breadcrumb">
         <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
         <li class="active">Barang</li>
      </ol>
   </section>

   <!-- Main content -->
   <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="box">
         <div class="box-body">
            <div class="row">
               <div class="col-lg-4 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-aqua">
                     <div class="inner">
                        <h3>
                           <?php foreach ($counter_user as $val) { ?>
                              <?php echo $val->jumlah_user; ?>
                           <?php } ?>
                        </h3>
                        <p>Master User Aktif</p>
                     </div>
                     <div class="icon">
                        <i class="fa fa-users"></i>
                     </div>
                     <a href="<?php echo site_url('adm_user'); ?>" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                  <!-- /.small box -->
                  <!-- Widget: user widget style 1 -->
                  <div class="box box-widget widget-user-2">
                     <!-- Add the bg color to the header using any of the bg-* classes -->
                     <div class="widget-user-header bg-blue">
                        <span class="icon fa fa-user"></span> Kategori User
                     </div>
                     <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                           <?php foreach ($counter_user_level as $val) { ?>
                              <li><a><?php echo $val->nama_level_user; ?> <span class="pull-right badge bg-blue"><?php echo $val->jumlah_level; ?></span></a></li>
                           <?php } ?>
                        </ul>
                     </div>
                  </div>
                  <!-- /.widget-user -->
               </div>
               <!-- ./col -->
               <div class="col-lg-4 col-xs-6">
                  <!-- small box -->
                  <div class="small-box bg-purple">
                     <div class="inner">
                        <h3>
                           <?php foreach ($counter_produk as $val) { ?>
                              <?php echo $val->jumlah_produk; ?>
                           <?php } ?>
                        </h3>
                        <p>Master Produk aktif</p>
                     </div>
                     <div class="icon">
                        <i class="fa fa-tasks"></i>
                     </div>
                     <a href="<?php echo site_url('adm_user'); ?>" class="small-box-footer">Lihat Detail <i class="fa fa-arrow-circle-right"></i></a>
                  </div>
                  <!-- /.small box -->
                  <!-- Widget: user widget style 1 -->
                  <div class="box box-widget widget-user-2">
                     <!-- Add the bg color to the header using any of the bg-* classes -->
                     <div class="widget-user-header bg-blue">
                        <span class="icon fa fa-tasks"></span> Top 5 Stok Produk (berdasarkan ukuran)
                     </div>
                     <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                           <?php foreach ($counter_stok as $val) { ?>
                              <li><a><?php echo $val->nama_produk." | Size : ".$val->ukuran_produk; ?> <span class="pull-right badge bg-blue"><?php echo $val->stok_sisa; ?></span></a></li>
                           <?php } ?>
                        </ul>
                     </div>
                  </div>
                  <!-- /.widget-user -->
               </div>
               <!-- ./col -->
            </div>
            <!-- ./row -->
         </div>
      </div>       
   </section>
   <!-- /.content -->
