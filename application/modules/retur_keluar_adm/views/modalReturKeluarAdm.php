<!--Bootstrap modal -->
<!-- modal_form_order -->
<div class="modal fade" id="modal_ret_keluar" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"></h4>
         </div>
         <div class="modal-body form">
            <form id="form_ret_keluar" name="formRetKeluar">
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label class="lbl-modal">ID Retur Keluar : </label>
                     <input type="text" class="form-control" id="form_id_ret_keluar" name="formIdRetKeluar" readonly="">
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label class="lbl-modal">User : </label>
                     <input type="text" class="form-control" id="form_user_ret_keluar" name="formUserRetKeluar" value="<?php echo $this->session->userdata('fname_user')." ".$this->session->userdata('lname_user');?>" readonly>
                     <input type="hidden" class="form-control" id="form_id_user_ret_keluar" name="formIdUserRetKeluar" value="<?php echo $this->session->userdata('id_user');?>" readonly>
                  </div>
               </div>
               <div class="form-row">           
                  <div class="form-group col-md-6">
                     <label class="lblIdTerimaErr">ID Penerimaan : </label>
                     <select name="formIdTerima" class="form-control" id="form_id_terima" style="width:100%;">
                        <option value="">Pilih ID Penerimaan</option>
                     </select>
                  </div>
                  <div class="form-group col-md-6">
                     <label class="lbl-modal">Supplier : </label>
                     <input type="text" class="form-control" id="form_supplier_ret_keluar" name="formSupplierRetKeluar" value="" readonly>
                     <input type="hidden" class="form-control" id="form_id_supplier_ret_keluar" name="formIdSupplierRetKeluar" value="" readonly>
                  </div>
               </div>
               <br />
               <div class="form-group" style="padding-bottom: 20px;">
                  <table id="tabel_retur_keluar" class="table table-bordered table-hover">
                     <thead>
                        <tr>
                           <th style="text-align:center; width: 300px;">Nama Produk</th>
                           <th style="text-align:center; width: 100px;">Satuan</th>
                           <th style="text-align:center; width: 100px;">Jumlah</th>
                           <th style="text-align:center; width: 100px;">Size</th>
                           <th style="text-align:center; width: 300px;">Keterangan</th>
                           <th style="text-align:center; width: 50px;">AKSI</th>
                        </tr>
                     </thead>
                     <tbody>
                     </tbody> <!-- tbody -->
                  </table> <!-- table --> 
               </div> <!-- form group -->
            </form> <!-- form -->
         </div> <!-- modal body -->
         <div class="modal-footer">
            <button type="button" id="btnSave" onclick="saveRetMasuk()" class="btn btn-primary">Save</button>
            <button type="reset" id="btn_cancel_order" class="btn btn-danger" data-dismiss="modal">Cancel</button>
         </div>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
</div><!-- /.modal