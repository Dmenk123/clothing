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
		<!-- flashdata -->
		<?php if ($this->session->flashdata('feedback_success')) { ?>
			<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h4><i class="icon fa fa-check"></i> Berhasil!</h4>
				<?= $this->session->flashdata('feedback_success') ?>
			</div>
		<?php } elseif ($this->session->flashdata('feedback_failed')) { ?>
			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h4><i class="icon fa fa-remove"></i> Gagal!</h4>
				<?= $this->session->flashdata('feedback_failed') ?>
			</div>
		<?php } ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
				<form action="<?= base_url('master_produk_adm/simpan_diskon'); ?>" method="post">
					<div class="form-row">
						<input type="hidden" name="idProduk" value="<?= $hasil_header->id_produk; ?>">
						<input type="hidden" name="hargaProduk" value="<?= $hasil_header->harga; ?>">
						<div class="form-group col-md-12">
							<label for="lblName" class="lblNamaErr">Nama Produk</label>
							<input type="text" class="form-control" name="namaProduk" value="<?=$hasil_header->nama_produk;?>" placeholder="Nama Produk" readonly>
						</div>
					</div>                  
					<div class="form-row">
						<div class="form-group col-md-2">
							<label for="lblSubKategori">Apakah Diskon ?</label>
						</div>
						<div class="col-md-1 form-group">
							<label><input type="radio" name="isDiskon" value="0" <?php if($hasil_header->is_diskon == '0'){echo 'checked';}?>> Tidak</label>
						</div>
						<div class="col-md-1 form-group">
							<label><input type="radio" name="isDiskon" value="1" <?php if($hasil_header->is_diskon == '1'){echo 'checked';}?>> Ya</label>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="lblDiskonHarga" class="lblDiskonErr">Diskon Harga (Rp)</label>
							<input type="text" class="form-control numberinput" id="diskon_harga" name="diskonHarga" placeholder="Langsung Tulis Angka ex : 50000" value="<?php if($hasil_header->diskon_harga) {echo (int)$hasil_header->diskon_harga;}else{echo '';} ?>">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-12">
							<label for="LblTag" class="lblTagErr">Tag Produk</label>
							<?php
								$list_tag = $this->db->get('tbl_tag_produk')->result();
								$data_list = [];
								foreach ($list_tag as $kk => $vv) {
									$data_list[$vv->id] = $vv->nama_tag;
								}

								ksort($data_list);

								// dari db
								$arr_data = [];
								if($hasil_header->tag_produk) {
									$data_json = json_decode($hasil_header->tag_produk);
									foreach ($data_json as $kk => $vv) {
										$arr_data[$vv] = $vv;
									}

									ksort($arr_data);
								}

								foreach ($data_list as $key => $value) {
									if(isset($arr_data[$key])) {
										if ($key == $arr_data[$key]) {
											echo '<div class="checkbox">
												<label>
													<input name="tagProduk[]" type="checkbox" value="' . $key . '" checked>' . $value . '
												</label>
											</div>';
										} else {
											echo '<div class="checkbox">
												<label>
													<input name="tagProduk[]" type="checkbox" value="' . $key . '">' . $value . '
												</label>
											</div>';
										}
									}else{
										echo '<div class="checkbox">
											<label>
												<input name="tagProduk[]" type="checkbox" value="' . $key . '">' . $value . '
											</label>
										</div>';
									}
									
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
