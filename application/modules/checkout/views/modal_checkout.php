<!-- modal edit_checkout_1 -->
<div class="modal fade" id="modal_checkout1" role="dialog" aria-labelledby="checkout1" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Ubah Alamat Pengiriman</h4>
         </div>
         <div class="modal-body">
            <form id="form_checkout1" name="formCheckout1">
               <div class="form-row">
                  <input type="hidden" name="checkout1Id">
                  <div class="form-group col-md-6">
                     <label for="lblFname" class="lblFnameErr">Nama Depan</label>
                     <input type="text" class="form-control" name="checkout1Fname" placeholder="Nama Depan">
                  </div>
                  <div class="form-group col-md-6">
                     <label for="lblLname" class="lblLnameErr">Nama Belakang</label>
                     <input type="text" class="form-control" name="checkout1Lname" placeholder="Nama Belakang">
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="lblProv" class="lbProfErr">Provinsi</label>
                     <select class="form-control" id="checkout1_prov" name="checkout1Provinsi" style="width: 100%;"></select>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="lblKota" class="lblKotaErr">Kota</label>
                     <select class="form-control" id="checkout1_kota" name="checkout1Kota" style="width: 100%;"></select>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="lblKec" class="lblKecErr">Kecamatan</label>
                     <select class="form-control" id="checkout1_kec" name="checkout1Kecamatan" style="width: 100%;"></select>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="lblKel" class="lblKelErr">Kelurahan</label>
                     <select class="form-control" id="checkout1_kel" name="checkout1Kelurahan" style="width: 100%;"></select>
                  </div>
               </div> 
               <div class="form-group col-md-12">
                  <label for="lblAlmt" class="lblAlmtErr">Alamat</label>
                  <input type="text" class="form-control" name="checkout1Alamat" placeholder="Alamat Rumah">
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="lblTelp" class="lblTelpErr">Nomor Telp</label>
                     <input type="text" class="form-control numberinput" name="checkout1Telp" placeholder="contoh : 08121212112">
                  </div>
                  <div class="form-group col-md-6">
                     <label for="lblKdps" class="lblKdpsErr">Kode Pos</label>
                     <input type="text" class="form-control numberinput" name="checkout1Kdpos" placeholder="contoh : 61789">
                  </div>
               </div>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" id="btnSave" onclick="update_alamat_chckout1()" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
         </div>
      </div>
   </div>
<div>