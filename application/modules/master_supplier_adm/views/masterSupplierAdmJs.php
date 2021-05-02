<script type="text/javascript">
	var save_method; //for save method string
	var table;
$(document).ready(function() {

    //force integer input in textfield
    $('input.numberinput').bind('keypress', function (e) {
        return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

	//datatables
	table = $('#tabelSupplier').DataTable({
		
		"processing": true, //feature control the processing indicator
		"serverSide": true, //feature control DataTables server-side processing mode
		"order":[], //initial no order

		//load data for table content from ajax source
		"ajax": {
			"url": "<?php echo site_url('master_supplier_adm/list_supplier') ?>",
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

    //validasi form kategori
    $("[name='formSupplier']").validate({
        // Specify validation rules
        errorElement: 'span',
        /*errorLabelContainer: '.errMsg',*/
        errorPlacement: function(error, element) {
            if (element.attr("name") == "namaSupplier") {
                error.insertAfter(".lblNameErr");
            } else if (element.attr("name") == "alamatSupplier") {
                error.insertAfter(".lblAlamatErr");
            } else if (element.attr("name") == "telpSupplier") {
                error.insertAfter(".lblTelpErr");
            } else if (element.attr("name") == "ketSupplier") {
                error.insertAfter(".lblKetErr");
            } else {
                error.insertAfter(element);
            }
        },
            rules:{
                namaSupplier: "required",
                alamatSupplier: "required",
                telpSupplier: {
                    required: true,
                    minlength: 7
                },
                ketSupplier: "required",
            },
            // Specify validation error messages
            messages: {
                namaSupplier: " (Harus diisi !!)",
                alamatSupplier: " (Harus diisi !!)",
                telpSupplier: {
                    required: " (Harus diisi !!)",
                    minlength: " (Akronim anda setidaknya minimal 7 karakter !!)"
                },
                ketSupplier: " (Harus diisi !!)",
            },
            submitHandler: function(form) {
              form.submit();
            }
    });

    // select class modal whenever bs.modal hidden
    $(".modal").on("hidden.bs.modal", function(){
        $('#form_supplier')[0].reset(); // reset form on modals
        $("[name='formSupplier']").validate().resetForm();
    });

    //change supplier status
    $(document).on('click', '.btn_edit_status', function(){
        if(confirm('Apakah anda yakin ubah status Supplier ini ?'))
        {
            var id = $(this).attr('id');
            var status = $(this).text();
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('master_supplier_adm/edit_status_supplier')?>/"+id,
                type: "POST",
                dataType: "JSON",
                data : {status : status},
                success: function(data)
                {
                    alert(data.pesan);
                    reload_table();
                },
                error: function (e) {
                    console.log("ERROR : ", e);
                }
            });
        }   
    });

});	

function add_supplier()
{
    save_method = 'add';
	$('#modal_supplier_form').modal('show'); //show bootstrap modal
	$('.modal-title').text('Add Supplier'); //set title modal
}

function edit_supplier(id)
{
    save_method = 'update';
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('master_supplier_adm/edit_master_supplier')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //ambil data ke json->modal
            $('[name="idSupplier"]').val(data.id_supplier);
            $('[name="namaSupplier"]').val(data.nama_supplier);
            $('[name="alamatSupplier"]').val(data.alamat_supplier);
            $('[name="ketSupplier"]').val(data.keterangan);
            $('[name="telpSupplier"]').val(data.telp_supplier);         
            $('#modal_supplier_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Supplier'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function saveSupplier()
{
    var url;
    if(save_method == 'add') {
        url = "<?php echo site_url('master_supplier_adm/add_master_supplier')?>";
    } else {
        url = "<?php echo site_url('master_supplier_adm/update_master_supplier')?>";
    }

    var IsValid = $("form[name='formSupplier']").valid();
    if(IsValid)
    {
        $("#btnSave").prop("disabled", true);
        $('#btnSave').text('saving...'); //change button text
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form_supplier').serialize(),
            dataType: "JSON",
            success: function (data) {
                if (data.status) {
                    alert(data.pesan);
                    $("#btnSave").prop("disabled", false);
                    $("#btnSave").text('Save'); //change button text
                    $('#modal_supplier_form').modal('hide');
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

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

</script>	