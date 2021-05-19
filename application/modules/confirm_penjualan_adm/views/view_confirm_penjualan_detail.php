    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Detail Konfirmasi Penjualan
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Data Transaksi</a></li>
        <li>Konfirmasi Penjualan</li>
        <li class="active">Detail Konfirmasi Penjualan</li>
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
                  <h4 style="text-align: center;"><strong>Detail Penjualan</strong></h4>
                </div>
                <div class="col-xs-4">
                 <h4 style="text-align: left;">Order ID : <?php echo $hasil_header->order_id; ?></h4>
								 <h4 style="text-align: left;">Metode : <?php echo $hasil_header->metode; ?></h4>
                </div>
                <div class="col-xs-4">
									<h4 style="text-align: center;">Ekspedisi : <?php echo $hasil_header->jasa_ekspedisi; ?></h4>
									<h4 style="text-align: center;">Paket : <?php echo $hasil_header->pilihan_paket." | ".$hasil_header->estimasi_datang; ?></h4>
                </div>
                <div class="col-xs-4">
                  <h4 style="text-align: right;">Tanggal Checkout : <?php echo $hasil_header->tgl_checkout; ?></h4>
                  <h4 style="text-align: right;">Nama : <?php echo $hasil_header->nama; ?></h4>
									<h4 style="text-align: right;">Email : <?php echo $hasil_header->email; ?></h4>
								</div>
                <div class="col-xs-12" style="padding-bottom: 20px;">
									<p><strong>Gambar bukti Transfer</strong></p>
									<a href="#" data-toggle="modal" class="modalGbrTransfer" data-id="<?php echo $hasil_header->bukti_transfer; ?>">
										<img src="<?php echo base_url($hasil_header->bukti_transfer);?>" class="gbrDetailPenjualan">
									</a>
                  
                </div>
                  <table id="tabelTransOrderDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th style="width: 30px; text-align: center;">No</th>
                        <th style="width: 70px; text-align: center;">Alamat Kirim</th>
                        <th style="width: 200px; text-align: center;">Nama Produk</th>
                        <th style="width: 30px; text-align: center;">Size</th>
                        <th style="width: 30px; text-align: center;">Sat</th>
                        <th style="width: 30px; text-align: center;">Qty</th>
                        <th style="width: 50px; text-align: center;">Harga Satuan</th>
                        <th style="width: 50px; text-align: center;">Harga Total</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if (count($hasil_data) != 0): ?>
                    <?php $no = 1; ?>
                        <?php foreach ($hasil_data as $val ) : ?>
                        <tr>
                          <td><?php echo $no++; ?></td>  
                          <td><?php echo $val->alamat." ".$val->kota_tujuan_txt; ?></td>
                          <td><?php echo $val->nama_produk; ?></td>
                          <td><?php echo $val->ukuran_produk; ?></td>
                          <td><?php echo $val->nama_satuan; ?></td>
                          <td><?php echo $val->qty; ?></td>
                          <td>Rp. <?php echo number_format($val->harga,0,",","."); ?></td>
                          <td>Rp. <?php echo number_format($val->harga * $val->qty,0,",","."); ?></td>
                        </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                    <tr>
                      <td colspan="6" align="center"><strong>Harga Keseluruhan Produk</strong></td>
                      <td colspan="2" align="center"><strong>Rp. <?php echo number_format($hasil_header->harga_total_produk,0,",","."); ?></strong></td>
                    </tr>  
										<tr>
                      <td colspan="6" align="center"><strong>Ongkos Kirim</strong></td>
                      <td colspan="2" align="center"><strong>Rp. <?php echo number_format($hasil_header->ongkos_kirim,0,",","."); ?></strong></td>
                    </tr> 
										<tr>
                      <td colspan="6" align="center"><strong>Grand Total</strong></td>
                      <td colspan="2" align="center"><strong>Rp. <?php echo number_format($hasil_header->ongkos_total,0,",","."); ?></strong></td>
                    </tr>    
                    </tbody>
                  </table>
                  <div style="padding-top: 30px; padding-bottom: 10px;">
                    <a class="btn btn-sm btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>

                    <?php $id = $this->uri->segment(3); ?>
                    <?php $link_cetak = site_url('confirm_penjualan_adm/cetak_nota_penjualan/').$id; ?>
                    <?php echo '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Confirm" onclick="editConfirmPenjualan('."'".$id."'".')"><i class="glyphicon glyphicon-check"></i> Confirm</a>';?>
                    <!-- <?php echo '<a class="btn btn-sm btn-success" href="'.$link_cetak.'" title="Print Nota" id="btn_print_surat_beli" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak Nota</a>';?> -->
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
