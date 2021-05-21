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
                  <div class="form-group col-6">
                     <label class="lbl-modal">Order ID : </label>
                     <input type="text" class="form-control" id="field_order_id" name="fieldOrderId" readonly="">
							<span class="help-block"></span>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-6">
                     <label class="lbl-modal">Customer : </label>
                     <input type="text" class="form-control" id="field_nama" name="fieldNama" value="" readonly>
							<span class="help-block"></span>
                  </div>
               </div>
               <div class="form-row">
						<div class="col-12 form-group">
							<label class="control-label col-12">Email Tujuan</label>
                    	<input type="text" class="form-control" id="field_email" value="" name="fieldEmail" readonly>
                    	<span class="help-block"></span>
                  </div>
					</div>
					<div class="form-row">
						<div class="col-12 form-group">
							<label class="control-label col-12">Subjek Email</label>
                    	<input type="text" class="form-control" value="Pembayaran Telah Dikonfirmasi" id="subjek_email" name="subjekEmail">
                    	<span class="help-block"></span>
                  </div>
					</div>
					<div class="form-row">
						<div class="col-12">
                  	<label class="control-label col-12">Pesan : </label>
                    	<textarea class="form-control" id="pesan_email" rows="10" name="pesanEmail"></textarea>
                    <span class="help-block"></span>
                  </div>
                </div>
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <input type="checkbox" class="form-check-input" id="cfrm_check" name="cfrmCheck" value="agree"> 
                     <label class="form-check-label" for="checkConfirm">Saya telah memastikan data telah valid.</label>
                  </div>
               </div>
					<div id="toni"></div>
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
