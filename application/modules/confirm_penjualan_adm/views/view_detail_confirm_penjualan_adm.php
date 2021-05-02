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
                  <h4 style="text-align: center;"><strong>Detail Penjualan Produk</strong></h4>
                </div>
                <?php foreach ($hasil_header as $val ) : ?>
                <div class="col-xs-4">
                  <h4 style="text-align: left;">Nama Petugas : <?php echo $val->fname_user." ".$val->lname_user; ?></h4>
                 <h4 style="text-align: left;">ID Pembelian : <?php echo $val->id_pembelian; ?></h4>
                </div>
                <div class="col-xs-4">
                  <h4 style="text-align: center;">Metode : <?php echo $val->method_checkout; ?></h4>
                  <?php if ($val->method_checkout != "COD") { ?>
                    <h4 style="text-align: center;">Ekspedisi : <?php echo $val->jasa_ekspedisi." | ".$val->pilihan_paket." | ".$val->estimasi_datang; ?></h4>
                    <h4 style="text-align: center;">Biaya Ongkir : Rp. <?php echo number_format($val->ongkos_kirim,0,",","."); ?></h4>
                  <?php } ?>
                </div>
                <div class="col-xs-4">
                  <h4 style="text-align: right;">Tanggal Penjualan : <?php echo $val->tgl_pembelian; ?></h4>
                  <h4 style="text-align: right;">ID Checkout : <?php echo $val->id_checkout; ?></h4>
                </div>
                <div class="col-xs-9" style="padding-bottom: 20px;">
                  <?php if ($val->method_checkout != "COD"): ?>
                    <p><strong>Gambar bukti Transfer</strong></p>
                  <?php endif ?>
                  <?php if ($val->btransfer_1 != null) { ?>
                    <a href="#" data-toggle="modal" class="modalGbrTransfer" data-id="<?php echo $val->btransfer_1; ?>">
                      <img src="<?php echo base_url('assets/img/bukti_transfer/'.$val->btransfer_1);?>" class="gbrDetailPenjualan">
                    </a>
                  <?php } ?>
                  <?php if ($val->btransfer_2 != null) { ?>
                    <a href="#" data-toggle="modal" class="modalGbrTransfer" data-id="<?php echo $val->btransfer_2; ?>">
                      <img src="<?php echo base_url('assets/img/bukti_transfer/'.$val->btransfer_2);?>" class="gbrDetailPenjualan">
                    </a>
                  <?php } ?>
                  <?php if ($val->btransfer_3 != null) { ?>
                  <a href="#" data-toggle="modal" class="modalGbrTransfer" data-id="<?php echo $val->btransfer_3; ?>">
                    <img src="<?php echo base_url('assets/img/bukti_transfer/'.$val->btransfer_3);?>" class="gbrDetailPenjualan">
                  </a>
                  <?php } ?>
                </div>
                <div class="col-xs-3" style="padding-bottom: 20px;">
                  <?php if ($val->bconfirm_adm != null) { ?>
                    <p><strong>Gambar bukti Konfirmasi</strong></p>
                    <a href="#" data-toggle="modal" class="modalGbrKonfirmasi" data-id="<?php echo $val->bconfirm_adm; ?>">
                      <img src="<?php echo base_url('assets/img/bukti_konfirmasi/'.$val->bconfirm_adm);?>" class="gbrDetailPenjualan">
                    </a>
                  <?php } ?>
                </div>
                <?php endforeach ?>
                  <table id="tabelTransOrderDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th style="width: 30px; text-align: center;">No</th>
                        <th style="width: 70px; text-align: center;">A/n Kirim</th>
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
                          <td><?php echo $val->fname_kirim." ".$val->lname_kirim; ?></td>
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
                    <?php foreach ($hasil_header as $val ) : ?>
                      <td colspan="6" align="center"><strong>Harga Keseluruhan</strong></td>
                      <td colspan="2" align="center"><strong>Rp. <?php echo number_format($val->ongkos_total,0,",","."); ?></strong></td>
                    <?php endforeach ?> 
                    </tr>    
                    </tbody>
                  </table>
                  <div style="padding-top: 30px; padding-bottom: 10px;">
                    <a class="btn btn-sm btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>

                    <?php $id = $this->uri->segment(3); ?>
                    <?php $link_cetak = site_url('confirm_penjualan_adm/cetak_nota_penjualan/').$id; ?>
                    <?php echo '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Confirm" onclick="editConfirmPenjualan('."'".$id."'".')"><i class="glyphicon glyphicon-check"></i> Confirm</a>';?>
                    <?php echo '<a class="btn btn-sm btn-success" href="'.$link_cetak.'" title="Print Nota" id="btn_print_surat_beli" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak Nota</a>';?>
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