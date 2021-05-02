    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Riwayat Permintaan Produk
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Laporan</a></li>
        <li class="active">Riwayat Pemintaan Produk</li>
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
                  <h4 style="text-align: center;"><strong>Laporan Riwayat Permintaan Produk</strong></h4>
                </div>
                <div class="col-xs-12">
                  <h4 style="text-align: center;">Dmenk Clothing E-shop</h4>
                  <h4 style="text-align: center;">Periode Tanggal : <?php echo date("d-m-Y", strtotime($tanggal_awal))." s/d ".date("d-m-Y", strtotime($tanggal_akhir)); ?></h4>
                </div>
                  <table id="laporanStokProduk" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th style="width: 10px; text-align: center;">No</th>
                        <th style="width: 30px; text-align: center;">ID Order</th>
                        <th style="width: 40px; text-align: center;">Tanggal</th>
                        <th style="width: 200px; text-align: center;">Nama Produk</th>
                        <th style="width: 130px; text-align: center;">Supplier</th>
                        <th style="width: 30px; text-align: center;">Ukuran</th>
                        <th style="width: 30px; text-align: center;">Satuan</th>
                        <th style="width: 30px; text-align: center;">Qty</th>
                        <th style="width: 80px; text-align: center;">Harga Total</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if (count($hasil_data) != 0): ?>
                    <?php $no = 1; ?>
                      <?php foreach ($hasil_data as $val ) : ?>
                          <tr>
                            <td><?php echo $no++; ?></td> 
                            <td><?php echo $val->id_trans_order; ?></td>
                            <td><?php echo $val->tgl_trans_order; ?></td>
                            <td><?php echo $val->nama_produk; ?></td>
                            <td><?php echo $val->nama_supplier; ?></td>
                            <td><?php echo $val->ukuran; ?></td>
                            <td><?php echo $val->nama_satuan; ?></td>
                            <td><?php echo $val->qty; ?></td>
                            <td>Rp. <?php echo number_format($val->harga_total_beli,0,",","."); ?></td>
                          </tr> 
                      <?php endforeach ?>
                    <?php endif ?>     
                    </tbody>
                  </table>
                  <div style="padding-top: 30px; padding-bottom: 10px;">
                    <a class="btn btn-sm btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>
                    <?php $filterBy = $filter_by; ?>
                    <?php $dataList = $data_list; ?>
                    <?php $tglAwal = $tanggal_awal; ?> 
                    <?php $tglAkhir = $tanggal_akhir; ?>                
                    <?php $link_print = site_url("laporan_history_order/cetak_laporan_riwayat/".$filterBy."/".$dataList."/".$tglAwal."/".$tglAkhir.""); ?>
                    <?php echo '<a class="btn btn-sm btn-success" href="'.$link_print.'" target="_blank" title="Print Laporan Permintaan" id="btn_print_laporan_order"><i class="glyphicon glyphicon-print"></i> Cetak</a>';?>
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