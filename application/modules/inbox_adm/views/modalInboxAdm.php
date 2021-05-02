<!-- Bootstrap modal -->
<!--modal detail inbox -->
<div class="modal fade" id="modal_detail_inbox" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title"></h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_inbox" class="form-horizontal" name="formInbox">
                    <input type="hidden" value="" name="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Pesan Dari</label>
                            <div class="col-md-9">
                                <input name="pengirimInbox" placeholder="Pesan Dari" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Email</label>
                            <div class="col-md-9">
                                <input name="emailInbox" placeholder="Email Inbox" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Subject Pesan</label>
                            <div class="col-md-9">
                                <input name="subjectInbox" placeholder="Subject Pesan" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Isi Pesan</label>
                            <div class="col-md-9">
                                <textarea name="isiInbox" placeholder="Isi Pesan" class="form-control" rows="6"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnReply" onclick="replyInboxModal()" class="btn btn-primary">Reply</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

<!-- Bootstrap modal -->
<!--modal reply inbox -->
<div class="modal fade" id="modal_reply_inbox" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title"></h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form_reply_inbox" class="form-horizontal" name="formReply">
                    <input type="hidden" value="" name="id"/>
                    <input name="idUser" class="form-control" type="hidden" value="<?php echo $this->session->userdata('id_user');?>">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">Kirim Email Kepada</label>
                            <div class="col-md-9">
                                <input name="emailReply" placeholder="Email Pesan" class="form-control" type="text">
                                <input name="fnameReply" type="hidden">
                                <input name="lnameReply" type="hidden">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Subject Pesan</label>
                            <div class="col-md-9">
                                <input name="subjectReply" placeholder="Subject Pesan" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Isi Pesan</label>
                            <div class="col-md-9">
                                <textarea name="isiReply" placeholder="Isi Pesan" class="form-control" rows="6"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group" id="fgroup_attach">
                            <label class="control-label col-md-3">Attachment</label>
                            <div class="col-md-9">
                                <input type="file" id="attach_reply" name="attachReply">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="simpanReply()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->