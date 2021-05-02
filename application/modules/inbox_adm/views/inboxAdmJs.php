<script type="text/javascript">
	var save_method; //for save method string
	var table;
$(document).ready(function() {
	//datatables
    //tabelFeedback
    table = $('#tabelInbox').DataTable({
        
        "processing": true, //feature control the processing indicator
        "serverSide": true, //feature control DataTables server-side processing mode
        "order":[], //initial no order

        //load data for table content from ajax source
        "ajax": {
            "url": "<?php echo site_url('inbox_adm/inbox_list') ?>",
            "type": "POST" 
        },

        //set column definition initialisation properties
        "columnDefs": [
            {
                "targets": [-1], //last column
                "orderable": false, //set not orderable
            },
        ],
    });

	//set input/textarea/select event when change value, remove class error and remove text help block
	$("input").change(function() {
		$(this).parent().parent().removeClass('has-error');
		$(this).next().empty();
	});

    // select class modal whenever bs.modal hidden
    $(".modal").on("hidden.bs.modal", function(){
        $('#form_inbox')[0].reset(); // reset form on modals
    });
    
});

function detailInbox(id)
{
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('inbox_adm/detail_pesan_masuk/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //ambil data ke json->modal
            $('[name="id"]').val(data.id_pesan);
            $('[name="pengirimInbox"]').val(data.fname_pesan+" "+data.lname_pesan);
            $('[name="pengirimInbox"]').attr('disabled', true);
            $('[name="emailInbox"]').val(data.email_pesan);
            $('[name="emailInbox"]').attr('disabled', true);
            $('[name="subjectInbox"]').val(data.subject_pesan);
            $('[name="subjectInbox"]').attr('disabled', true);
            $('[name="isiInbox"]').val(data.isi_pesan);
            $('[name="isiInbox"]').attr('disabled', true);
            $('.idPesanSpn').text(data.id_pesan);
            $('#modal_detail_inbox').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Detail Email Masuk'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function replyInbox(id)
{
    $('#form_reply_inbox')[0].reset(); // reset form on modals
    $('#modal_detail_inbox').modal('hide');
    var re = "Reply from :";
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('inbox_adm/detail_pesan_masuk/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //ambil data ke json->modal
            $('[name="id"]').val(data.id_pesan);
            $('[name="emailReply"]').val(data.email_pesan);
            $('[name="fnameReply"]').val(data.fname_pesan);
            $('[name="lnameReply"]').val(data.lname_pesan);
            $('[name="emailReply"]').attr('readonly', true);

            //buat variabel str u/ menyimpan data subject
            var str = data.subject_pesan;
            // cek string di variabel str, lalu lakukan aksi condisional
            // bernilai -1 apbila tidak ditemukan string, note CASE SENSITIVE string
            // This works because indexOf() returns -1 if the string wasn't found at all.
            if (str.indexOf("Reply from :") == -1) {
                $('[name="subjectReply"]').val(re+" "+ data.subject_pesan);
            }else{
                $('[name="subjectReply"]').val(data.subject_pesan);
            }
            $('[name="subjectReply"]').attr('readonly', true);
            $('[name="isiReply"]').val("Sehubungan dari pertanyaan sdr "+data.fname_pesan+" "+data.lname_pesan+" Tentang "+data.isi_pesan+", Maka ");
            $('#modal_reply_inbox').modal('show');
            $('.modal-title').text('Balas Pesan');

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function replyInboxModal()
{
    $('#form_reply_inbox')[0].reset(); // reset form on modals
    var re = "Reply from :";
    var id = $('[name="id"]').val();
    $('#modal_detail_inbox').modal('hide');
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('inbox_adm/detail_pesan_masuk/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //ambil data ke json->modal
            $('[name="id"]').val(data.id_pesan);
            $('[name="emailReply"]').val(data.email_pesan);
            $('[name="fnameReply"]').val(data.fname_pesan);
            $('[name="lnameReply"]').val(data.lname_pesan);
            $('[name="emailReply"]').attr('readonly', true);

            //buat variabel str u/ menyimpan data subject
            var str = data.subject_pesan;
            // cek string di variabel str, lalu lakukan aksi condisional
            // bernilai -1 apbila tidak ditemukan string, note CASE SENSITIVE string
            // This works because indexOf() returns -1 if the string wasn't found at all.
            if (str.indexOf("Reply from :") == -1) {
                 $('[name="subjectReply"]').val(re+" "+ data.subject_pesan);
             }else{
                 $('[name="subjectReply"]').val(data.subject_pesan);
             }
            $('[name="subjectReply"]').attr('readonly', true);
            $('[name="isiReply"]').val("Sehubungan dari pertanyaan sdr "+data.fname_pesan+" "+data.lname_pesan+" Tentang "+data.isi_pesan+", Maka ");
            $('#modal_reply_inbox').modal('show');
            $('.modal-title').text('Balas Pesan');

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function simpanReply()
{
    if(confirm('Kirim Pesan ?'))
    {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        // Get form
        var form = $('#form_reply_inbox')[0];
        // Create an FormData object
        var data = new FormData(form);

        // ajax adding data to database
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url : url = "<?php echo site_url('inbox_adm/add_reply_pesan')?>",
            data: data,
            dataType: "JSON",
            processData: false, // false, it prevent jQuery form transforming the data into a query string
            contentType: false, 
            cache: false,
            timeout: 600000,
            success: function(data)
            {

                if(data.status) //if success close modal and reload ajax table
                {
                    alert(data.pesan);
                    $('#btnSave').text('Save'); //change button text
                    $('#btnSave').attr('disabled',false); //set button disable 
                    $('#modal_reply_inbox').modal('hide');
                    reload_table();
                }
            },
            error: function (e) {
                    console.log("ERROR : ", e);
                    $("#btnSave").prop("disabled", false);
            }
        });
    }    
}

function deleteInbox(id)
{
    if(confirm('Yakin Hapus data ini ?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('inbox_adm/delete_inbox')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                alert(data.pesan);
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

</script>	