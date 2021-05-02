<!-- modal add_user -->
<div class="modal fade" id="modal_subkategori_form" role="dialog" aria-labelledby="add_user" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
         </div>
         <div class="modal-body">
            <form id="form_sub_kategori" name="formSubKategori">
               <div class="form-row">
                  <input type="hidden" name="idSubKategori">
                  <input type="hidden" name="idKategori" value="<?php echo $this->uri->segment(3); ?>">
                  <div class="form-group col-md-12">
                     <label for="lblNama" class="lblNameErr">Nama Sub Kategori 
                        <span style="color: blue; font-style: italic;">(Disarankan huruf awal menggunakan huruf kapital, agar seragam terhadap database)</span>
                     </label>
                     <input type="text" class="form-control" name="namaSubKategori" placeholder="Nama Sub Kategori">
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="lblKeterangan" class="lblKeteranganErr">Keterangan 
                        <span style="color: blue; font-style: italic;">(Disarankan huruf awal menggunakan huruf kapital, agar seragam terhadap database)</span>
                     </label> 
                     <input type="text" class="form-control" name="keteranganSubKategori" placeholder="Keterangan Kategori">
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="lblGender" class="lblGenderErr">Gender
                        <span style="color: blue; font-style: italic;">(Disarankan huruf awal menggunakan huruf kapital, agar seragam terhadap database)</span>
                     </label>
                     <input type="text" class="form-control" name="genderSubKategori" placeholder="Gender">
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <div class="col-md-12">
               <button type="button" id="btnSaveSub" onclick="saveSubKategori()" class="btn btn-primary">Save</button>
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
         </div>
      </div>
   </div>
<div>