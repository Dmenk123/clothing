<!-- Bootstrap modal -->
<div class="modal fade" id="modal_pesan" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title"></h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_pesan" class="form-horizontal" name="formPesan">
                    <input type="hidden" value="" name="id"/>
                    <input name="idUser" class="form-control" type="hidden" value="<?php echo $this->session->userdata('id_user');?>">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Kirim Email Kepada</label>
                            <div class="col-md-9">
                                <input name="emailPesan" placeholder="Email Pesan" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Subject Pesan</label>
                            <div class="col-md-9">
                                <input name="subjectPesan" placeholder="Subject Pesan" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Isi Pesan</label>
                            <div class="col-md-9">
                                <textarea name="isiPesan" placeholder="Isi Pesan" class="form-control" rows="6"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group" id="fgroup_attach">
                            <label class="control-label col-md-3">Attachment</label>
                            <div class="col-md-9">
                                <input type="file" id="attach_pesan" name="attachPesan">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="simpan_pesan()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->