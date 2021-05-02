<!-- ambil uri segment 3 -->
<?php $val_url = $this->uri->segment(3); ?>
<script type="text/javascript">
	var save_method; //for save method string
	var table;
    var table2;
    var idKategori = "<?php echo $val_url; ?>";
$(document).ready(function() {

    //force integer input in textfield
    $('input.numberinput').bind('keypress', function (e) {
        return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

	//datatables
	table = $('#tabelKategori').DataTable({
		
		"processing": true, //feature control the processing indicator
		"serverSide": true, //feature control DataTables server-side processing mode
		"order":[], //initial no order

		//load data for table content from ajax source
		"ajax": {
			"url": "<?php echo site_url('master_kategori_adm/list_kategori') ?>",
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

    //datatables
    table2 = $('#tabelSubKategori').DataTable({
        
        "processing": true, 
        "serverSide": true, 
        "order":[], 

        "ajax": {
            "url": "<?php echo site_url('master_kategori_adm/list_sub_kategori/') ?>"+idKategori,
            "type": "POST" 
        },

        "columnDefs": [
            {
                "targets": [-1], 
                "orderable": false, 
            },
        ],
    });

    //validasi form kategori
    $("[name='formKategori']").validate({
        // Specify validation rules
        errorElement: 'span',
        /*errorLabelContainer: '.errMsg',*/
        errorPlacement: function(error, element) {
            if (element.attr("name") == "namaKategori") {
                error.insertAfter(".lblNameErr");
            } else if (element.attr("name") == "keteranganKategori") {
                error.insertAfter(".lblKeteranganErr");
            } else if (element.attr("name") == "akronimKategori") {
                error.insertAfter(".lblAkronimErr");
            } else {
                error.insertAfter(element);
            }
        },
            rules:{
                namaKategori: "required",
                keteranganKategori: "required",
                akronimKategori: {
                    required: true,
                    minlength: 2
                }
            },
            // Specify validation error messages
            messages: {
                namaKategori: " (Harus diisi !!)",
                keteranganKategori: " (Harus diisi !!)",
                akronimKategori: {
                    required: " (Harus diisi !!)",
                    minlength: " (Akronim anda setidaknya minimal 2 karakter !!)"
                }
            },
            submitHandler: function(form) {
              form.submit();
            }
    });

    //validasi form subkategori
    $("[name='formSubKategori']").validate({
        // Specify validation rules
        errorElement: 'span',
        /*errorLabelContainer: '.errMsg',*/
        errorPlacement: function(error, element) {
            if (element.attr("name") == "namaSubKategori") {
                error.insertAfter(".lblNameErr");
            } else if (element.attr("name") == "keteranganSubKategori") {
                error.insertAfter(".lblKeteranganErr");
            } else if (element.attr("name") == "genderSubKategori") {
                error.insertAfter(".lblGenderErr");
            } else {
                error.insertAfter(element);
            }
        },
            rules:{
                namaSubKategori: "required",
                keteranganSubKategori: "required",
                genderSubKategori: "required"
            },
            // Specify validation error messages
            messages: {
                namaSubKategori: " (Harus diisi !!)",
                keteranganSubKategori: " (Harus diisi !!)",
                genderSubKategori: " (Harus diisi !!)"
            },
            submitHandler: function(form) {
              form.submit();
            }
    });

    // select class modal whenever bs.modal hidden
    $(".modal").on("hidden.bs.modal", function(){
        $('#form_kategori')[0].reset(); // reset form on modals
        $("[name='formKategori']").validate().resetForm();
    });

});	

function add_kategori()
{
    save_method = 'add';
	$('#modal_kategori_form').modal('show'); //show bootstrap modal
	$('.modal-title').text('Add Kategori'); //set title modal
}

function add_sub_kategori() 
{
    save_method = 'addSubKategori';
    $('#form_sub_kategori')[0].reset(); // reset form on modals
    $("[name='formSubKategori']").validate().resetForm();
    $('#modal_subkategori_form').modal('show'); //show bootstrap modal
    $('.modal-title').text('Add Sub Kategori'); //set title modal
}

function edit_kategori(id)
{
    save_method = 'update';
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('master_kategori_adm/edit_data_kategori')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //ambil data ke json->modal
            $('[name="idKategori"]').val(data.id_kategori);
            $('[name="namaKategori"]').val(data.nama_kategori);
            $('[name="keteranganKategori"]').val(data.ket_kategori);
            $('[name="akronimKategori"]').val(data.akronim);         
            $('#modal_kategori_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Kategori'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function edit_sub_kategori(id)
{
    save_method = 'updateSubKategori';
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('master_kategori_adm/edit_data_subkategori')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //ambil data ke json->modal
            $('[name="idSubKategori"]').val(data.id_sub_kategori);
            $('[name="idKategori"]').val(data.id_kategori);
            $('[name="namaSubKategori"]').val(data.nama_sub_kategori);
            $('[name="keteranganSubKategori"]').val(data.ket_sub_kategori);
            $('[name="genderSubKategori"]').val(data.gender_sub_kategori);         
            $('#modal_subkategori_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Sub Kategori'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function saveKategori()
{
    var url;
    if(save_method == 'add') {
        url = "<?php echo site_url('master_kategori_adm/add_master_kategori')?>";
    } else {
        url = "<?php echo site_url('master_kategori_adm/update_master_kategori')?>";
    }

    // ajax adding data to database
    var IsValid = $("form[name='formKategori']").valid();
    if(IsValid)
    {
        $("#btnSave").prop("disabled", true);
        $('#btnSave').text('saving...'); //change button text
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form_kategori').serialize(),
            dataType: "JSON",
            success: function (data) {
                if (data.status) {
                    alert(data.pesan);
                    $("#btnSave").prop("disabled", false);
                    $("#btnSave").text('Save'); //change button text
                    $('#modal_kategori_form').modal('hide');
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

function saveSubKategori()
{
    var url;
    if(save_method == 'addSubKategori') {
        url = "<?php echo site_url('master_kategori_adm/add_master_subkategori')?>";
    } else {
        url = "<?php echo site_url('master_kategori_adm/update_master_subkategori')?>";
    }

    // ajax adding data to database
    var IsValid = $("form[name='formSubKategori']").valid();
    if(IsValid)
    {
        $("#btnSaveSub").prop("disabled", true);
        $('#btnSaveSub').text('saving...'); //change button text
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form_sub_kategori').serialize(),
            dataType: "JSON",
            success: function (data) {
                if (data.status) {
                    alert(data.pesan);
                    $("#btnSaveSub").prop("disabled", false);
                    $("#btnSaveSub").text('Save'); //change button text
                    $('#modal_subkategori_form').modal('hide');
                    reload_table2();
                }
            },
            error: function (e) {
                console.log("ERROR : ", e);
                $("#btnSaveSub").prop("disabled", false);
            }
        });
    } 
}

function delete_kategori(id)
{
    if(confirm('Anda yakin hapus data ini ?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('master_kategori_adm/delete_master_kategori')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                if (data.status) {
                    $('#modal_kategori_form').modal('hide');
                    alert(data.pesan);
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

function delete_sub_kategori(id)
{
    if(confirm('Anda yakin hapus data ini ?'))
    {
        $.ajax({
            url : "<?php echo site_url('master_kategori_adm/delete_master_subkategori')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                if (data.status) {
                    $('#modal_subkategori_form').modal('hide');
                    alert(data.pesan);
                    reload_table2();
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

function reload_table2()
{
    table2.ajax.reload(null,false); //reload datatable ajax 
}

</script>	