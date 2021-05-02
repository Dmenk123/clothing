<!--Bootstrap modal -->
<!-- modal_form_order -->
<div class="modal fade" id="modal_confirm_jual" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"></h4>
         </div>
         <div class="modal-body form">
            <form id="form_confirm_jual" name="formConfirmJual">
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label class="lbl-modal">ID Pembelian : </label>
                     <input type="text" class="form-control" id="field_id_beli" name="fieldIdBeli" readonly="">
                     <input type="hidden" class="form-control" id="field_email_customer" name="fieldEmailCustomer">
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label class="lbl-modal">User : </label>
                     <input type="text" class="form-control" id="form_user" name="fieldUser" value="<?php echo $this->session->userdata('fname_user')." ".$this->session->userdata('lname_user');?>" readonly>
                     <input type="hidden" class="form-control" id="form_id_user" name="fieldIdUser" value="<?php echo $this->session->userdata('id_user');?>" readonly>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="lblGambar" class="lblGambarErr">Bukti Gambar Konfirmasi Administrasi</label>
                     <br>
                     <label>
                        <span id="txt_wajib_det1" style="color: red;font-weight: bold">Wajib Diisi !!</span>
                        <input type="file" id="bukti_confirm" name="buktiConfirm" accept=".png, .jpg, .jpeg">
                     </label>
                     <span style="font-weight: normal; font-style: italic;" class="txtBuktiConfirm"></span>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <input type="checkbox" class="form-check-input" id="cfrm_check" name="cfrmCheck" value="agree"> 
                     <label class="form-check-label" for="checkConfirm">Saya telah memastikan data telah valid.</label>
                  </div>
               </div>
            </form> <!-- form -->
         </div> <!-- modal body -->
         <div class="modal-footer">
            <button type="button" id="btnSave" onclick="saveKonfirmasi()" class="btn btn-primary">Save</button>
            <button type="reset" id="btn_cancel_order" class="btn btn-danger" data-dismiss="modal">Cancel</button>
         </div>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- modal_gambar_detail -->
<div class="modal fade" id="modal_gambar_detail" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding-bottom: 0px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <p class="txtJudul" style="font-size: 20px;"></p>
            </div>
            <div class="modal-body form">
               <div class="col-xs-s12">
                  <img id="imgGbrDetail" src="" class="gbrDetailPenjualanModal">
               </div>
            </div> <!-- modal body -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->