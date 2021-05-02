    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Penjualan Produk
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Laporan</a></li>
        <li class="active">Penjualan Produk</li>
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
                  <h4 style="text-align: center;"><strong>Laporan Penjualan Produk</strong></h4>
                  <p style="text-align: center; font-size: 14px;">Periode <?php echo $tanggal; ?></p>
                  <p style="text-align: center; font-size: 18px;">Dmenk Clothing E-Shop</p>
                </div>
                  <table id="laporanStokProduk" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th style="width: 10px; text-align: center;">No</th>
                        <th style="width: 30px; text-align: center;">ID Pembelian</th>
                        <th style="width: 30px; text-align: center;">Method</th>
                        <th style="width: 40px; text-align: center;">Tgl</th>
                        <th style="width: 200px; text-align: center;">Nama Produk</th>
                        <th style="width: 30px; text-align: center;">Ukuran</th>
                        <th style="width: 30px; text-align: center;">Satuan</th>
                        <th style="width: 30px; text-align: center;">Qty</th>
                        <th style="width: 80px; text-align: center;">Harga Beli</th>
                        <th style="width: 80px; text-align: center;">Harga Jual</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if (count($hasil_data) != 0): ?>
                    <?php $no = 1; ?>
                    <?php $totalHargaBeli = 0; ?>
                    <?php $totalHargaJual = 0; ?>
                      <?php foreach ($hasil_data as $val ) : ?>
                          <tr>
                            <td><?php echo $no++; ?></td> 
                            <td><?php echo $val->id_pembelian; ?></td>
                            <td><?php echo $val->method_checkout; ?></td>
                            <td><?php echo $val->tgl_pembelian; ?></td>
                            <td><?php echo $val->nama_produk; ?></td>
                            <td><?php echo $val->ukuran_produk; ?></td>
                            <td><?php echo $val->nama_satuan; ?></td>
                            <td><?php echo $val->qty; ?></td>
                            <td>Rp. <?php echo number_format($val->harga_satuan,0,",","."); ?></td>
                            <td>Rp. <?php echo number_format($val->harga,0,",","."); ?></td>
                          </tr>
                          <?php $totalHargaBeli += $val->harga_satuan; ?>
                          <?php $totalHargaJual += $val->harga; ?>
                      <?php endforeach ?>
                          <tr>
                            <td colspan="8" style="text-align: center;"><strong>Total</strong></td>
                            <td>Rp. <?php echo number_format($totalHargaBeli,0,",","."); ?></td>
                            <td>Rp. <?php echo number_format($totalHargaJual,0,",","."); ?></td>
                          </tr>
                          <tr>
                            <td colspan="8" style="text-align: center;">
                              <strong>Keuntungan Hasil Penjualan</strong>
                            </td>
                            <td colspan="2" style="text-align: center;">
                              <strong>Rp. <?php echo number_format($totalHargaJual - $totalHargaBeli,0,",","."); ?></strong>
                            </td>
                          </tr>
                    <?php endif ?>     
                    </tbody>
                  </table>
                  <div style="padding-top: 30px; padding-bottom: 10px;">
                    <a class="btn btn-sm btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>
                    <?php $tglAwal = $tanggal_awal; ?> 
                    <?php $tglAkhir = $tanggal_akhir; ?>
                    <?php $link_print = site_url("laporan_penjualan/cetak_laporan_penjualan/".$tglAwal."/".$tglAkhir.""); ?>
                    <?php echo '<a class="btn btn-sm btn-success" href="'.$link_print.'" target="_blank" title="Print Laporan Penjualan" id="btn_print_laporan_order"><i class="glyphicon glyphicon-print"></i> Cetak</a>';?>
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