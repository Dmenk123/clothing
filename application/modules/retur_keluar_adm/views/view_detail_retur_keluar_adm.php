    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Detail Pengeluaran Retur
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Data Transaksi</a></li>
        <li>Pengeluaran Retur</li>
        <li class="active">Detail Pengeluaran Retur</li>
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
                  <h4 style="text-align: center;"><strong>Detail Pengeluaran Retur</strong></h4>
                  <h4 style="text-align: center;">Nama Supplier : <?php echo $val->nama_supplier; ?></h4>
                </div>
                <div class="col-xs-4">
                  <h4 style="text-align: right;">Tanggal Retur : <?php echo $val->tgl_retur_keluar; ?></h4>
                </div>
                <?php endforeach ?>
                  <table id="tabelReturKeluarDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th style="width: 10px; text-align: center;">No</th>
                        <th style="width: 50px; text-align: center;">Id Retur</th>
                        <th style="width: 50px; text-align: center;">Id Penerimaan</th>
                        <th style="width: 300px; text-align: center;">Nama Produk</th>
                        <th style="width: 50px; text-align: center;">Satuan</th>
                        <th style="width: 50px; text-align: center;">Ukuran</th>
                        <th style="width: 50px; text-align: center;">Qty</th>
                        <th style="text-align: center;">Keterangan</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if (count($hasil_data) != 0): ?>
                    <?php $no = 1; ?>
                        <?php foreach ($hasil_data as $val ) : ?>
                        <tr>
                          <td><?php echo $no++; ?></td>  
                          <td><?php echo $val->id_retur_keluar; ?></td>
                          <td><?php echo $val->id_trans_masuk; ?></td>
                          <td><?php echo $val->nama_produk; ?></td>
                          <td><?php echo $val->nama_satuan; ?></td>
                          <td><?php echo $val->ukuran; ?></td>
                          <td><?php echo $val->qty; ?></td>
                          <td><?php echo $val->keterangan; ?></td>
                        </tr>
                        <?php endforeach ?>
                    <?php endif ?>     
                    </tbody>
                  </table>
                  <div style="padding-top: 30px; padding-bottom: 10px;">
                    <a class="btn btn-sm btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>

                    <?php $id = $this->uri->segment(3); ?>
                    <?php $link_srt_jln_ret = site_url('retur_keluar_adm/cetak_surat_jalan_retur/').$id; ?>
                    <?php echo '<a class="btn btn-sm btn-success" href="'.$link_srt_jln_ret.'" title="Cetak Surat Jalan" target="_blank"><i class="glyphicon glyphicon-print"></i> Cetak Surat Jalan</a>';?>
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