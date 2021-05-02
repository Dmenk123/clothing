    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Master User
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li class="active">User</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <?php if ($this->session->userdata('id_level_user') == '1') { ?>
                <button class="btn btn-success" onclick="add_user()"><i class="glyphicon glyphicon-plus"></i> Add User</button>
              <?php } ?>
              <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive"> 
                <table id="tabelUser" class="table table-bordered table-hover" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nama User</th>
                      <th>Email</th>
                      <th>Password</th>
                      <th>Level</th>
                      <th>Status</th>
                      <th>Terakhir Login</th>
                      <th style="width: 175px;">Action</th>
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
