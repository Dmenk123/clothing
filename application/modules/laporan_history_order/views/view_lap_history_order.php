    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Riwayat Permintaan
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Laporan</a></li>
        <li class="active">Laporan Riwayat Permintaan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
              <label class="control-label">Pilih periode tanggal Laporan pada field dibawah ini :</label>
              <form method="post" action="<?php echo site_url('laporan_history_order/laporan_history_order_detail') ?>">
              <div class="form-row">
                <div class="form-group">
                  <input type="text" class="form-control" id="tgl_laporan_awal" name="tanggalLaporanAwal" placeholder="Pilih Tanggal Mulai" required="">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="tgl_laporan_akhir" name="tanggalLaporanAkhir" placeholder="Sampai Tanggal" required="">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                <label class="control-label">Pilih Laporan Berdasarkan : </label>
                 <select name="indexTampil" class="form-control" required="" id="field_index_tampil" style="width: 100%;">
                    <option value="">-- Pilih Berdasarkan --</option>
                    <option value="supplier">Nama Supplier</option>
                    <option value="barang">Nama Barang</option>
                  </select>
                </div>
              </div>  
              <div class="form-row">
                <div class="form-group">
                <label class="control-label">Pilih Nama Barang / Suplier : </label>
                  <select name="tampilData" class="form-control col-md-4" required="" id="field_tampil_data" style="width: 100%;">
                    
                  </select>
                </div>
              </div>
              <div class="form-row" style="padding-top: 10px;">
                <div class="form-group">
                  <button type="submit" class="btn btn-info">Cari</button>
                  <button type="reset" class="btn btn-default">reset</button>
                </div>  
              </div>
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
