<script type="text/javascript">
	let save_method; //for save method string
	let table;


$(document).ready(function() {
   //force integer input in textfield
   $('input.numberinput').bind('keypress', function (e) {
      return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
   });

   $(document).on('click', '.btn_remove', function(){
      let button_id = $(this).attr('id');
      $('#row'+button_id+'').remove();
   });

   // select class modal apabila bs.modal hidden
   $("#modal_terima_order").on("hidden.bs.modal", function(){
      $('#form_masuk')[0].reset();
      $("[name='formMasuk']").validate().resetForm();
      //clear tr append in modal
      $('tr').remove('.tbl_modal_row');
      $('option').remove('.appendOpt');
   });

   //datatables  
   // tabel trans masuk
	table = $('#tableTerimaProduk').DataTable({
		
		"processing": true, 
		"serverSide": true, 
		//"order":[[ 2, 'desc' ]],
      "order":[], //initial no order 
		//load data for table content from ajax source
		"ajax": {
			"url": "<?php echo site_url('terima_produk_adm/list_terima_produk') ?>",
			"type": "POST" 
		},

		"columnDefs": [
			{
				"targets": [-1], //last column
				"orderable": false, //set not orderable
			},
		],
	});

   //autofill
   $('#form_id_order').change(function() {
      //remove tr before appending
      $('tr').remove('.tbl_modal_row');
      let idOrder = this.value;
      $.ajax({
         url: "<?php echo site_url('terima_produk_adm/list_permintaan') ?>",
         type: 'POST',
         dataType: 'json',
         data: {idOrder: idOrder},
         success: function(data){
            $('#form_supplier_masuk').val(data.supplier.nama_supplier);
            $('#form_id_supplier_masuk').val(data.supplier.id_supplier);
            let i = randString(5);
            let key = 1;
            Object.keys(data.data_list).forEach(function(){
               $('#tabel_masuk').append('<tr class="tbl_modal_row" id="row'+i+'">'
                  +'<td><input type="hidden" name="fieldIdOrderDet[]" value="'+data.data_list[key-1].id_trans_order_detail+'" id="field_id_order_det" class="form-control">'
                  +'<input type="hidden" name="fieldIdOrder[]" value="'+data.data_list[key-1].id_trans_order+'" id="field_id_order" class="form-control">'
                  +'<input type="text" name="fieldNamaProdukMasuk[]" value="'+data.data_list[key-1].nama_produk+'" id="field_nama_produk_masuk" class="form-control" required readonly>'
                  +'<input type="hidden" name="fieldIdProdukMasuk[]" value="'+data.data_list[key-1].id_produk+'" id="field_id_produk_masuk" class="form-control"></td>'
                  +'<td><input type="text" name="fieldNamaSatuanMasuk[]" value="'+data.data_list[key-1].nama_satuan+'" id="field_nama_satuan_masuk" class="form-control" required readonly>'
                  +'<input type="hidden" name="fieldIdSatuanMasuk[]" value="'+data.data_list[key-1].id_satuan+'" id="field_id_satuan_masuk" class="form-control"></td>'
                  +'<td><input type="text" name="fieldJumlahProdukMasuk[]" value="'+data.data_list[key-1].qty+'" id="field_jumlah_produk_masuk" class="form-control" required></td>'
                  +'<td><input type="text" name="fieldSizeProdukMasuk[]" value="'+data.data_list[key-1].ukuran+'" id="field_size_produk_masuk" class="form-control" required readonly>'
                  +'<input type="hidden" name="fieldIdStokMasuk[]" value="'+data.data_list[key-1].id_stok+'" id="field_id_stok_masuk" class="form-control" required readonly></td>'
                  +'<td><input type="text" name="fieldKetProdukMasuk[]" value="" id="field_ket_produk_masuk" class="form-control" placeholder="Keterangan produk (misal: baik/cacat)"></td>'
                  +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td>'
               +'</tr>');
               key++;  
               i = randString(5);
            });
         },
         error: function(e) {
            console.log("ERROR : ", e);
         }
      });
   });

   //validasi form trans masuk
   $("[name='formMasuk']").validate({
      // Specify validation rules
      errorElement: 'span',
      /*errorLabelContainer: '.errMsg',*/
      errorPlacement: function(error, element) {
         if (element.attr("name") == "fieldIdOrder") {
            error.insertAfter(".lblIdOrderErr");
         } else {
            error.insertAfter(element);
         }
      },
      rules:{
         fieldIdOrder: "required"
      },
      // Specify validation error messages
      messages: {
         fieldIdOrder: " (Harus diisi !!)"
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

function addTerimaProduk() 
{
	save_method = 'add'; 
   $('[name="fieldIdOrder"]').attr("disabled", false); 
	$('#form_masuk')[0].reset(); //reset form on modals
	$('#modal_terima_order').modal('show'); //show bootstrap modal
	$('.modal-title').text('Transaksi Penrimaan Produk'); //set title modal
   //get data header
   $.ajax({
      url : "<?php echo site_url('terima_produk_adm/get_header_form_masuk/')?>",
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
         $('[name="fieldIdMasuk"]').val(data.kode_trans_masuk);
         let key = 1;
         Object.keys(data.kode_po).forEach(function(){
            $('#form_id_order').append('<option class="appendOpt" value="'+data.kode_po[key-1].id_trans_order+'">'+data.kode_po[key-1].id_trans_order+'</option>');
            key++;
         });
      }
   });
}

function editTerimaProduk(id)
{
   save_method = 'update';
   $('#form_masuk')[0].reset(); // reset form on modals
   $('#modal_terima_order').modal('show'); // show bootstrap modal when complete loaded
   $('.modal-title').text('Edit Penerimaan Produk');
   $.ajax({
      url : "<?php echo site_url('terima_produk_adm/edit_terima_produk/')?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
         $('[name="fieldIdMasuk"]').val(data.data_header[0].id_trans_masuk);
         $('[name="fieldSupplierMasuk"]').val(data.data_header[0].id_supplier);
         $('[name="fieldIdSupplierMasuk"]').val(data.data_header[0].nama_supplier);
         //append option value
         $('[name="fieldIdOrder"]').append('<option class="appendOpt" value="'+data.data_header[0].id_trans_order+'">'+data.data_header[0].id_trans_order+'</option>');
         // set option value selected
         $('[name="fieldIdOrder"]').val(data.data_header[0].id_trans_order);
         //set attribute
         $('[name="fieldIdOrder"]').attr("disabled", true); 
         
         let i = randString(5);
         let key = 1;
         Object.keys(data.data_isi).forEach(function(){
               $('#tabel_masuk').append('<tr class="tbl_modal_row" id="row'+i+'">'
                  +'<td><input type="hidden" name="fieldIdOrderDet[]" value="'+data.data_isi[key-1].id_trans_order_detail+'" id="field_id_order_det" class="form-control">'
                  +'<input type="hidden" name="fieldIdOrder[]" value="'+data.data_isi[key-1].id_trans_order+'" id="field_id_order" class="form-control">'
                  +'<input type="text" name="fieldNamaProdukMasuk[]" value="'+data.data_isi[key-1].nama_produk+'" id="field_nama_produk_masuk" class="form-control" required readonly>'
                  +'<input type="hidden" name="fieldIdProdukMasuk[]" value="'+data.data_isi[key-1].id_produk+'" id="field_id_produk_masuk" class="form-control"></td>'
                  +'<td><input type="text" name="fieldNamaSatuanMasuk[]" value="'+data.data_isi[key-1].nama_satuan+'" id="field_nama_satuan_masuk" class="form-control" required readonly>'
                  +'<input type="hidden" name="fieldIdSatuanMasuk[]" value="'+data.data_isi[key-1].id_satuan+'" id="field_id_satuan_masuk" class="form-control"></td>'
                  +'<td><input type="text" name="fieldJumlahProdukMasuk[]" value="'+data.data_isi[key-1].qty+'" id="field_jumlah_produk_masuk" class="form-control" required></td>'
                  +'<td><input type="text" name="fieldSizeProdukMasuk[]" value="'+data.data_isi[key-1].ukuran+'" id="field_size_produk_masuk" class="form-control" required readonly>'
                  +'<input type="hidden" name="fieldIdStokMasuk[]" value="'+data.data_isi[key-1].id_stok+'" id="field_id_stok_masuk" class="form-control" required readonly></td>'
                  +'<td><input type="text" name="fieldKetProdukMasuk[]" value="'+data.data_isi[key-1].keterangan+'" id="field_ket_produk_masuk" class="form-control"></td>'
                  +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td>'
               +'</tr>');
               key++;  
               i = randString(5);
            });
      },
      error: function (e) {
         console.log("ERROR : ", e);
      }
   });
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function savePenerimaan()
{
   let url;

   if(save_method == 'add') {
      url = "<?php echo site_url('terima_produk_adm/add_terima_produk')?>";
   } else {
      url = "<?php echo site_url('terima_produk_adm/update_terima_produk')?>";
   }

   // ajax adding data to database
   let IsValid = $("form[name='formMasuk']").valid();
   if(IsValid) {
      $('#btnSave').text('saving...'); //change button text
      $('#btnSave').attr('disabled',true); //set button disable 
      $.ajax({
         url : url,
         type: "POST",
         data: $('#form_masuk').serialize(),
         dataType: "JSON",
         success: function(data)
         {
            if(data.status) //if success close modal and reload ajax table
            {
               alert(data.pesan);
               $('#modal_terima_order').modal('hide');
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

function deleteTerimaProduk(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('terima_produk_adm/delete_penerimaan_produk')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                $('#modal_terima_order').modal('hide');
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
