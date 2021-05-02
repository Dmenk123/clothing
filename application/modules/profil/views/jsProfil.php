<script type="text/javascript">
    var table; //utuk datatable
	$(document).ready(function() {
		//set active class to navbar
		$('#li_nav_home').removeClass('active');
		$('#li_nav_kontak').removeClass('active');
		$('#li_nav_faq').removeClass('active');
		$('#li_nav_login').removeClass('active');
		$('#li_nav_produk').removeClass('active');
        $('#li_nav_sesi').addClass('active');
        $('#li_nav_register').removeClass('active');
        //force integer input in textfield
        $('input.numberinput').bind('keypress', function (e) {
            return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
        });

        //validasi form update profil
        $("[name='formUpdateProfil']").validate({
            // Specify validation rules
            errorElement: 'span',
            /*errorLabelContainer: '.errMsg',*/
            errorPlacement: function(error, element) {
                if (element.attr("name") == "frm_fname_user") {
                    error.insertAfter(".lblFnameErr");
                } else if (element.attr("name") == "frm_email_user") {
                    error.insertAfter(".lblEmailErr");
                } else if (element.attr("name") == "frm_pass_user") {
                    error.insertAfter(".lblPassErr");
                } else if (element.attr("name") == "frm_telp_user") {
                    error.insertAfter(".lblTelpErr");
                } else if (element.attr("name") == "frm_tgllhr_user") {
                    error.insertAfter(".lblTgllhrErr");
                } else if (element.attr("name") == "frm_prov_user") {
                    error.insertAfter(".lblProvErr");
                } else if (element.attr("name") == "frm_kota_user") {
                    error.insertAfter(".lblKotaErr");
                } else if (element.attr("name") == "frm_kec_user") {
                    error.insertAfter(".lblKecErr");
                } else if (element.attr("name") == "frm_kel_user") {
                    error.insertAfter(".lblKelErr");
                } else if (element.attr("name") == "frm_kode_pos") {
                    error.insertAfter(".lblKdposErr");
                } else {
                    error.insertAfter(element);
                }
            },
            rules:{
                frm_fname_user: "required",
                frm_email_user: "required",
                frm_pass_user: "required",
                frm_tgllhr_user: "required",
                frm_prov_user: "required",
                frm_kota_user: "required",
                frm_kec_user: "required",
                frm_kel_user: "required",
                frm_alamat_user: "required",
                frm_kode_pos: {
                    required: true,
                    minlength: 5
                },
                frm_telp_user: "required"
            },
            // Specify validation error messages
            messages: {
                frm_fname_user: " (Harus diisi !!)",
                frm_prov_user: " (Harus diisi !!)",
                frm_kota_user: " (Harus diisi !!)",
                frm_kec_user: " (Harus diisi !!)",
                frm_kel_user: " (Harus diisi !!)",
                frm_alamat_user: " (Harus diisi !!)",
                frm_kode_pos: {
                    required: " (Harus diisi !!)",
                    minlength: " (Kode pos anda setidaknya minimal 5 karakter !!)"
                },
                frm_telp_user: " (Harus diisi !!)"
            },
            submitHandler: function(form) {
              form.submit();
            }
        });

        //validasi format email
        $('#email_user').focusout(function(){
            var isi = $('#email_hdn').val();
            $('#email_user').filter(function(){
                var emil=$('#email_user').val();
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                if( !emailReg.test( emil ) ) {
                    alert('Format email anda tidak valid');
                    $('#email_user').val(isi);
                } /*else {
                    alert('Thank you for your valid email');
                }*/
            })
        });

        //datepicker
        $('#tgllhr_user').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            todayHighlight: true,
            todayBtn: true,
            todayHighlight: true,
        });

        // inisialisai select2
        $("#prov_user").select2({
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
    	$( "#kota_user" ).select2({
        });
        $( "#kec_user" ).select2({
        });
        $( "#kel_user" ).select2({
        });

        // event onchange to modify select2 kota content
        $('#prov_user').change(function(){
            $('#kota_user').empty();
            $( "#kec_user" ).empty();
            $( "#kel_user" ).empty(); 
            var idProvinsi = $('#prov_user').val();
            $( "#kota_user" ).select2({
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
        $('#kota_user').change(function(){
            $('#kec_user').empty();
            $( "#kel_user" ).empty();  
            var idKota = $('#kota_user').val();
            $( "#kec_user" ).select2({ 
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
        $('#kec_user').change(function(){
            $('#kel_user').empty(); 
            var idKecamatan = $('#kec_user').val();
            $( "#kel_user" ).select2({ 
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

        //load edit value in form edit
        $.ajax({
            url : "<?php echo site_url('profil/get_select_edit/')?>",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('[name="frm_tgllhr_user"]').datepicker({dateFormat: 'dd-mm-yyyy'}).datepicker('setDate', data.tgl_lahir_user);
                $selectedIdProvinsi = $("<option></option>").val(data.id_provinsi).text(data.nama_provinsi);
                $selectedIdkota = $("<option></option>").val(data.id_kota).text(data.nama_kota);
                $selectedIdkecamatan = $("<option></option>").val(data.id_kecamatan).text(data.nama_kecamatan);
                $selectedIdkelurahan = $("<option></option>").val(data.id_kelurahan).text(data.nama_kelurahan);
                //tanpa trigger event
                $('[name="frm_prov_user"]').append($selectedIdProvinsi);
                $('[name="frm_kota_user"]').append($selectedIdkota);
                $('[name="frm_kec_user"]').append($selectedIdkecamatan);
                $('[name="frm_kel_user"]').append($selectedIdkelurahan);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });

        //update profil
        $("#btnUpdateProfil").click(function (event) {
            //stop submit the form
            event.preventDefault();
            var IsValid = $("form[name='formUpdateProfil']").valid();
            if(IsValid)
            {
                // Get form
                var form = $('#form_update_profil')[0];
                // Create an FormData object
                var data = new FormData(form);
                // add an extra field for the FormData
                // data.append("CustomField", "This is some extra data, testing");
                // disabled the register button
                $("#btnUpdateProfil").prop("disabled", true);
                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "<?php echo site_url('profil/update_profil'); ?>",
                    data: data,
                    dataType: "JSON",
                    processData: false, // false, it prevent jQuery form transforming the data into a query string
                    contentType: false, 
                    cache: false,
                    timeout: 600000,
                    success: function (data) {
                        if (data.status) {
                            alert(data.pesan);
                            $("#btnUpdateProfil").prop("disabled", false);
                            window.location.href = "<?php echo site_url('profil'); ?>";
                        }
                    },
                    error: function (e) {
                        console.log("ERROR : ", e);
                        $("#btnRegister").prop("disabled", false);
                    }
                });
            }
        });

        //final confirm checkout
        $("#btnConfirmCod").click(function (event) {
            //stop submit the form
            event.preventDefault();
            if($("#cfrm_check").prop('checked') == true)
            {
                //id checkout
                var id = $('#cfrm_id_checkout').val();
                // Get form
                var form = $('#form_konfirm_ckt_cod')[0];
                // Create an FormData object
                var data = new FormData(form);
                $("#btnConfirmCod").prop("disabled", true);
                $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "<?php echo site_url('profil/konfirmasi_checkout_cod/'); ?>"+id,
                    data: data,
                    dataType: "JSON",
                    processData: false, // false, it prevent jQuery form transforming the data into a query string
                    contentType: false, 
                    cache: false,
                    timeout: 600000,
                    success: function (data) {
                        if (data.status) {
                            alert(data.pesan);
                            $("#btnConfirmCod").prop("disabled", false);
                            window.location.href = "<?php echo site_url('profil'); ?>";
                        }
                    },
                    error: function (e) {
                        console.log("ERROR : ", e);
                        $("#btnConfirmCod").prop("disabled", false);
                    }
                });
            }else{
                alert("Mohon centang pada pilihan \"Saya Setuju\"")
            }
        });

        $("#btnConfirmTfr").click(function (event) {
            //stop submit the form
            event.preventDefault();
            if($("#cfrm_check").prop('checked') == true)
            {
                if ($('#cfrm_bukti1').get(0).files.length !== 0) 
                {
                    //id checkout
                    var id = $('#cfrm_id_checkout').val();
                    // Get form
                    var form = $('#form_konfirm_ckt_tfr')[0];
                    // Create an FormData object
                    var data = new FormData(form);
                    $("#btnConfirmTfr").prop("disabled", true);
                    $.ajax({
                        type: "POST",
                        enctype: 'multipart/form-data',
                        url: "<?php echo site_url('profil/konfirmasi_checkout_tfr/'); ?>"+id,
                        data: data,
                        dataType: "JSON",
                        processData: false, // false, it prevent jQuery form transforming the data into a query string
                        contentType: false, 
                        cache: false,
                        timeout: 600000,
                        success: function (data) {
                            if (data.status) {
                                alert(data.pesan);
                                $("#btnConfirmTfr").prop("disabled", false);
                                window.location.href = "<?php echo site_url('profil'); ?>";
                            }
                        },
                        error: function (e) {
                            console.log("ERROR : ", e);
                            $("#btnConfirmTfr").prop("disabled", false);
                        }
                    });
                }
                else
                {
                    alert("Mohon Upload Minimal 1 Gambar pada tombol upload paling atas!!");
                } 
            }
            else
            {
                alert("Mohon centang pada pilihan \"Saya Setuju\"");
            }
        });

        //datatable
        table = $('#tabelCheckoutHistory').DataTable({
            "processing": true, //feature control the processing indicator
            "serverSide": true, //feature control DataTables server-side processing mode
            "order":[[ 0, 'desc' ]], //index for order, 0 is first column
            //load data for table content from ajax source
            "ajax": {
                "url": "<?php echo site_url('profil/list_checkout_history') ?>",
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

	}); // end jquery  

	//set uri string
	function setParam(name, value) {
        var l = window.location;

        /* build params */
        var params = {};        
        var x = /(?:\??)([^=&?]+)=?([^&?]*)/g;        
        var s = l.search;
        for(var r = x.exec(s); r; r = x.exec(s))
        {
            r[1] = decodeURIComponent(r[1]);
            if (!r[2]) r[2] = '%%';
            params[r[1]] = r[2];
        }

        /* set param */
        params[name] = encodeURIComponent(value);

        /* build search */
        var search = [];
        for(var i in params)
        {
            var p = encodeURIComponent(i);
            var v = params[i];
            if (v != '%%') p += '=' + v;
            search.push(p);
        }
        search = search.join('&');

        /* execute search */
        l.search = search;
    }

    function reload_table()
    {
        table.ajax.reload(null,false); //reload datatable ajax 
    }

    function nonaktifCheckout(id)
    {
        if(confirm('Apakah anda yakin nonaktifkan transaksi ini ?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('profil/nonaktif_checkout')?>/"+id,
                type: "POST",
                dataType: "JSON",
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
    }
		
</script>