<!-- modal add_user -->
<div class="modal fade" id="modal_kategori_form" role="dialog" aria-labelledby="add_user" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title"></h4>
         </div>
         <div class="modal-body">
            <form id="form_kategori" name="formKategori">
               <div class="form-row">
                  <input type="hidden" name="idKategori">
                  <div class="form-group col-md-12">
                     <label for="lblNama" class="lblNameErr">Nama Kategori 
                        <span style="color: blue; font-style: italic;">(Disarankan huruf awal menggunakan huruf kapital, agar seragam terhadap database)</span>
                     </label>
                     <input type="text" class="form-control" name="namaKategori" placeholder="Nama Kategori">
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="lblKeterangan" class="lblKeteranganErr">Keterangan 
                        <span style="color: blue; font-style: italic;">(Disarankan huruf awal menggunakan huruf kapital, agar seragam terhadap database)</span>
                     </label> 
                     <input type="text" class="form-control" name="keteranganKategori" placeholder="Keterangan Kategori">
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="lblAkronim" class="lblAkronimErr">Akronim (Untuk Singkatan Kategori)</label>
                     <input type="text" class="form-control" name="akronimKategori" placeholder="Akronim"  maxlength="3">
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <div class="col-md-12">
               <button type="button" id="btnSave" onclick="saveKategori()" class="btn btn-primary">Save</button>
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
         </div>
      </div>
   </div>
<div>