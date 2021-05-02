    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Detail Produk
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li>Produk</li>
        <li class="active">Detail Produk</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <button class="btn btn-success" title="Add Detail" onclick="addDetailProduk()"><i class="glyphicon glyphicon-plus"></i> Add Detail</button>
              <button class="btn btn-default" title="Refresh" onclick="reload_table_detail()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
              <button class="btn btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</button> 
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive"> 
              <?php foreach ($hasil_header as $val ) : ?>
                <div class="col-xs-10">
                  <h2 style="text-align: center;">Detail Produk : <?php echo $val->nama_produk; ?></h2>
                  <h4 style="text-align: center;">Kode Produk : <?php echo $val->id_produk; ?></h4>
                </div>
                <div class="col-xs-2">
                  <img src="<?php echo config_item('assets');?>img/produk/<?php echo $val->nama_gambar; ?>" style="height: 50%; width: 50%; border: 1px solid;">
                </div>
              <?php endforeach ?>
              
                <table id="tabelProdukDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Ukuran Produk</th>
                      <th>Berat Satuan</th>
                      <th>Stok Awal</th>
                      <th>Stok Sisa</th>
                      <th>Stok Minimum</th>
                      <th style="width: 160px; text-align: center;">Action</th>
                    </tr>
                  </thead>
                  </tbody>
                </table>
               </div>
               <!-- responsive --> 
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>    
    </section>
    <!-- /.content -->