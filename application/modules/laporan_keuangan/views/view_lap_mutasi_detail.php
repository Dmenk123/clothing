    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Mutasi Barang
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Laporan</a></li>
        <li class="active">Laporan Mutasi</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <div class="col-xs-12">
                  <h4 style="text-align: center;"><strong>Laporan Mutasi Produk</strong></h4>
                </div>
                <div class="col-xs-12">
                  <h4 style="text-align: center;">Dmenk Clothing E-shop</h4>
                  <h4 style="text-align: center;">Periode Tanggal : <?php echo date("d-m-Y", strtotime($tanggal_awal))." s/d ".date("d-m-Y", strtotime($tanggal_akhir)); ?></h4>
                </div>
                  <table id="tblLaporanMutasiDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th style="width: 30px; text-align: center;">No</th>
                        <th style="width: 30px; text-align: center;">ID</th>
                        <th style="width: 180px; text-align: center;">Nama Barang</th>
                        <th style="width: 30px; text-align: center;">Size</th>
                        <th style="width: 30px; text-align: center;">Satuan</th>
                        <th style="width: 30px; text-align: center;">Stok Awal</th>
                        <th style="width: 30px; text-align: center;">IN</th>
                        <th style="width: 30px; text-align: center;">OUT</th>
                        <th style="width: 30px; text-align: center;">Stok Akhir</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if (count($hasil_data) != 0): ?>
                    <?php $no = 1; ?>
                      <?php foreach ($hasil_data as $val ) : ?>
                        <tr>
                          <td><?php echo $no++; ?></td> 
                          <td><?php echo $val->id_produk ?></td>
                          <td><?php echo $val->nama_produk; ?></td>
                          <td><?php echo $val->ukuran_produk; ?></td>
                          <td><?php echo $val->nama_satuan; ?></td>
                          <td><?php echo $val->stok_awal; ?></td>
                          <td><?php echo $val->masuk; ?></td>
                          <td><?php echo $val->keluar; ?></td>
                          <td><?php echo $val->sisa_stok; ?></td>                   
                        </tr>
                      <?php endforeach ?>
                    <?php endif ?>     
                    </tbody>
                  </table>
                  <div style="padding-top: 20px; padding-bottom: 10px;">
                    <a class="btn btn-sm btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>

                    <?php $tglAwal = $tanggal_awal; ?> 
                    <?php $tglAkhir = $tanggal_akhir; ?>
                    <?php $pilihanTampil = $pilihan_tampil; ?>
                    <?php $link_print = site_url("laporan_mutasi/cetak_report_mutasi/".$tglAwal."/".$tglAkhir."/".$pilihanTampil.""); ?>
                    <?php echo '<a class="btn btn-sm btn-success" href="'.$link_print.'" target="_blank" title="Print Laporan Mutasi" id="btn_print_laporan_retur_masuk"><i class="glyphicon glyphicon-print"></i> Cetak</a>';?>
                  </div>
              </div>  
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>    
    </section>
    <!-- /.content -->                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    