<!-- modal add_user -->
<div class="modal fade" id="modal_tag_form" role="dialog" aria-labelledby="add_user" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
         </div>
         <div class="modal-body">
            <form id="form_tag" name="formTag">
               <div class="form-row">
                  <input type="hidden" name="idTag">
                  <div class="form-group col-md-12">
                     <label for="lblNama" class="lblNameErr">Nama Tag 
                        <span style="color: blue; font-style: italic;"></span>
                     </label>
                     <input type="text" class="form-control" name="namaTag" placeholder="Nama Tag">
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="lblWarna" class="lblWarnaErr">Warna Label
                        <span style="color: blue; font-style: italic;"></span>
                     </label> 
							<div class="picker" id="picker1" style="width: 200px;height: 100px;"></div>
                     <input type="text" class="form-control" name="warnaTag">
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <div class="col-md-12">
               <button type="button" id="btnSave" onclick="saveTag()" class="btn btn-primary">Save</button>
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
         </div>
      </div>
   </div>
<div>
