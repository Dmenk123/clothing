<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<?php $this->db->select('
                            tbl_produk.id_produk,
                            tbl_produk.id_sub_kategori,
                            tbl_produk.nama_produk,
                            tbl_produk.harga,
							tbl_produk.slug,
                            tbl_gambar_produk.nama_gambar
                        ');
$this->db->from('tbl_gambar_produk');
$this->db->join('tbl_produk', 'tbl_gambar_produk.id_produk = tbl_produk.id_produk', 'left');
$this->db->where('tbl_gambar_produk.jenis_gambar', 'display');
$this->db->where('tbl_produk.status', '1');
$this->db->order_by('tbl_gambar_produk.id_gambar', 'desc');
$this->db->limit(5);
$query = $this->db->get(''); ?>

<div id="hot">

	<div class="box">
		<div class="container">
			<div class="row col-md-12" style="display:flex;flex-wrap:wrap;">
				<?php foreach ($query->result() as $key => $val) {
					if (($key + 0) % 2 == 0) {
						echo '<div class="row col-md-12" style="display:flex;flex-wrap:wrap;">';
					}
				?>
					<div class="col-md-6" style="width: calc(50% - 1rem);">
					<!-- <div class="col-md-6"> -->
						<div class="card">
							<!-- <div class="card-head">
								<img src="<?php echo config_item('assets'); ?>img/produk/<?php echo $val->nama_gambar; ?>" alt="" class="img-responsive2">

							</div> -->
							<div class="card-body">
								<div class="product-desc">
									<span class="product-title">
										<!-- Hartbee<b>Sport</b> -->
										<span class="badge">
											New
										</span>
									</span>
									<span class="product-caption">
										Basket ball collection
									</span>
									<span class="product-rating">
										<i class="fa fa-star yellow"></i>
										<i class="fa fa-star yellow"></i>
										<i class="fa fa-star yellow"></i>
										<i class="fa fa-star yellow"></i>
										<i class="fa fa-star grey"></i>
									</span>
								</div>
								<div class="product-properties">
									<span class="product-size">
										<h4><b>Rp. 350.000<b></h4>
										<!-- <ul class="ul-size">
												<li><a href=""></a>7</li>
												<li><a href=""></a>8</li>
												<li><a href=""></a>9</li>
												<li><a href="" class="active"></a>10</li>
												<li><a href=""></a>11</li>
											</ul> -->
									</span>
									<!-- <span class="product-color">
											<h4>Colors</h4>
											<ul class="ul-color">
												<li><a href="" class="orange"></a></li>
												<li><a href="" class="green"></a></li>
												<li><a href="" class="yellow"></a></li>
											</ul>
											</span> -->
									<br>
									<!-- <span class="product-price">
										<b>Beli Sekarang</b>
									</span> -->
								</div>
							</div>
						</diV>
					</div>

					<?php
					if (($key + 1) % 2 == 0) {
						echo '</div>';
					}
					?>
				<?php } ?>

			</div>

			<!-- </div> -->
		</div>


		<!-- /.container -->
	</div>
