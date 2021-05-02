    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Sub-Kategori
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li>Kategori</li>
        <li class="active">Sub-kategori</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <button class="btn btn-success" title="Add Subkategori" onclick="add_sub_kategori()"><i class="glyphicon glyphicon-plus"></i> Add Subkategori</button>
              <button class="btn btn-default" title="Refresh" onclick="reload_table2()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
              <button class="btn btn-danger" title="Kembali" onclick="javascript:history.back()"><i class="glyphicon glyphicon-menu-left"></i> Kembali</button> 
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive"> 
                <div class="col-xs-12" style="padding-bottom: 30px;">
                  <h2 style="text-align: center;">Nama Kategori : <?php echo $hasil_header->nama_kategori." - ".$hasil_header->akronim; ?></h2>
                  <h4 style="text-align: center;">Keterangan : <?php echo $hasil_header->ket_kategori; ?></h4>
                </div>
                <table id="tabelSubKategori" class="table table-bordered table-hover" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Sub-kategori</th>
                      <th>Keterangan</th>
                      <th>Gender Sub-kategori</th>
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
