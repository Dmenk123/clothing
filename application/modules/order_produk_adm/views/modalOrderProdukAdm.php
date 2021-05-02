<!-- Bootstrap modal -->
<!-- modal_form_order -->
<div class="modal fade" id="modal_form_order" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"></h4>
         </div>
         <div class="modal-body form">
            <form id="form_order" name="formOrder">
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label class="lbl-modal">ID Order : </label>
                     <input type="text" class="form-control" id="form_id_order" name="fieldIdOrder" readonly="">
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label class="lbl-modal">User : </label>
                     <input type="text" class="form-control" id="form_user_order" name="fieldUserOrder" value="<?php echo $this->session->userdata('fname_user')." ".$this->session->userdata('lname_user');?>" readonly>
                     <input type="hidden" class="form-control" id="form_id_user_order" name="fieldIdUserOrder" value="<?php echo $this->session->userdata('id_user');?>" readonly>
                  </div>
               </div>
               <div class="form-row">           
                  <div class="form-group col-md-12">
                     <label class="lblSupErr">Supplier : </label>
                     <select name="fieldSupplier" class="form-control" id="field_supplier" style="width:100%;">
                        <option value="">Pilih nama Supplier</option>
                        <?php $query = $this->db->get('tbl_supplier')->result(); ?>
                        <?php foreach ($query as $value) { ?>
                           <option value="<?php echo $value->id_supplier; ?>"><?php echo $value->nama_supplier; ?></option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
               <br />
               <div class="form-group" style="padding-bottom: 20px;">
                  <table id="tabel_order" class="table table-bordered table-hover">
                     <thead>
                        <tr>
                           <th style="text-align:center; width: 320px;" >Nama Produk</th>
                           <th style="text-align:center; width: 80px;">Satuan</th>
                           <th style="text-align:center; width: 70px;">Jumlah</th>
                           <th style="text-align:center; width: 80px;">Size</th>
                           <th style="text-align:center; width: 140px;">Harga Sebelumnya</th>
                           <th style="text-align:center; width: 140px;">Harga Satuan</th>
                           <th style="text-align:center; width: 140px;">Harga Total</th>
                           <th style="text-align:center">AKSI</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           <td class="tdIsi">
                              <div class="form-group">
                                 <input type="text" name="formNamaProdukOrder" class="form-control" id="form_nama_produk_order"/>
                                 <input type="hidden" name="formIdProdukOrder" class="form-control" id="form_id_produk_order"/>
                                 <input type="hidden" name="formIdOrder" class="form-control" id="form_id_order"/>
                              </div>
                           </td>
                           <td class="tdIsi">
                              <div class="form-group">
                                 <input type="text" name="formNamaSatuanOrder" class="form-control" id="form_nama_satuan_order" readonly=""/>
                                 <input type="hidden" name="formIdSatuanOrder" class="form-control" id="form_id_satuan_order"/>
                              </div>    
                           </td>
                           <td class="tdIsi">
                              <div class="form-group">
                                 <input type="text" name="formJumlahProdukOrder" class="form-control numberinput" id="form_jumlah_produk_order"/>
                             </div>
                           </td>
                           <td class="tdIsi">
                              <div class="form-group">
                                 <select name="formSizeProdukOrder" id="form_size_produk_order" class="form-control"></select>
                                 <input type="hidden" name="formIdStokOrder" class="form-control" id="form_id_stok_order"/>
                             </div>
                           </td>
                           <td class="tdIsi">
                              <div class="form-group">
                                 <input type="text" name="formHargaPrevOrder" class="form-control numberinput" id="form_harga_prev_order" readonly/>
                             </div>    
                           </td>
                           <td class="tdIsi">
                              <div class="form-group">
                                 <input type="text" name="formHargaSatOrder" class="form-control numberinput" id="form_harga_sat_order"/>
                             </div>    
                           </td>
                           <td class="tdIsi">
                              <div class="form-group">
                                 <input type="text" name="formHargaTotOrder" class="form-control numberinput" id="form_harga_tot_order" readonly/>
                             </div>    
                           </td>
                           <td class="tdIsi">
                              <button type="button" name="btnAddRow" id="btn_add_row" class="btn btn-small btn-default">+</button>
                           </td>
                        </tr>
                     </tbody> <!-- tbody -->
                  </table> <!-- table --> 
               </div> <!-- form group -->
            </form> <!-- form -->
         </div> <!-- modal body -->
         <div class="modal-footer">
            <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
            <button type="reset" id="btn_cancel_order" class="btn btn-danger" data-dismiss="modal">Cancel</button>
         </div>
      </div><!-- /.modal-content -->
   </div><!-- /.modal-dialog -->
</div><!-- /.modal -->