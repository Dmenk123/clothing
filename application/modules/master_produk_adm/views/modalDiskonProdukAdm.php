<!-- modal diskon_produk -->
<div class="modal fade" id="modal_diskon_form" role="dialog" aria-labelledby="add_produk" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
         </div>
         <div class="modal-body">
            <form id="form_diskon" name="formDiskon">
               <div class="form-row">
                  <input type="hidden" name="idProduk">
                  <div class="form-group col-md-12">
                     <label for="lblName" class="lblNamaErr">Nama Produk</label>
                     <input type="text" class="form-control" name="namaProduk" placeholder="Nama Produk" readonly>
                  </div>
               </div>                  
               <div class="form-row">
                  <div class="form-group col-md-12 radio">
							<label for="lblSubKategori">Apakah Diskon ?</label>
							<label><input type="radio" name="isDiskon" checked>Tidak</label>
							<label><input type="radio" name="isDiskon" checked>Ya</label>
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
							<select class="form-control select2_multi" id="selReg" name="list_item_reg[]" multiple="multiple">
                      <?php
							 	$list_tag = $this->db->get('tbl_tag_produk')->result();
							 	foreach ($list_tag as $key => $value) {
									echo '<option value="'.$value->id.'">'.$value->nama_tag.'</option>';
								} 
							 ?>
                    </select>
                  </div>
               </div>                  
               <div class="form-group col-md-12">
                  <label for="lblBahan" class="lblBahanErr">Bahan</label>
                  <input type="text" class="form-control" name="bahanProduk" placeholder="Bahan Produk">
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" id="btnSave" onclick="saveDiskon()" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
         </div>
      </div>
   </div>
<div>
