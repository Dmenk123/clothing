    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pesan
        <small>Kotak Masuk</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Pesan</a></li>
        <li class="active">Inbox</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="table-responsive">
             <table id="tabelInbox" class="table table-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style="width: 20px;">No</th>
                    <th style="width: 100px;">Pengirim</th>
                    <th style="width: 100px;">Email</th>
                    <th style="width: 100px;">Subject</th>
                    <th>Isi Pesan</th>
                    <th style="width: 140px;">Tgl Kirim</th>
                    <th style="width: 220px;">Action</th>
                  </tr>
                </thead>
                <tbody></tbody>
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
