    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Form Diskon Produk
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
        <li>Produk</li>
        <li class="active">Config Produk</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
							<form action="<?= base_url('master_produk_adm/simpan_diskon'); ?>" method="post">
								<div class="form-row">
										<input type="hidden" name="idProduk">
										<div class="form-group col-md-12">
											<label for="lblName" class="lblNamaErr">Nama Produk</label>
											<input type="text" class="form-control" name="namaProduk" placeholder="Nama Produk" readonly>
										</div>
								</div>                  
								<div class="form-row">
									<div class="form-group col-md-2">
										<label for="lblSubKategori">Apakah Diskon ?</label>
									</div>
									<div class="col-md-1 form-group">
										<label><input type="radio" name="isDiskon" checked> Tidak</label>
									</div>
									<div class="col-md-1 form-group">
										<label><input type="radio" name="isDiskon" checked> Ya</label>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-12">
										<label for="lblDiskonHarga" class="lblDiskonErr">Diskon Harga (Rp)</label>
										<input type="text" class="form-control numberinput" id="diskon_harga" name="diskonHarga" placeholder="Langsung Tulis Angka ex : 50000">
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-12">
										<label for="LblTag" class="lblTagErr">Tag Produk</label>
										<?php
											$list_tag = $this->db->get('tbl_tag_produk')->result();
											foreach ($list_tag as $key => $value) {
												echo '<div class="checkbox">
													<label><input type="checkbox" value="'.$value->id.'">'.$value->nama_tag.'</label>
												</div>';
											} 
										?>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group col-md-12">
										<input type="submit" id="btnSave" class="btn btn-primary" value="Simpan" />
										<a type="button" class="btn btn-default" href="<?= base_url('master_produk_adm'); ?>">Kembali</a>
									</div>
								</div>
							</form> 
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>    
    </section>
    <!-- /.content -->
