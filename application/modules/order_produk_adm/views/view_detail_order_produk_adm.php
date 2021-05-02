    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Detail Transaksi Order
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Data Transaksi</a></li>
        <li>Order Produk</li>
        <li class="active">Detail Order Produk</li>
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
                <?php foreach ($hasil_header as $val ) : ?>
                <div class="col-xs-4">
                  <h4 style="text-align: left;">Nama Petugas : <?php echo $val->fname_user." ".$val->lname_user; ?></h4>
                </div>
                <div class="col-xs-4">
                  <h4 style="text-align: center;"><strong>Detail Pemesanan Produk</strong></h4>
                  <h4 style="text-align: center;">Nama Supplier : <?php echo $val->nama_supplier; ?></h4>
                </div>
                <div class="col-xs-4">
                  <h4 style="text-align: right;">Tanggal Pesan: <?php echo $val->tgl_trans_order; ?></h4>
                </div>
                <?php endforeach ?>
                  <table id="tabelTransOrderDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th style="width: 10px; text-align: center;">No</th>
                        <th style="width: 20px; text-align: center;">Id Order</th>
                        <th style="width: 300px; text-align: center;">Nama Produk</th>
                        <th style="width: 100px; text-align: center;">Satuan</th>
                        <th style="width: 100px; text-align: center;">Ukuran</th>
                        <th style="width: 80px; text-align: center;">Qty</th>
                        <th style="text-align: center;">Harga Satuan</th>
                         <th style="text-align: center;">Harga Total</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if (count($hasil_data) != 0): ?>
                    <?php $no = 1; ?>
                        <?php foreach ($hasil_data as $val ) : ?>
                        <tr>
                          <td><?php echo $no++; ?></td>  
                          <td><?php echo $val->id_trans_order; ?></td>
                          <td><?php echo $val->nama_produk; ?></td>
                          <td><?php echo $val->nama_satuan; ?></td>
                          <td><?php echo $val->ukuran; ?></td>
                          <td><?php echo $val->qty; ?></td>
                          <td><?php echo $val->harga_satuan_beli; ?></td>
                          <td><?php echo $val->harga_total_beli; ?></td>
                        </tr>
                        <?php endforeach ?>
                    <?php endif ?>     
                    </tbody>
                  </table>
                  <div style="padding-top: 30px; padding-bottom: 10px;">
                    <a class="btn btn-sm btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>

                    <?php $id = $this->uri->segment(3); ?>
                    <?php $link_print = site_url('order_produk_adm/cetak_report_order_detail/').$id; ?>
                    <?php $link_sj = site_url('order_produk_adm/cetak_surat_pembelian/').$id; ?>
                    <?php echo '<a class="btn btn-sm btn-success" href="'.$link_print.'" title="Print Order Detail" id="btn_print_order_detail" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak</a>';?>
                    <?php echo '<a class="btn btn-sm btn-success" href="'.$link_sj.'" title="Print Surat Pembelian" id="btn_print_surat_beli" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak Surat Pembelian</a>';?>
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