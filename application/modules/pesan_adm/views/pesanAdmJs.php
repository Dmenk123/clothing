<script type="text/javascript">
	var save_method; //for save method string
	var table;
$(document).ready(function() {
	//datatables
    //tabelFeedback
    table = $('#tabelPesan').DataTable({
        
        "processing": true, //feature control the processing indicator
        "serverSide": true, //feature control DataTables server-side processing mode
        "order":[], //initial no order

        //load data for table content from ajax source
        "ajax": {
            "url": "<?php echo site_url('pesan_adm/pesan_list') ?>",
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

    //jquery validation
        $("form[name='formPesan']").validate({
            // Specify validation rules
            errorElement: 'div',
            rules:{
                isiPesan: "required",
                subjectPesan: "required",
                emailPesan: {
                    required: true,
                    email: true
                }
            },
            // Specify validation error messages
            messages: {
                isiPesan: "Isi Pesan required",
                subjectPesan: "Subject Pesan is required",
                emailPesan: "Valid email is required",
            },
            submitHandler: function(form) {
              form.submit();
            }
        });

    //validasi format email
    $("[name='emailPesan']").focusout(function(){
        var isi = $('#emailPesan').val();
        $("[name='emailPesan']").filter(function(){
            var emil = $("[name='emailPesan']").val();
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if( !emailReg.test( emil ) ) {
                alert('Format email anda tidak valid');
                $("[name='emailPesan']").val(isi);
            }
        })
    });

    // select class modal whenever bs.modal hidden
    $(".modal").on("hidden.bs.modal", function(){
        $('#form_pesan')[0].reset(); // reset form on modals
        $('#fgroup_attach').removeClass('hidden');
        $('[name="emailPesan"]').attr('disabled', false);
        $('[name="subjectPesan"]').attr('disabled', false);
        $('[name="isiPesan"]').attr('disabled', false);
        $('#btnSave').attr('disabled', false);
        $('[name="formPesan"]').validate().resetForm();
    });

});	

function addPesan() 
{
	$('#modal_pesan').modal('show'); //show bootstrap modal
	$('.modal-title').text('Tulis Pesan'); //set title modal
}

function detailPesan(id)
{
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('pesan_adm/detail_pesan_keluar/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //ambil data ke json->modal
            $('[name="id"]').val(data.id_reply);
            $('[name="idUser"]').val(data.id_user);
            $('[name="emailPesan"]').val(data.email_reply);
            $('[name="emailPesan"]').attr('disabled', '');
            $('[name="subjectPesan"]').val(data.subject_reply);
            $('[name="subjectPesan"]').attr('disabled', '');
            $('[name="isiPesan"]').val(data.isi_reply);
            $('[name="isiPesan"]').attr('disabled', '');
            $('#btnSave').attr('disabled', '');
            $('#modal_pesan').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Detail Pesan Terkirim'); // Set title to Bootstrap modal title

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


function simpan_pesan()
{
    var IsValid = $("form[name='formPesan']").valid();
    if(IsValid)
    {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        // Get form
        var form = $('#form_pesan')[0];
        // Create an FormData object
        var data = new FormData(form);

        // ajax adding data to database
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url : url = "<?php echo site_url('pesan_adm/add_pesan_keluar')?>",
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
                    $('#modal_pesan').modal('hide');
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

function detailPesan(id)
{
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('pesan_adm/detail_pesan_keluar/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //ambil data ke json->modal
            $('[name="id"]').val(data.id_reply);
            $('[name="idUser"]').val(data.id_user);
            $('[name="emailPesan"]').val(data.email_reply);
            $('[name="emailPesan"]').attr('disabled', true);
            $('[name="subjectPesan"]').val(data.subject_reply);
            $('[name="subjectPesan"]').attr('disabled', true);
            $('[name="isiPesan"]').val(data.isi_reply);
            $('[name="isiPesan"]').attr('disabled', true);
            $('#fgroup_attach').addClass('hidden');
            $('#btnSave').attr('disabled', true);
            $('#modal_pesan').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Detail Email Terkirim'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function deletePesan(id)
{
    if(confirm('Yakin Hapus data ini ?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('pesan_adm/delete_pesan_keluar')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                //$('#modal_feedback').modal('hide');
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