<!-- modal add_detail_produk -->
<div class="modal fade" id="modal_produk_detail" role="dialog" aria-labelledby="add_detail_produk" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
         </div>
         <div class="modal-body">
            <form id="form_produk_detail" name="formProdukDetail">
               <input type="hidden" name="idProdukDet">
               <input type="hidden" name="idProduk" id="id_produk" value="<?php echo $this->uri->segment(3); ?>">   
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="lblUkuranDetail" class="lblUkuranDetErr">Ukuran Produk</label>
                     <select class="form-control" id="ukuran_produk_det" name="ukuranProdukDet" style="width: 100%;">
                        <option value="">Pilih Ukuran Produk</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                        <option value="XXL">XXL</option>
                     </select>
                  </div>
               </div>                  
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="lblBeratDetail" class="lblBeratDetErr">Berat Satuan (Gram)</label>
                     <input type="text" class="form-control numberinput" name="beratSatuanDet" id="berat_satuan_det" placeholder="Berat Satuan">
                  </div>
               </div>              
               <div class="form-row">
                  <?php if ($this->session->userdata('id_level_user') == '1') { ?>
                     <div class="form-group col-md-6">
                        <label for="lblStokAwalDetail" class="lblStokAwalDetErr">Stok Awal</label>
                        <input type="text" class="form-control numberinput" name="stokAwalDet" id="stok_awal_det" placeholder="Stok Awal">
                     </div>
                  <?php } else { ?>
                     <div class="form-group col-md-6">
                        <label for="lblStokAwalDetail" class="lblStokAwalDetErr">Stok Awal</label>
                        <input type="text" class="form-control numberinput" name="stokAwalDet" id="stok_awal_det" placeholder="Stok Awal" disabled>
                     </div>
                  <?php } ?>
                  
                  <div class="form-group col-md-6">
                     <label for="lblStokMinDetail" class="lblStokMinDetErr">Stok Minimum</label>
                     <input type="text" class="form-control numberinput" name="stokMinDet" id="stok_min_det" placeholder="Stok Minimum">
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" id="btnSaveDetail" onclick="saveProdukDetail()" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
         </div>
      </div>
   </div>
<div>