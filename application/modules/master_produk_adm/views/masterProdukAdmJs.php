<!-- ambil uri segment 3 -->
<?php $val_url = $this->uri->segment(3); ?>
<script type="text/javascript">
	var save_method;
    var save_method_detail;
	var table;
    var tableDetail;
    var idProduk = "<?php echo $val_url; ?>";

$(document).ready(function() {

    //force integer input in textfield
    $('input.numberinput').bind('keypress', function (e) {
        return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

	//datatables
	table = $('#tabelProduk').DataTable({
		
		"processing": true, //feature control the processing indicator
		"serverSide": true, //feature control DataTables server-side processing mode
		"order":[], //initial no order

		//load data for table content from ajax source
		"ajax": {
			"url": "<?php echo site_url('master_produk_adm/list_produk') ?>",
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
    tableDetail = $('#tabelProdukDetail').DataTable({
        "processing": true, //feature control the processing indicator
        "serverSide": true, //feature control DataTables server-side processing mode
        "order":[], //initial no order

        //load data for table content from ajax source
        "ajax": {
            "url": "<?php echo site_url('master_produk_adm/list_produk_detail/') ?>"+idProduk,
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

    //validasi form master produk
    $("[name='formProduk']").validate({
        // Specify validation rules
        errorElement: 'span',
        /*errorLabelContainer: '.errMsg',*/
        errorPlacement: function(error, element) {
            if (element.attr("name") == "namaProduk") {
                error.insertAfter(".lblNamaErr");
            } else if (element.attr("name") == "kategoriProduk") {
                error.insertAfter(".lblKetegoriErr");
            } else if (element.attr("name") == "subKategoriProduk") {
                error.insertAfter(".lblSubKetegoriErr");
            } else if (element.attr("name") == "hargaProduk") {
                error.insertAfter(".lblHargaErr");
            } else if (element.attr("name") == "satuanProduk") {
                error.insertAfter(".lblSatuanErr");
            } else if (element.attr("name") == "keteranganProduk") {
                error.insertAfter(".lblKeteranganErr");
            } else if (element.attr("name") == "bahanProduk") {
                error.insertAfter(".lblBahanErr");
            } else if (element.attr("name") == "gambarDisplay") {
                error.insertAfter(".lblGbrDisplayErr");
            }else {
                error.insertAfter(element);
            }
        },
            rules:{
                namaProduk: "required",
                kategoriProduk: "required",
                subKategoriProduk: "required",
                hargaProduk: "required",
                satuanProduk: "required",
                keteranganProduk: "required",
                bahanProduk: "required",
                gambarDisplay: "required"
            },
            // Specify validation error messages
            messages: {
                namaProduk: " (Harus diisi !!)",
                kategoriProduk: " (Harus diisi !!)",
                subKategoriProduk: " (Harus diisi !!)",
                hargaProduk: " (Harus diisi !!)",
                satuanProduk: " (Harus diisi !!)",
                keteranganProduk: " (Harus diisi !!)",
                bahanProduk: " (Harus diisi !!)",
                gambarDisplay: " (Harus diisi !!)"
            },
            submitHandler: function(form) {
              form.submit();
            }
    });

    //validasi form detail produk
    $("[name='formProdukDetail']").validate({
        // Specify validation rules
        errorElement: 'span',
        /*errorLabelContainer: '.errMsg',*/
        errorPlacement: function(error, element) {
            if (element.attr("name") == "ukuranProdukDet") {
                error.insertAfter(".lblUkuranDetErr");
            } else if (element.attr("name") == "beratSatuanDet") {
                error.insertAfter(".lblBeratDetErr");
            } else if (element.attr("name") == "stokAwalDet") {
                error.insertAfter(".lblStokAwalDetErr");
            } else if (element.attr("name") == "stokMinDet") {
                error.insertAfter(".lblStokMinDetErr");
            } else {
                error.insertAfter(element);
            }
        },
            rules:{
                ukuranProdukDet: "required",
                beratSatuanDet: "required",
                stokAwalDet: "required",
                stokMinDet: "required"
            },
            // Specify validation error messages
            messages: {
                ukuranProdukDet: " (Harus diisi !!)",
                beratSatuanDet: " (Harus diisi !!)",
                stokAwalDet: " (Harus diisi !!)",
                stokMinDet: " (Harus diisi !!)"
            },
            submitHandler: function(form) {
              form.submit();
            }
    });

    // inisialisai select2
    $("#kategori_produk").select2({
        ajax: {
            url: '<?php echo site_url('master_produk_adm/get_master_kategori'); ?>',
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

    $("#sub_kategori_produk").select2({
    });

    // event onchange to modify select2 kota content
    $('#kategori_produk').change(function(){
        $('#sub_kategori_produk').empty();
        var idKategori = $('#kategori_produk').val();
        $( "#sub_kategori_produk" ).select2({
            ajax: {
                url: '<?php echo site_url('master_produk_adm/get_master_sub_kategori'); ?>/'+ idKategori,
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

    $("#satuan_produk").select2({
        ajax: {
            url: '<?php echo site_url('master_produk_adm/get_satuan'); ?>',
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

    // select class modal whenever bs.modal hidden
    $(".modal").on("hidden.bs.modal", function(){
        //for modal master produk
        $('#form_produk')[0].reset(); // reset form on modals
        $('[name="kategoriProduk"]').empty(); 
        $('[name="subKategoriProduk"]').empty();
        $('[name="satuanProduk"]').empty();
        $('[name="idGbrDet1"]').val("");
        $('[name="idGbrDet2"]').val("");
        $('[name="idGbrDet3"]').val("");
        $("[name='formProduk']").validate().resetForm();
        $('#note_modal').addClass('hidden');
        $('#txt_wajib_det1').removeClass('hidden');
    });

    //change produk status
    $(document).on('click', '.btn_edit_status', function(){
        if(confirm('Apakah anda yakin ubah status Produk ini ?'))
        {
            var id = $(this).attr('id');
            var status = $(this).text();
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('master_produk_adm/edit_status_produk')?>/"+id,
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

    //change produk detail status
    $(document).on('click', '.btn_edit_status_det', function(){
        if(confirm('Apakah anda yakin ubah status Produk ini ?'))
        {
            var id = $(this).attr('id');
            var status = $(this).text();
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('master_produk_adm/edit_status_produk_detail')?>/"+id,
                type: "POST",
                dataType: "JSON",
                data : {status : status},
                success: function(data)
                {
                    alert(data.pesan);
                    reload_table_detail();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error remove data');
                }
            });
        }   
    });

});	

function addProduk()
{
    $('#note_modal').addClass('hidden');
    $('.txtGbrProduk').text("");
    $('.txtGbrDet1').text("");
    $('.txtGbrDet2').text("");
    $('.txtGbrDet3').text("");
    save_method = 'add';
	$('#modal_produk_form').modal('show'); //show bootstrap modal
	$('.modal-title').text('Add Master Produk'); //set title modal
}

function addDetailProduk()
{
    save_method_detail = 'addDetail';
    $('#ukuran_produk_det').attr('disabled', false);
    $('#form_produk_detail')[0].reset(); // reset form on modals
    $("[name='formProdukDetail']").validate().resetForm();
    $('#modal_produk_detail').modal('show');
    $('.modal-title').text('Add Detail Produk');
}

function editProduk(id)
{
    save_method = 'update';
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('master_produk_adm/edit_data_produk')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            //remove class hidden pada div span catatan
            $('#note_modal').removeClass('hidden');
            //ambil data ke json->modal
            $('[name="idProduk"]').val(data.id_produk);
            $('[name="namaProduk"]').val(data.nama_produk);
            $('[name="hargaProduk"]').val(data.harga);
            $('[name="keteranganProduk"]').val(data.keterangan_produk);
            $('[name="bahanProduk"]').val(data.bahan_produk);
            $('[name="idGbrDisplay"]').val(data.id_gambar);
            $('[name="idGbrDet1"]').val(data.id_gambar_detail1);
            $('[name="idGbrDet2"]').val(data.id_gambar_detail2);
            $('[name="idGbrDet3"]').val(data.id_gambar_detail3);

            var selectedKategori = $("<option></option>").val(data.id_kategori).text(data.nama_kategori);
            var selectedSubKategori = $("<option></option>").val(data.id_sub_kategori).text(data.nama_sub_kategori);
            var selectedSatuan = $("<option></option>").val(data.id_satuan).text(data.nama_satuan);            
            
            //tanpa trigger event
            $('[name="kategoriProduk"]').append(selectedKategori);
            $('[name="subKategoriProduk"]').append(selectedSubKategori);
            $('[name="satuanProduk"]').append(selectedSatuan);
            //set value of span
            $('.txtGbrProduk').text(data.nama_gambar);
            $('.txtGbrDet1').text(data.nama_gambar_detail1);
            $('.txtGbrDet2').text(data.nama_gambar_detail2);
            $('.txtGbrDet3').text(data.nama_gambar_detail3);
            $('#txt_wajib_det1').addClass('hidden', true);

            $('#modal_produk_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Produk'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function editDetail(id) {
    save_method = 'updateDetail';
    $.ajax({
        url : "<?php echo site_url('master_produk_adm/edit_data_produk_detail')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('#ukuran_produk_det').attr('disabled', true);
            //ambil data ke json->modal
            $('[name="idProdukDet"]').val(data.id_stok);
            $('#ukuran_produk_det option[value='+data.ukuran_produk+']').attr('selected','selected');
            //$('[name="ukuranProdukDet"]').val(data.ukuran_produk);
            $('[name="beratSatuanDet"]').val(data.berat_satuan);
            $('[name="stokAwalDet"]').val(data.stok_awal);
            $('[name="stokMinDet"]').val(data.stok_minimum);

            $('#modal_produk_detail').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Produk Detail'); // Set title to Bootstrap modal title

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

function reload_table_detail()
{
    tableDetail.ajax.reload(null,false); //reload datatable ajax 
}

function saveProduk()
{
    if(save_method == 'add') {
        var IsValid = $("form[name='formProduk']").valid();
        if(IsValid)
        {
            // Get form
            var form = $('#form_produk')[0];
            var data = new FormData(form);
            $("#btnSave").prop("disabled", true);
            $('#btnSave').text('saving...'); //change button text
            $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "<?php echo site_url('master_produk_adm/add_data_produk')?>",
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
                            $('#modal_produk_form').modal('hide');
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
    else 
    {
            // Get form
            var form = $('#form_produk')[0];
            var data = new FormData(form);
            $("#btnSave").prop("disabled", true);
            $('#btnSave').text('saving...'); //change button text
            $.ajax({
                    type: "POST",
                    enctype: 'multipart/form-data',
                    url: "<?php echo site_url('master_produk_adm/update_produk')?>",
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
                            $('#modal_produk_form').modal('hide');
                            reload_table();
                        }
                    },
                    error: function (e) {
                        console.log("ERROR : ", e);
                        $("#btnSave").prop("disabled", false);
                    }
            });
    }

    // ajax adding data to database
    
}

function saveProdukDetail()
{
    var url;
    if(save_method_detail == 'addDetail') {
        url = "<?php echo site_url('master_produk_adm/add_data_produk_detail')?>";
    } else {
        url = "<?php echo site_url('master_produk_adm/update_produk_detail')?>";
    }

    // ajax adding data to database
    var IsValid = $("form[name='formProdukDetail']").valid();
    if(IsValid)
    {
        $("#btnSaveDetail").prop("disabled", true);
        $('#btnSaveDetail').text('saving...'); //change button text
        $.ajax({
                url : url,
                type: "POST",
                //lebih efektif dengan serialize apabila tanpa upload, ketimbang FormData
                data: $('#form_produk_detail').serialize(),
                dataType: "JSON",
                success: function (data) {
                    if (data.status) {
                        alert(data.pesan);
                        $("#btnSaveDetail").prop("disabled", false);
                        $("#btnSaveDetail").text('Save'); //change button text
                        $('#modal_produk_detail').modal('hide');
                        reload_table_detail();
                    }
                },
                error: function (e) {
                    console.log("ERROR : ", e);
                    $("#btnSaveDetail").prop("disabled", false);
                }
        });
    } 
}

</script>	