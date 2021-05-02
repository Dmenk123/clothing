<!-- modal add_user -->
<div class="modal fade" id="modal_supplier_form" role="dialog" aria-labelledby="add_user" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
         </div>
         <div class="modal-body">
            <form id="form_supplier" name="formSupplier">
               <div class="form-row">
                  <input type="hidden" name="idSupplier">
                  <div class="form-group col-md-12">
                     <label for="lblNama" class="lblNameErr">Nama Supplier</label>
                     <input type="text" class="form-control" name="namaSupplier" placeholder="Nama Supplier">
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="lblAlamat" class="lblAlamatErr">Alamat Supplier</label>
                     <textarea name="alamatSupplier" id="alamat_supplier" rows="3" class="form-control"></textarea>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="lblKet" class="lblKetErr">Keterangan</label> 
                     <input type="text" class="form-control" name="ketSupplier" placeholder="Keterangan supplier">
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="lblTelp" class="lblTelpErr">Nomor Telepon</label> 
                     <input type="text" class="form-control numberinput" name="telpSupplier" placeholder="Nomor Telepon">
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <div class="col-md-12">
               <button type="button" id="btnSave" onclick="saveSupplier()" class="btn btn-primary">Save</button>
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
         </div>
      </div>
   </div>
<div>