    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Penerimaan hasil retur
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Laporan</a></li>
        <li class="active">Laporan Penerimaan Retur Produk</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <label class="control-label">Pilih periode tanggal Laporan pada field dibawah ini</label>
              <form class="form-inline" method="post" action="<?php echo site_url('laporan_retur_keluar/laporan_retur_keluar_detail') ?>">
                <div class="form-group">
                  <input type="text" class="form-control" id="tgl_laporan_awal" name="tanggalLapAwal" placeholder="Pilih Tanggal Mulai" required="">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="tgl_laporan_akhir" name="tanggalLapAkhir" placeholder="Sampai Tanggal" required="">
                </div>
                <button type="submit" class="btn btn-info">Cari</button>
                <button type="reset" class="btn btn-default">reset</button>
              </form>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <a class="btn btn-sm btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</a>
            </div>
          </div>
          <!-- /.box -->
        </div>
      </div>    
    </section>
    <!-- /.content -->
