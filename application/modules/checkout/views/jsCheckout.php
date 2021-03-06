<script type="text/javascript">
    var edit_type;
	const selectProv = () => {
		$('#kota').empty();
		$("#kecamatan").empty();
		$("#kelurahan").empty(); 
		var idProvinsi = $('#provinsi').val();
		$( "#kota" ).select2({
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
	}

	const showHarga = (kurir) => {
		$('#div-harga-kurir').slideUp();

		$.ajax({
			type: "post",
			url: '<?php echo site_url('checkout/get_data_harga'); ?>',
			data: {kurir:kurir},
			dataType: "json",
			success: function (response) {
				if(response.status) {
					$('#tabel-harga-kurir').html(response.html);
				}
			}
		});

		$('#div-harga-kurir').slideDown();
	}

	const pilihKurir = (cb) => {
		swal({
			title: "Perhatian",
			text: "Pilih Kurir ini ?",
			// icon: "warning",
			showCancelButton: true,
			showConfirmButton: true,
			confirmButtonText: 'Ya',
			cancelButtonText: 'Tidak',
			dangerMode: false,
		}, () => {
			let data = {
				'kurir' : cb.closest('tr').find('td[data-kurir]').data('kurir'),
				'paket' : cb.closest('tr').find('td[data-paket]').data('paket'),
				'asal' : cb.closest('tr').find('td[data-asal]').data('asal'),
				'tujuan' : cb.closest('tr').find('td[data-tujuan]').data('tujuan'),
				'estimasi' : cb.closest('tr').find('td[data-estimasi]').data('estimasi'),
				'harga' : cb.closest('tr').find('td[data-harga]').data('harga')
			};

			$.ajax({
				type: "POST",
				url: '<?php echo site_url('checkout/simpan_data_kurir'); ?>',
				data: data,
				dataType: "JSON",
				// timeout: 600000,
				success: function (data) {
					if(data.status) {
						$('#div-kurir-terpilih').html(data.html);
					}
				},
				error: function (e) {
					console.log("ERROR : ", e);
				}
			});
		});
	}

	const loadDataKurirTerpilih = () => {
		$.ajax({
			type: "POST",
			url: '<?php echo site_url('checkout/get_data_kurir_terpilih'); ?>',
			dataType: "JSON",
			success: function (data) {
				//console.log(data);
				if(data.status) {
					$('#div-kurir-terpilih').html(data.html);
				}
			},
			error: function (e) {
				console.log("ERROR : ", e);
			}
		});
	}

	const lihatBukti = (imgfile, kodeVerify) => {
		var urlBukti = "<?=base_url();?>"+imgfile;
		$('#modalBukti').modal('show');
		$('#imageArea').attr('src', urlBukti);
		$('#judul').text('Bukti Transfer Kode  : '+kodeVerify);
	}

	const readURL = (input) => {
        if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#div_preview_foto').css("display","block");
            $('#preview_img').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        } else {
            $('#div_preview_foto').css("display","none");
            $('#preview_img').attr('src', '');
        }
    }

	const aksi_transfer = () => {
        var form = $('#form_proses_transfer')[0];
        var data = new FormData(form);
		
        $("#pay-button").prop("disabled", true);
        $('#pay-button').text('Menyimpan Data'); //change button text
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "<?=base_url('checkout/trans_manual')?>",
            data: data,
            dataType: "JSON",
            processData: false, // false, it prevent jQuery form transforming the data into a query string
            contentType: false, 
            cache: false,
            timeout: 600000,
            success: function (data) {
                if(data.status) {
                    swal("Sukses!!", "Pembayaran Transfer Berhasil", "success");
                    $("#pay-button").prop("disabled", false);
                    $('#pay-button').text('Proses Data Pembayaran');
                    window.location = data.redirect;
                }else {
                    for (var i = 0; i < data.inputerror.length; i++) 
                    {
                        if (data.inputerror[i] != 'pegawai') {
                            $('[name="'+data.inputerror[i]+'"]').addClass('is-invalid');
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]).addClass('invalid-feedback'); //select span help-block class set text error string
                        }else{
                            //ikut style global
                            $('[name="'+data.inputerror[i]+'"]').next().next().text(data.error_string[i]).addClass('invalid-feedback-select');
                        }
                    }

                    $("#pay-button").prop("disabled", false);
                    $('#pay-button').text('Proses Data Pembayaran');
                }
            },
            error: function (e) {
                console.log("ERROR : ", e);
                $("#pay-button").prop("disabled", false);
                $('#pay-button').text('Proses Data Pembayaran');

                reset_modal_form();
                $(".modal").modal('hide');
            }
        });
    }

	
	$(document).ready(function(){
		loadDataKurirTerpilih();
		//set active class to navbar
		$('#li_nav_home').removeClass('active');
		$('#li_nav_kontak').addClass('active');
		
        //force integer input in textfield
        $('input.numberinput').bind('keypress', function (e) {
            return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
        });

		$("#provinsi").select2({
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

		<?php 
		if ($data_cart && $data_cart->id_prov)  {
			echo '$("#provinsi").append($("<option selected=\'selected\'></option>").val("'.$data_cart->id_prov.'").text("'.$data_cart->nama_provinsi.'")).trigger(\'change\');';
			echo "selectProv();";
			echo '$("#kota").append($("<option selected=\'selected\'></option>").val("'.$data_cart->id_kota.'").text("'.$data_cart->nama_kota.'")).trigger(\'change\');';
		}
		?>
		
		$('#form_step1').submit(function (e) { 
			e.preventDefault();
			var form = $('#form_step1')[0];
			var data = new FormData(form);
			$('.tombol-ckt').prop('disabled', true);
			// swal({
			// 	title: "Yakin Lanjutkan ?",
			// 	text: "Anda akan melanjutkan ke tahap selanjutnya !",
			// 	// icon: "warning",
			// 	showCancelButton: true,
			// 	showConfirmButton: true,
			// 	confirmButtonText: 'Ya, Lanjutkan',
			// 	cancelButtonText: 'Tidak, Batalkan',
			// 	dangerMode: false,
			// }, () => {
				$.ajax({
					type: "POST",
					enctype: 'multipart/form-data',
					url: '<?php echo site_url('checkout/simpan_step1'); ?>',
					data: data,
					dataType: "JSON",
					processData: false, // false, it prevent jQuery form transforming the data into a query string
					contentType: false, 
					cache: false,
					// timeout: 600000,
					success: function (data) {
						if(data.status) {
							
							location.href="<?php echo site_url('checkout/step2'); ?>";
														
							// $("#btnSave").prop("disabled", false);
							// $('#btnSave').text('Simpan');
						}else {
							for (var i = 0; i < data.inputerror.length; i++) 
							{
								if (data.inputtipe[i] != 'select2') {
									$('[name="'+data.inputerror[i]+'"]').addClass('is-invalid');
									$('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]).addClass('invalid-feedback'); //select span help-block class set text error string
								}else{
									$($('[name="'+data.inputerror[i]+'"]').data('select2').$container).addClass('has-error');
									$($('[name="'+data.inputerror[i]+'"]').data('select2').$container).next().text(data.error_string[i]).addClass('invalid-feedback');
								}
							}
						}
					},
					error: function (e) {
						console.log("ERROR : ", e);
					}
				});
			// });

		});

		$('#form_step2').submit(function (e) { 
			e.preventDefault();
			var form = $('#form_step2')[0];
			var data = new FormData(form);
			$('.tombol-ckt').prop('disabled', true);

			// swal({
			// 	title: "Yakin Lanjutkan ?",
			// 	text: "Anda akan melanjutkan ke tahap selanjutnya !",
			// 	// icon: "warning",
			// 	showCancelButton: true,
			// 	showConfirmButton: true,
			// 	confirmButtonText: 'Ya, Lanjutkan',
			// 	cancelButtonText: 'Tidak, Batalkan',
			// 	dangerMode: false,
			// }, () => {
				$.ajax({
					type: "POST",
					enctype: 'multipart/form-data',
					url: '<?php echo site_url('checkout/simpan_step2'); ?>',
					data: data,
					dataType: "JSON",
					processData: false, // false, it prevent jQuery form transforming the data into a query string
					contentType: false, 
					cache: false,
					// timeout: 600000,
					success: function (data) {
						if(data.status) {
							location.href="<?php echo site_url('checkout/step3'); ?>";
						}else {
							alert(data.pesan);
							$('.tombol-ckt').prop('disabled', false);
						}
					},
					error: function (e) {
						console.log("ERROR : ", e);
					}
				});
			// });

		});
		
		
		$('.tombol_method_bayar').click(function (e) { 
			e.preventDefault();
			
			$([document.documentElement, document.body]).animate({
				scrollTop: $("#main-form-bayar").offset().top-50
			}, 2000);
			
			var file_inc = $(this).attr("href");
			if (file_inc == "payment") {
				$.ajax({
					method : 'POST',
					url: '<?=base_url()?>snap/token',
					data : {id: "a1", price: 10000, quantity: 2, name: "coba", gross_amount: 1000},
					cache: false,

					success: function(data) {
						//location = data;

						console.log('token = '+data);
						
						var resultType = document.getElementById('result-type');
						var resultData = document.getElementById('result-data');

						function changeResult(type,data){
						$("#result-type").val(type);
						$("#result-data").val(JSON.stringify(data));
						//resultType.innerHTML = type;
						//resultData.innerHTML = JSON.stringify(data);
						}

						snap.pay(data, {
						
						onSuccess: function(result){
							changeResult('success', result);
							console.log(result.status_message);
							console.log(result);
							$("#payment-form").submit();
						},
						onPending: function(result){
							changeResult('pending', result);
							console.log(result.status_message);
							$("#payment-form").submit();
						},
						onError: function(result){
							changeResult('error', result);
							console.log(result.status_message);
							$("#payment-form").submit();
						}
						});
					}
					});
			} else {
				$.ajax({
					type: "get",
					url: "<?=base_url('checkout/get_html_form')?>",
					data: {file_inc:file_inc},
					dataType: "json",
					success: function (response) {
						$('#main-form-bayar').html(response);
					}
				});
			}
			
		});

		/////////////////////////////////////////////////////      

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

