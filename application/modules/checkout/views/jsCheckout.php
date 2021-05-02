<!-- load gmaps api -->
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyANNc1-MZMq0duMkVgXAUfNfFHEOi78NeQ"></script>
<script type="text/javascript">
    var edit_type;
	$(document).ready(function(){
		//set active class to navbar
		$('#li_nav_home').removeClass('active');
		$('#li_nav_kontak').addClass('active');
		$('#li_nav_faq').removeClass('active');
		$('#li_nav_login').removeClass('active');
		$('#li_nav_produk').removeClass('active');
        $('#li_nav_register').removeClass('active');
		
        //force integer input in textfield
        $('input.numberinput').bind('keypress', function (e) {
            return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
        });

        //validasi form edit alamat tagih
        $("form[name='formCheckout1']").validate({
            // Specify validation rules
            errorElement: 'span',
            /*errorLabelContainer: '.errMsg',*/
            errorPlacement: function(error, element) {
                if (element.attr("name") == "checkout1Fname") {
                    error.insertAfter(".lblFnameErr");
                } else if (element.attr("name") == "checkout1Alamat") {
                    error.insertAfter(".lblAlmtErr");
                } else if (element.attr("name") == "checkout1Telp") {
                    error.insertAfter(".lblTelpErr");
                } else if (element.attr("name") == "checkout1Kdpos") {
                    error.insertAfter(".lblKdpsErr");
                } else {
                    error.insertAfter(element);
                }
            },
            rules:{
                checkout1Fname: "required",
                checkout1Provinsi: "required",
                checkout1Kota: "required",
                checkout1Kecamatan: "required",
                checkout1Kelurahan: "required",
                checkout1Alamat: "required",
                checkout1Kdpos: {
                    required: true,
                    minlength: 5
                },
                checkout1Telp: "required"
            },
            // Specify validation error messages
            messages: {
                checkout1Fname: " (Harus diisi !!)",
                checkout1Provinsi: " (Harus diisi !!)",
                checkout1Kota: " (Harus diisi !!)",
                checkout1Kecamatan: " (Harus diisi !!)",
                checkout1Kelurahan: " (Harus diisi !!)",
                checkout1Alamat: " (Harus diisi !!)",
                checkout1Kdpos: {
                    required: " (Harus diisi !!)",
                    minlength: " (Kode pos anda setidaknya minimal 5 karakter !!)"
                },
                checkout1Telp: " (Harus diisi !!)"
            },
            submitHandler: function(form) {
              form.submit();
            }
        });

        $("#checkout1_prov").select2({
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

        $( "#checkout1_kota" ).select2({
        });
              
        $( "#checkout1_kec" ).select2({
        });

        $( "#checkout1_kel" ).select2({
        });

        // event onchange to modify select2 kota content
        $('#checkout1_prov').change(function(){
            $('#checkout1_kota').empty();
            $( "#checkout1_kec" ).empty();
            $( "#checkout1_kel" ).empty(); 
            var idProvinsi = $('#checkout1_prov').val();
            $( "#checkout1_kota" ).select2({
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
        $('#checkout1_kota').change(function(){
            $('#checkout1_kec').empty();
            $( "#checkout1_kel" ).empty();  
            var idKota = $('#checkout1_kota').val();
            $( "#checkout1_kec" ).select2({ 
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
        $('#checkout1_kec').change(function(){
            $('#checkout1_kel').empty(); 
            var idKecamatan = $('#checkout1_kec').val();
            $( "#checkout1_kel" ).select2({ 
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
            $('#checkout1_kel').empty(); 
            $('#checkout1_kec').empty();
            $('#checkout1_kota').empty();
            $('#checkout1_prov').empty();
            $("#form_checkout1").validate().resetForm();
        });

        $( "#checkout2_byr" ).select2({
        });

        $('#checkout2_byr').change(function(){
            // set form field untuk proses summary
            $('[name="FMethodKrm"]').val($('#checkout2_byr').val());
            var kota = $('#krmKota').text();
            var metode = $("#checkout2_byr").val();
            if (kota != "KOTA SURABAYA" && metode == "cod") {
                alert("Metode COD Hanya dapat dilakukan untuk kota SURABAYA !!");
                $('#checkout2_byr').val('').trigger('change');
            }
            //jika metode transfer
            if (metode == "transfer") {
                $('#step3_area').append('<div class="form-group col-md-12" id="content_field"></div>');
                $('#content_field').append('<p style="text-align: center;"><strong>Step 3: Pilih Jasa Ekspedisi</strong></p>');
                
                $('#content_field').append('<div class="form-group">'
                    +'<label for="lblProvTujuan" class="lblKotaErr">Provinsi Tujuan</label>'
                    +'<select class="form-control" id="prov_tujuan" name="provTujuan" style="width: 100%;" data-minimum-results-for-search="Infinity"></select>'
                +'</div>');
                $('#content_field').append('<div class="form-group">'
                    +'<label for="lblKotaTujuan" class="lblKotaErr">Kota/Kabupaten Tujuan</label>'
                    +'<select class="form-control" id="kota_tujuan" name="kotaTujuan" style="width: 100%;" data-minimum-results-for-search="Infinity"></select>'
                +'</div');
                $('#content_field').append('<div class="form-group">'
                    +'<label for="lblBerat" class="lblKotaErr">Total Berat (gram)</label>'
                    +'<input type="text" class="form-control" id="total_berat" name="totalBerat" style="width: 100%;" readonly>'
                +'</div');
                $('#content_field').append('<div class="form-group">'
                    +'<label for="lblEkspedisi" class="lblKotaErr">Jasa Ekspedisi</label>'
                    +'<select class="form-control" id="jasa_ekspedisi" name="jasaEKspedisi" style="width: 100%;" data-minimum-results-for-search="Infinity">'
                        +'<option value="">-- Pilih jasa ekspedisi / kurir --</option>'
                        +'<option value="jne">Jalur Nugraha Ekakurir (JNE)</option>'
                        +'<option value="pos">PT. POS Indonesia (POS)</option>'
                        +'<option value="tiki">Citra Van Titipan Kilat (TIKI)</option>'
                     +'</select>'
                +'</div');
                $('#content_field').append('<div class="form-group">'
                    +'<label for="lblPilihPaket" class="lblKotaErr">Pilih Paket (Keterangan : Nama paket | Waktu kirim (hari) | Harga)</label>'
                    +'<select class="form-control" id="paket_ongkir" name="paketOngkir" style="width: 100%;" data-minimum-results-for-search="Infinity">'
                +'</div');
                 $('#content_field').append('<div class="form-group divHarga">'
                    +'<span id="tempHarga" class="hidden"></span><span id="tempEtd" class="hidden"></span>'
                    +'BIAYA PENGIRIMAN : Rp. <span style="font-size:20px; text-decoration:underline;" id="tampilHarga"></span>'
                +'</div');
                //select2 config
                $( "#jasa_ekspedisi" ).select2({
                });

                $( "#kota_tujuan" ).select2({
                });

                $( "#kota_tujuan" ).select2({
                });

                $( "#paket_ongkir" ).select2({
                });

                $("#prov_tujuan").select2({
                    ajax: {
                        url: '<?php echo site_url('checkout/suggest_provinsi_tujuan'); ?>',
                        dataType: "json",
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
                    }
                });

                //event change to trigger select2 kota
                $('#prov_tujuan').change(function(){
                    // set form field untuk proses summary
                    $('[name="FProvKurir"]').val($('#prov_tujuan :selected').text());
                    var idProvTujuan = $('#prov_tujuan').val();
                    $('#kota_tujuan').empty();
                    $("#kota_tujuan").select2({
                        ajax: {
                            url: '<?php echo site_url('checkout/suggest_kota_tujuan?idProv='); ?>'+idProvTujuan,
                            dataType: "json",
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
                        }
                    });
                });

                $('#kota_tujuan').change(function(){
                    // set form field untuk proses summary
                    $('[name="FKotaKurir"]').val($('#kota_tujuan :selected').text());
                    $('#jasa_ekspedisi').val('').trigger('change');
                    $('#paket_ongkir').val('').trigger('change');
                });

                //ajax load total berat
                $.ajax({
                        url: '<?php echo site_url('checkout/get_berat_total_cart'); ?>',
                        dataType: "json",
                        type: "GET",
                        success : function(data) {
                            $('#total_berat').val(data);
                            $('[name="FBeratKurir"]').val(data);
                        }
                });
                
                //event change to trigger select2 paket
                $('#jasa_ekspedisi').change(function(){
                    // set form field untuk proses summary
                    $('[name="FNamaKurir"]').val($('#jasa_ekspedisi').val());
                    $('#paket_ongkir').val('').trigger('change');
                    $('#tampilHarga').text("");
                    var origin = 444;
                    var idKotaTujuan = $('#kota_tujuan').val();
                    var beratTotal = $('#total_berat').val();
                    var idKurir = $('#jasa_ekspedisi').val();
                    $("#paket_ongkir").select2({
                        ajax: {
                            url: '<?php echo site_url('checkout/suggest_paket_ongkir?origin='); ?>'+origin+'&id='+idKotaTujuan+'&berat='+beratTotal+'&kurir='+idKurir,
                            dataType: "json",
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
                                            text: item.text.service+' | '+item.text.etd+' | '+item.text.value,
                                            id: item.id,
                                        }
                                    })
                                };
                            },
                            cache: true
                        }
                    });//select2 end                          
                });//evnt change end

                $('#paket_ongkir').change(function(){
                    // set form field untuk proses summary
                    $('[name="FPaketKurir"]').val($('#paket_ongkir').val());
                    var hasil;
                    //set tampil harga to null
                    $('#tampilHarga').text("");
                    //deklare kata with select2 selected
                    var kata = $('#paket_ongkir :selected').text();
                    //split string
                    var cacah = kata.split(' | ');
                    // set value to span tempharga
                    $('#tempHarga').text(cacah[2]);
                    $('#tempEtd').text(cacah[1]);
                    //set variable hasil with value of tempharga
                    var hasil = $('#tempHarga').text();
                    //show tampil harga with number formatted
                    $('#tampilHarga').text(numberWithCommas(hasil));
                    // set form field untuk proses summary
                    $('[name="FHargaKurir"]').val($('#tempHarga').text());
                    $('[name="FEtdKurir"]').val($('#tempEtd').text());
                });             
            }//end if event chnage method transaksi
            else
            {   
                //remove div append
                $('#content_field').remove();
                //remove form text summary 
                $('[name="FProvKurir"]').val("");
                $('[name="FKotaKurir"]').val("");
                $('[name="FBeratKurir"]').val("");
                $('[name="FNamaKurir"]').val("");
                $('[name="FPaketKurir"]').val("");
                $('[name="FHargaKurir"]').val("");
            }//end elseif event chnage method transaksi
        });//end change metode bayar

        //set default span text to textfield
        $('[name="FIduserKrm"]').val($('#krmIdusr').text());
        $('[name="FFnameKrm"]').val($('#krmFname').text());
        $('[name="FLnameKrm"]').val($('#krmLname').text());
        $('[name="FAlamatKrm"]').val($('#krmAlamat').text());
        $('[name="FKelKrm"]').val($('#krmIdKel').text());
        $('[name="FTxtKelKrm"]').val($('#krmKel').text());
        $('[name="FKecKrm"]').val($('#krmIdKec').text());
        $('[name="FTxtKecKrm"]').val($('#krmKec').text());
        $('[name="FKotaKrm"]').val($('#krmIdKota').text());
        $('[name="FTxtKotaKrm"]').val($('#krmKota').text());
        $('[name="FProvKrm"]').val($('#krmIdProv').text());
        $('[name="FTxtProvKrm"]').val($('#krmProv').text());
        $('[name="FKdposKrm"]').val($('#krmKdpos').text());
        $('[name="FTelpKrm"]').val($('#krmTelp').text());

        // // Load shopping cart
        // $('#show_detail').load("<?php echo site_url('checkout/load_detail_cart'); ?>");

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

    function editAlamatKirim(id)
    {
        edit_type = 'alamat_kirim';
            $.ajax({
                url : "<?php echo site_url('checkout/get_alamat_user/')?>" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('[name="checkout1Id"]').val(data[0].id_user);
                    $('[name="checkout1Fname"]').val(data[0].fname_user);
                    $('[name="Fname2"]').val(data[0].fname_user);
                    $('[name="checkout1Lname"]').val(data[0].lname_user);

                    $selectedIdProvinsi = $("<option></option>").val(data[0].id_provinsi).text(data[0].nama_provinsi);
                    $selectedIdkota = $("<option></option>").val(data[0].id_kota).text(data[0].nama_kota);
                    $selectedIdkecamatan = $("<option></option>").val(data[0].id_kecamatan).text(data[0].nama_kecamatan);
                    $selectedIdkelurahan = $("<option></option>").val(data[0].id_kelurahan).text(data[0].nama_kelurahan);
                    //tanpa trigger event
                    $('[name="checkout1Provinsi"]').append($selectedIdProvinsi);
                    $('[name="checkout1Kota"]').append($selectedIdkota);
                    $('[name="checkout1Kecamatan"]').append($selectedIdkecamatan);
                    $('[name="checkout1Kelurahan"]').append($selectedIdkelurahan);

                    $('[name="checkout1Alamat"]').val(data[0].alamat_user);                   
                    $('[name="checkout1Telp"]').val(data[0].no_telp_user);
                    $('[name="checkout1Kdpos"]').val(data[0].kode_pos);
                    $('#modal_checkout1').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Ubah Alamat Pengiriman'); //set title modal
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
    }

    function update_alamat_chckout1()
    {
        var IsValid = $("form[name='formCheckout1']").valid();
        if(IsValid)
        {
            $('#krmFname').text($('[name="checkout1Fname"]').val());
            $('#krmLname').text($('[name="checkout1Lname"]').val());
            $('#krmAlamat').text($('[name="checkout1Alamat"]').val());
            $('#krmKel').text($('[name="checkout1Kelurahan"] option:selected').text());
            $('#krmKec').text($('[name="checkout1Kecamatan"] option:selected').text());
            $('#krmKota').text($('[name="checkout1Kota"] option:selected').text());
            $('#krmProv').text($('[name="checkout1Provinsi"] option:selected').text());
            $('#krmKdpos').text($('[name="checkout1Kdpos"]').val());
            $('#krmTelp').text($('[name="checkout1Telp"]').val());
            $('[name="FIduserKrm"]').val($('[name="checkout1Id"]').val());
            $('[name="FFnameKrm"]').val($('[name="checkout1Fname"]').val());
            $('[name="FLnameKrm"]').val($('[name="checkout1Lname"]').val());
            $('[name="FAlamatKrm"]').val($('[name="checkout1Alamat"]').val());
            $('[name="FKelKrm"]').val($('[name="checkout1Kelurahan"]').val());
            $('[name="FTxtKelKrm"]').val($('[name="checkout1Kelurahan"] option:selected').text());
            $('[name="FKecKrm"]').val($('[name="checkout1Kecamatan"]').val());
            $('[name="FTxtKecKrm"]').val($('[name="checkout1Kecamatan"] option:selected').text());
            $('[name="FKotaKrm"]').val($('[name="checkout1Kota"]').val());
            $('[name="FTxtKotaKrm"]').val($('[name="checkout1Kota"] option:selected').text());
            $('[name="FProvKrm"]').val($('[name="checkout1Provinsi"]').val());
            $('[name="FTxtProvKrm"]').val($('[name="checkout1Provinsi"] option:selected').text());
            $('[name="FKdposKrm"]').val($('[name="checkout1Kdpos"]').val());
            $('[name="FTelpKrm"]').val($('[name="checkout1Telp"]').val());

            $('#modal_checkout1').modal('hide');
            $('#checkout2_byr').val('').trigger('change');
        }
    }

    function proses_pembayaran() {
        $.ajax({
        url: "<?php echo site_url('checkout/proses_summary'); ?>",
        type: 'POST',
        data: $('#form_checkout2').serialize(),
        dataType: "JSON",
            success :function(data){
                if (data.status) {
                    alert(data.pesan);
                    window.location.href = "<?php echo site_url('home'); ?>";
                }else{
                    alert(data.pesan);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Terjadi kesalahan pada sistem');
            }
        });
    }

   /* function proses_pembayaran() {
       alert( $("#form_checkout2").serialize() );
    }*/

    const numberWithCommas = (x) => {
      var parts = x.toString().split(",");
      parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      return parts.join(",");
    }

		
</script>