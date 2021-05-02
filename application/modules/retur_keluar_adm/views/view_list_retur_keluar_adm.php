    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Retur Produk keluar ke Supplier/Vendor
      </h1>

      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Data Transaksi</a></li>
        <li class="active">Pengeluaran Retur</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-s12">
          <div class="box">
            <div class="box-header">
              <button class="btn btn-success" onclick="addReturKeluar()"><i class="glyphicon glyphicon-plus"></i> Tambah Retur Keluar</button>
              <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table id="tableReturKeluar" class="table table-bordered table-hover" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>ID Retur Keluar</th>
                      <th>Nama User</th>
                      <th>Nama Supplier</th>
                      <th>Tanggal</th>
                      <th style="width: 240px;">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>  
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>    
    </section>
    <!-- /.content -->