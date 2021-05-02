<script type="text/javascript">
	let save_method; //for save method string
	let table;

$(document).ready(function(){
  
  //declare random variabel for row count
  let i = randString(5);
	//addrow field inside modal
  $('#btn_add_row').click(function() {
      let ambilNama = $('#form_nama_produk_order').val();
      let ambilIdNama = $('#form_id_produk_order').val();
      let ambilSatuan = $('#form_nama_satuan_order').val();
      let ambilIdSatuan = $('#form_id_satuan_order').val();
      let ambilJumlah = $('#form_jumlah_produk_order').val();
      let ambilSize = $('#form_size_produk_order').val();
      let ambilIdStok = $('#form_id_stok_order').val();
      let ambilPrevCost = $('#form_harga_prev_order').val();
      let ambilHargaSat = $('#form_harga_sat_order').val();
      let ambilHargaTot = $('#form_harga_tot_order').val();
         if (ambilNama == "" || ambilSatuan == "" || ambilJumlah == "" || ambilIdNama == "" || ambilSize == "" || ambilHargaSat == "") {
         alert('ada field yang tidak diisi, Mohon cek lagi!!');
         }else{
            $('#tabel_order').append(
               '<tr class="tbl_modal_row" id="row'+i+'">'
               +'<td><input type="text" name="fieldNamaProdukOrder[]" value="'+ambilNama+'" id="field_nama_produk_order" class="form-control" required readonly>'
               +'<input type="hidden" name="fieldIdProdukOrder[]" value="'+ambilIdNama+'" id="field_id_produk_order" class="form-control"></td>'
               +'<td><input type="text" name="fieldNamaSatuanOrder[]" value="'+ambilSatuan+'" id="field_nama_satuan_order" class="form-control" required readonly>'
               +'<input type="hidden" name="fieldIdSatuanOrder[]" value="'+ambilIdSatuan+'" id="field_id_satuan_order" class="form-control"></td>'
               +'<td><input type="text" name="fieldJumlahProdukOrder[]" value="'+ambilJumlah+'" id="field_jumlah_produk_order" class="form-control" required readonly></td>'
               +'<td><input type="text" name="fieldSizeProdukOrder[]" value="'+ambilSize+'" id="field_size_produk_order" class="form-control" required readonly>'
               +'<input type="hidden" name="fieldIdStokOrder[]" value="'+ambilIdStok+'" id="field_id_stok_order" class="form-control" required readonly></td>'
               +'<td><input type="text" name="fieldHargaPrevOrder[]" value="'+ambilPrevCost+'" id="field_harga_prev_order" class="form-control" readonly></td>'
               +'<td><input type="text" name="fieldHargaSatOrder[]" value="'+ambilHargaSat+'" id="field_harga_sat_order" class="form-control" required readonly></td>'
               +'<td><input type="text" name="fieldHargaTotOrder[]" value="'+ambilHargaTot+'" id="field_harga_tot_order" class="form-control" required readonly></td>'
               +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td>'
            +'</tr>');
            i = randString(5);
            //kosongkan field setelah append row
            $('#form_nama_produk_order').val("");
            $('#form_id_produk_order').val("");
            $('#form_nama_satuan_order').val("");
            $('#form_id_satuan_order').val("");
            $('#form_jumlah_produk_order').val("");
            $('#form_id_stok_order').val("");
            $('#form_harga_prev_order').val("");
            $('#form_harga_sat_order').val("");
            $('#form_harga_tot_order').val("");
            $('#form_size_produk_order').empty();
         } 
  });

  //force integer input in textfield
  $('input.numberinput').bind('keypress', function (e) {
    return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
  });

  $(document).on('click', '.btn_remove', function(){
    let button_id = $(this).attr('id');
    $('#row'+button_id+'').remove();
  });

  // select class modal apabila bs.modal hidden
  $("#modal_form_order").on("hidden.bs.modal", function(){
      $('#form_order')[0].reset();
      $('#form_size_produk_order').empty();
      $("[name='formOrder']").validate().resetForm();
      //clear tr append in modal
      $('tr').remove('.tbl_modal_row'); 
  });

  // tabel trans order
	table = $('#tableOrderProduk').DataTable({
		
		"processing": true, 
		"serverSide": true, 
		//"order":[[ 2, 'desc' ]],
      "order":[], //initial no order 
		//load data for table content from ajax source
		"ajax": {
			"url": "<?php echo site_url('order_produk_adm/list_order_produk') ?>",
			"type": "POST" 
		},

		"columnDefs": [
			{
				"targets": [-1], //last column
				"orderable": false, //set not orderable
			},
		],
	});

  //event keyup total harga
  $("#form_harga_sat_order").keyup(function(){
      let jumlahOrder = $('#form_jumlah_produk_order').val();
      let hargaSatuan = $('#form_harga_sat_order').val();
      let hargaTotal = jumlahOrder * hargaSatuan;
      $('#form_harga_tot_order').val(hargaTotal);
  });

  //autocomplete
  $('#form_nama_produk_order').autocomplete({
      minLength: 0,
      delay: 0,
      source: '<?php echo site_url('order_produk_adm/suggest_produk'); ?>',
      select:function(event, ui) {
         $('#form_id_produk_order').val(ui.item.id_produk);
         $('#form_nama_satuan_order').val(ui.item.nama_produk);
         $('#form_id_satuan_order').val(ui.item.id_satuan);
         $('#form_nama_satuan_order').val(ui.item.nama_satuan);
      },
      change: function() {
         $('#form_size_produk_order').empty();

         var idProduk = $('#form_id_produk_order').val();
         $.ajax({
            url: "<?php echo site_url('order_produk_adm/suggest_size_prevcost') ?>",
            type: "POST",
            dataType: "JSON",
            data: {idProduk: idProduk},
            success: function(data){
               var key = 1;
               $('#form_size_produk_order').append('<option value="">-</option>');
               Object.keys(data.size).forEach(function(){
               $('#form_size_produk_order').append('<option value="'+data.size[key-1].ukuran_produk+'">'+data.size[key-1].ukuran_produk+'</option>'); 
                  key++;
               });
            $('#form_harga_prev_order').val(data.cost);
            }    
         });
      }
  });

  $('#form_size_produk_order').on('change', function() {
      let nmSize = this.value;
      let idProd = $('#form_id_produk_order').val();
      $.ajax({
         url: "<?php echo site_url('order_produk_adm/suggest_idstok') ?>",
         type: 'POST',
         dataType: 'json',
         data: {nmSize: nmSize, idProd: idProd},
         success: function(data){
            $('#form_id_stok_order').val(data);
         }
      });
  });

   //validasi form order
  $("[name='formOrder']").validate({
      // Specify validation rules
      errorElement: 'span',
      /*errorLabelContainer: '.errMsg',*/
      errorPlacement: function(error, element) {
         if (element.attr("name") == "fieldSupplier") {
            error.insertAfter(".lblSupErr");
         } else {
            error.insertAfter(element);
         }
      },
      rules:{
         fieldSupplier: "required"
      },
      // Specify validation error messages
      messages: {
         fieldSupplier: " (Harus diisi !!)"
      },
      submitHandler: function(form) {
         form.submit();
      }
  });
  
  //end jquery
});	

function randString(angka) 
{
   let text = "";
   let possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

   for (let i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

   return text;
}

function addOrderProduk() 
{
	save_method = 'add'; 
	$('#form_order')[0].reset(); //reset form on modals
	$('#modal_form_order').modal('show'); //show bootstrap modal
	$('.modal-title').text('Transaksi Order Produk'); //set title modal
  //get data header
  $.ajax({
    url : "<?php echo site_url('order_produk_adm/get_header_form_order/')?>",
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
      $('[name="fieldIdOrder"]').val(data.kode_trans_order);
    }
  });
}

function editOrderProduk(id)
{
    save_method = 'update';
    $('#form_order')[0].reset(); // reset form on modals
    $('#modal_form_order').modal('show'); // show bootstrap modal when complete loaded
    $('.modal-title').text('Edit Order Produk');
    $.ajax({
        url : "<?php echo site_url('order_produk_adm/edit_order_produk/')?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="fieldIdOrder"]').val(data.data_header[0].id_trans_order);
            $('[name="fieldSupplier"]').val(data.data_header[0].id_supplier);
            //isi
            let i = randString(5);
            let key_isi = 1;
            Object.keys(data.data_isi).forEach(function(){         
              $('#tabel_order').append('<tr class="tbl_modal_row" id="row'+i+'">'
                +'<td><input type="text" name="fieldNamaProdukOrder[]" value="'+data.data_isi[key_isi-1].nama_produk+'" id="field_nama_produk_order" class="form-control" required readonly>'
                +'<input type="hidden" name="fieldIdProdukOrder[]" value="'+data.data_isi[key_isi-1].id_produk+'" id="field_id_produk_order" class="form-control"></td>'
                +'<td><input type="text" name="fieldNamaSatuanOrder[]" value="'+data.data_isi[key_isi-1].nama_satuan+'" id="field_nama_satuan_order" class="form-control" required readonly>'
                +'<input type="hidden" name="fieldIdSatuanOrder[]" value="'+data.data_isi[key_isi-1].id_satuan+'" id="field_id_satuan_order" class="form-control"></td>'
                +'<td><input type="text" name="fieldJumlahProdukOrder[]" value="'+data.data_isi[key_isi-1].qty+'" id="field_jumlah_produk_order" class="form-control" required readonly></td>'
                +'<td><input type="text" name="fieldSizeProdukOrder[]" value="'+data.data_isi[key_isi-1].ukuran+'" id="field_size_produk_order" class="form-control" required readonly>'
                +'<input type="hidden" name="fieldIdStokOrder[]" value="'+data.data_isi[key_isi-1].id_stok+'" id="field_id_stok_order" class="form-control" required readonly></td>'
                +'<td><input type="text" name="fieldHargaPrevOrder[]" value="'+data.data_isi[key_isi-1].harga_prev_beli+'" id="field_harga_prev_order" class="form-control" readonly></td>'
                +'<td><input type="text" name="fieldHargaSatOrder[]" value="'+data.data_isi[key_isi-1].harga_satuan_beli+'" id="field_harga_sat_order" class="form-control" required readonly></td>'
                +'<td><input type="text" name="fieldHargaTotOrder[]" value="'+data.data_isi[key_isi-1].harga_total_beli+'" id="field_harga_tot_order" class="form-control" required readonly></td>'
                +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td>'
              +'</tr>');                    
              key_isi++;  
              i = randString(5);             
            });

            // select class modal apabila bs.modal hidden
            $("#modal_form_order").on("hidden.bs.modal", function(){
              //reset form value on modals
              $('#form')[0].reset(); 
              $('tr').remove('.tbl_modal_row'); 
            });
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
    let url;

    if(save_method == 'add') {
        url = "<?php echo site_url('order_produk_adm/add_order_produk')?>";
    } else {
        url = "<?php echo site_url('order_produk_adm/update_order_produk')?>";
    }

   // ajax adding data to database
   let IsValid = $("form[name='formOrder']").valid();
   if(IsValid) {
      $('#btnSave').text('saving...'); //change button text
      $('#btnSave').attr('disabled',true); //set button disable 
      $.ajax({
         url : url,
         type: "POST",
         data: $('#form_order').serialize(),
         dataType: "JSON",
         success: function(data)
         {
            if(data.status) //if success close modal and reload ajax table
            {
               alert(data.pesan);
               $('#modal_form_order').modal('hide');
               $('#btnSave').text('Save'); //change button text
               $('#btnSave').prop('disabled',false); //set button enable 
               reload_table();
            }
         },
         error: function (e) {
                console.log("ERROR : ", e);
                $("#btnSave").attr("disabled", false);
            }
       });
   }
}

function deleteOrderProduk(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('order_produk_adm/delete_order_produk')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                $('#modal_form_order').modal('hide');
                alert(data.pesan);
                reload_table();
            },
            error: function (e) {
                console.log("ERROR : ", e);
            }
        });
    }
}

</script>	
