    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Master Kategori
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">Kategori</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <button class="btn btn-success" onclick="add_tag()"><i class="glyphicon glyphicon-plus"></i> Add Tag</button>
              <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive"> 
                <table id="tabelTag" class="table table-bordered table-hover" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Tag</th>
                      <th>Warna</th>
                      <th style="width: 225px; text-align: center;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
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
