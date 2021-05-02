<script type="text/javascript">
	var save_method; //for save method string
	var table;

$(document).ready(function() {

    //force integer input in textfield
    $('input.numberinput').bind('keypress', function (e) {
        return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

	//datatables
	table = $('#tabelUser').DataTable({
		
		"processing": true, //feature control the processing indicator
		"serverSide": true, //feature control DataTables server-side processing mode
		"order":[], //initial no order

		//load data for table content from ajax source
		"ajax": {
			"url": "<?php echo site_url('master_user_adm/list_user') ?>",
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

    //validasi form update profil
    $("[name='formUser']").validate({
        // Specify validation rules
        errorElement: 'span',
        /*errorLabelContainer: '.errMsg',*/
        errorPlacement: function(error, element) {
            if (element.attr("name") == "userFname") {
                error.insertAfter(".lblFnameErr");
            } else if (element.attr("name") == "userEmail") {
                error.insertAfter(".lblEmailErr");
            } else if (element.attr("name") == "userPassword") {
                error.insertAfter(".lblPassErr");
            } else if (element.attr("name") == "userTelp") {
                error.insertAfter(".lblTelpErr");
            } else if (element.attr("name") == "userTgllhr") {
                error.insertAfter(".lblTgllhrErr");
            } else if (element.attr("name") == "userProvinsi") {
                error.insertAfter(".lblProvErr");
            } else if (element.attr("name") == "userKota") {
                error.insertAfter(".lblKotaErr");
            } else if (element.attr("name") == "userKecamatan") {
                error.insertAfter(".lblKecErr");
            } else if (element.attr("name") == "userKelurahan") {
                error.insertAfter(".lblKelErr");
            } else if (element.attr("name") == "userKdpos") {
                error.insertAfter(".lblKdposErr");
            } else {
                error.insertAfter(element);
            }
        },
            rules:{
                userFname: "required",
                userEmail: "required",
                userPassword: "required",
                userTelp: "required",
                userTgllhr: "required",
                userProvinsi: "required",
                userKota: "required",
                userKecamatan: "required",
                userKelurahan: "required",
                userKdpos: {
                    required: true,
                    minlength: 5
                },
            },
            // Specify validation error messages
            messages: {
                userFname: " (Harus diisi !!)",
                userEmail: " (Harus diisi !!)",
                userPassword: " (Harus diisi !!)",
                userTelp: " (Harus diisi !!)",
                userTgllhr: " (Harus diisi !!)",
                userProvinsi: " (Harus diisi !!)",
                userKota: " (Harus diisi !!)",
                userKecamatan: " (Harus diisi !!)",
                userKelurahan: " (Harus diisi !!)",
                userKdpos: {
                    required: " (Harus diisi !!)",
                    minlength: " (Kode pos anda setidaknya minimal 5 karakter !!)"
                }
            },
            submitHandler: function(form) {
              form.submit();
            }
    });

    //validasi format email
    $("[name='userEmail']").focusout(function(){
        var isi = $('#email_hdn').val();
        $("[name='userEmail']").filter(function(){
            var emil = $("[name='userEmail']").val();
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if( !emailReg.test( emil ) ) {
                alert('Format email anda tidak valid');
                $("[name='userEmail']").val(isi);
            }
        })
    });

    //datepicker
    $("[name='userTgllhr']").datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        todayHighlight: true,
        todayBtn: true,
        todayHighlight: true,
    });

    // inisialisai select2
    $("#user_prov").select2({
        ajax: {
            url: '<?php echo site_url('checkout/suggest_provinsi'); ?>',
            dataType: 'json',
            type: "GET",
            data: function (params) {
                var queryParameters = {
                    term: params.term
                }
                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.text,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }, 
    });

    $( "#user_kota" ).select2({
    });
    
    $( "#user_kec" ).select2({
    });
    
    $( "#user_kel" ).select2({
    });

    // event onchange to modify select2 kota content
    $('#user_prov').change(function(){
            $('#user_kota').empty();
            $( "#user_kec" ).empty();
            $( "#user_kel" ).empty(); 
            var idProvinsi = $('#user_prov').val();
            $( "#user_kota" ).select2({
                ajax: {
                    url: '<?php echo site_url('checkout/suggest_kotakabupaten'); ?>/'+ idProvinsi,
                    dataType: 'json',
                    type: "GET",
                    data: function (params) {
                        var queryParameters = {
                            term: params.term
                        }
                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.text,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                },
            });
    });
    // event onchange to modify select2 kecamatan content
    $('#user_kota').change(function(){
            $('#user_kec').empty();
            $( "#user_kel" ).empty();  
            var idKota = $('#user_kota').val();
            $( "#user_kec" ).select2({ 
                ajax: {
                    url: '<?php echo site_url('checkout/suggest_kecamatan'); ?>/'+ idKota,
                    dataType: 'json',
                    type: "GET",
                    data: function (params) {
                        var queryParameters = {
                            term: params.term
                        }
                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.text,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                },
            });
    });
    // event onchange to modify select2 kelurahan content
    $('#user_kec').change(function(){
            $('#user_kel').empty(); 
            var idKecamatan = $('#user_kec').val();
            $( "#user_kel" ).select2({ 
                ajax: {
                    url: '<?php echo site_url('checkout/suggest_kelurahan'); ?>/'+ idKecamatan,
                    dataType: 'json',
                    type: "GET",
                    data: function (params) {
                        var queryParameters = {
                            term: params.term
                        }
                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.text,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                },
            });
    });

    // select class modal whenever bs.modal hidden
    $(".modal").on("hidden.bs.modal", function(){
        $('#form_user')[0].reset(); // reset form on modals
        $('[name="userProvinsi"]').empty(); 
        $('[name="userKota"]').empty();
        $('[name="userKecamatan"]').empty();
        $('[name="userKelurahan"]').empty();
        $("#user_level option[value='']").attr("selected", true);
        $("[name='formUser']").validate().resetForm();
    });

    //change user status
    $(document).on('click', '.btn_edit_status', function(){
        if(confirm('Apakah anda yakin ubah status User ini ?'))
        {
            var id = $(this).attr('id');
            var status = $(this).text();
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('master_user_adm/edit_status_user')?>/"+id,
                type: "POST",
                dataType: "JSON",
                data : {status : status},
                success: function(data)
                {
                    alert(data.pesan);
                    reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error remove data');
                }
            });
        }   
    });

});	

function add_user()
{
    save_method = 'add';
	$('#modal_user_form').modal('show'); //show bootstrap modal
	$('.modal-title').text('Add User'); //set title modal
}

function edit_user(id)
{
    save_method = 'update';
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('master_user_adm/edit_data_user')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //ambil data ke json->modal
            $('[name="userId"]').val(data.id_user);
            $('[name="userFname"]').val(data.fname_user);
            $('[name="userLname"]').val(data.lname_user);
            $('[name="userEmail"]').val(data.email);
            $('[name="userPassword"]').val(data.password);
            $('[name="userAlamat"]').val(data.alamat_user);
            $('[name="userTelp"]').val(data.no_telp_user);
            $('[name="userKdpos"]').val(data.kode_pos);
            
            $('#user_level').val(data.id_level_user);
            $('[name="userTgllhr"]').datepicker({dateFormat: 'dd-mm-yyyy'}).datepicker('setDate', data.tgl_lahir_user);
            var selectedIdProvinsi = $("<option></option>").val(data.id_provinsi).text(data.nama_provinsi);
            var selectedIdkota = $("<option></option>").val(data.id_kota).text(data.nama_kota);
            var selectedIdkecamatan = $("<option></option>").val(data.id_kecamatan).text(data.nama_kecamatan);
            var selectedIdkelurahan = $("<option></option>").val(data.id_kelurahan).text(data.nama_kelurahan);
            //tanpa trigger event
            $('[name="userProvinsi"]').append(selectedIdProvinsi);
            $('[name="userKota"]').append(selectedIdkota);
            $('[name="userKecamatan"]').append(selectedIdkecamatan);
            $('[name="userKelurahan"]').append(selectedIdkelurahan);

            $('#modal_user_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit User'); // Set title to Bootstrap modal title

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

function save()
{
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('master_user_adm/add_data_user')?>";
    } else {
        url = "<?php echo site_url('master_user_adm/update_data_user')?>";
    }

    // ajax adding data to database
    var IsValid = $("form[name='formUser']").valid();
    if(IsValid)
    {
        // Get form
        var form = $('#form_user')[0];
        // Create an FormData object
        var data = new FormData(form);
        // add an extra field for the FormData
        // data.append("CustomField", "This is some extra data, testing");
        // disabled the save button
        $("#btnSave").prop("disabled", true);
        $('#btnSave').text('saving...'); //change button text
        $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: url,
                data: data,
                dataType: "JSON",
                processData: false, // false, it prevent jQuery form transforming the data into a query string
                contentType: false, 
                cache: false,
                timeout: 600000,
                success: function (data) {
                    if (data.status) {
                        alert(data.pesan);
                        $("#btnSave").prop("disabled", false);
                        $("#btnSave").text('Save'); //change button text
                        $('#modal_user_form').modal('hide');
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