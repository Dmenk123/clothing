    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Stok Produk
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Laporan</a></li>
        <li class="active">Stok Produk</li>
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
                  <h4 style="text-align: center;"><strong>Laporan Stok Produk</strong></h4>
                  <h4 style="text-align: center;">Dmenk Clothing E-shop</h4>
                </div>
                <div class="col-xs-12">
                  <h4 style="text-align: center;">Sampai dengan Tanggal : <?php echo date('d-m-Y');?></h4>
                </div>
                  <table id="laporanStokProduk" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th style="width: 10px; text-align: center;">No</th>
                        <th style="width: 80px; text-align: center;">ID Produk</th>
                        <th style="width: 300px; text-align: center;">Nama Barang</th>
                        <th style="width: 100px; text-align: center;">Ukuran</th>
                        <th style="width: 100px; text-align: center;">Satuan</th>
                        <th style="width: 100px; text-align: center;">Berat satuan</th>
                        <th style="width: 80px; text-align: center;">Stok Min</th>
                        <th style="width: 80px; text-align: center;">Stok Sisa</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if (count($hasil_data) != 0): ?>
                    <?php $no = 1; ?>
                      <?php foreach ($hasil_data as $val ) : ?>
                        <?php if ($val->stok_sisa < $val->stok_minimum) { ?>
                          <tr>
                            <td style="color: red; font-weight: bold;"><?php echo $no++; ?></td> 
                            <td style="color: red; font-weight: bold;"><?php echo $val->id_produk; ?></td>
                            <td style="color: red; font-weight: bold;"><?php echo $val->nama_produk; ?></td>
                            <td style="color: red; font-weight: bold;"><?php echo $val->ukuran_produk; ?></td>
                            <td style="color: red; font-weight: bold;"><?php echo $val->nama_satuan; ?></td>
                            <td style="color: red; font-weight: bold;"><?php echo $val->berat_satuan; ?></td>
                            <td style="color: red; font-weight: bold;"><?php echo $val->stok_minimum; ?></td>
                            <td style="color: red; font-weight: bold;"><?php echo $val->stok_sisa; ?></td>
                          </tr>
                        <?php }else{ ?>
                          <tr>
                            <td><?php echo $no++; ?></td> 
                            <td><?php echo $val->id_produk; ?></td>
                            <td><?php echo $val->nama_produk; ?></td>
                            <td><?php echo $val->ukuran_produk; ?></td>
                            <td><?php echo $val->nama_satuan; ?></td>
                            <td><?php echo $val->berat_satuan; ?></td>
                            <td><?php echo $val->stok_minimum; ?></td>
                            <td><?php echo $val->stok_sisa; ?></td>
                          </tr>
                        <?php } ?>  
                      <?php endforeach ?>
                    <?php endif ?>     
                    </tbody>
                  </table>
                  <div style="padding-top: 30px; padding-bottom: 10px;">
                    <a class="btn btn-sm btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>
                    <?php $link_print = site_url("laporan_stok/cetak_report_stok"); ?>
                    <?php echo '<a class="btn btn-sm btn-success" href="'.$link_print.'" target="_blank" title="Print Laporan Stok" id="btn_print_laporan_order"><i class="glyphicon glyphicon-print"></i> Cetak</a>';?>
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