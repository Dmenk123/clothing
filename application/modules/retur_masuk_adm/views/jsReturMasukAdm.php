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
   $("#modal_ret_masuk").on("hidden.bs.modal", function(){
      $('#form_ret_masuk')[0].reset();
      $("[name='formRetMasuk']").validate().resetForm();
      //clear tr append in modal
      $('tr').remove('.tbl_modal_row');
      $('option').remove('.appendOpt');
   });

   //datatables  
   // tabel retur masuk
	table = $('#tableReturMasuk').DataTable({
		
		"processing": true, 
		"serverSide": true, 
		//"order":[[ 2, 'desc' ]],
      "order":[], //initial no order 
		//load data for table content from ajax source
		"ajax": {
			"url": "<?php echo site_url('retur_masuk_adm/list_retur_masuk') ?>",
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
   $('#form_id_retur_out').change(function() {
      //remove tr before appending
      $('tr').remove('.tbl_modal_row');
      let idReturOut = this.value;
      $.ajax({
         url: "<?php echo site_url('retur_masuk_adm/list_data_retur_keluar') ?>",
         type: 'POST',
         dataType: 'json',
         data: {idReturOut: idReturOut},
         success: function(data){
            $('#form_supplier_ret_masuk').val(data.supplier.nama_supplier);
            $('#form_id_supplier_ret_masuk').val(data.supplier.id_supplier);
            let i = randString(5);
            let key = 1;
            Object.keys(data.data_list).forEach(function(){
               $('#tabel_retur_masuk').append('<tr class="tbl_modal_row" id="row'+i+'">'
                  +'<td><input type="hidden" name="fieldIdRetOutDet[]" value="'+data.data_list[key-1].id_retur_keluar_detail+'" id="field_id_ret_out_det" class="form-control">'
                  +'<input type="hidden" name="fieldIdRetOut[]" value="'+data.data_list[key-1].id_retur_keluar+'" id="field_id_ret_order" class="form-control">'
                  +'<input type="text" name="fieldNamaProdukRetMasuk[]" value="'+data.data_list[key-1].nama_produk+'" id="field_nama_produk_ret_masuk" class="form-control" required readonly>'
                  +'<input type="hidden" name="fieldIdProdukRetMasuk[]" value="'+data.data_list[key-1].id_produk+'" id="field_id_produk_ret_masuk" class="form-control"></td>'
                  +'<td><input type="text" name="fieldNamaSatuanRetMasuk[]" value="'+data.data_list[key-1].nama_satuan+'" id="field_nama_satuan_ret_masuk" class="form-control" required readonly>'
                  +'<input type="hidden" name="fieldIdSatuanRetMasuk[]" value="'+data.data_list[key-1].id_satuan+'" id="field_id_satuan_ret_masuk" class="form-control"></td>'
                  +'<td><input type="text" name="fieldJumlahRetMasuk[]" value="'+data.data_list[key-1].qty+'" id="field_jumlah_ret_masuk" class="form-control" required></td>'
                  +'<td><input type="text" name="fieldSizeRetMasuk[]" value="'+data.data_list[key-1].ukuran+'" id="field_size_ret_masuk" class="form-control" required readonly>'
                  +'<input type="hidden" name="fieldIdStokRetMasuk[]" value="'+data.data_list[key-1].id_stok+'" id="field_id_stok_ret_masuk" class="form-control" required readonly></td>'
                  +'<td><input type="text" name="fieldKetRetMasuk[]" value="" id="field_ket_ret_masuk" class="form-control" placeholder="Keterangan produk hasil Retur (misal: baik/cacat)"></td>'
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
   $("[name='formRetMasuk']").validate({
      // Specify validation rules
      errorElement: 'span',
      /*errorLabelContainer: '.errMsg',*/
      errorPlacement: function(error, element) {
         if (element.attr("name") == "formIdRetOut") {
            error.insertAfter(".lblIdRetOutErr");
         } else {
            error.insertAfter(element);
         }
      },
      rules:{
         formIdRetOut: "required"
      },
      // Specify validation error messages
      messages: {
         formIdRetOut: " (Harus diisi !!)"
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

function addReturMasuk() 
{
	save_method = 'add'; 
   $('[name="formIdRetOut"]').attr("disabled", false); 
	$('#form_ret_masuk')[0].reset(); //reset form on modals
	$('#modal_ret_masuk').modal('show'); //show bootstrap modal
	$('.modal-title').text('Tambah Penerimaan Retur'); //set title modal
   //get data header
   $.ajax({
      url : "<?php echo site_url('retur_masuk_adm/get_header_form_retur_masuk/')?>",
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
         $('[name="formIdRetMasuk"]').val(data.kode_retur_masuk);
         let key = 1;
         Object.keys(data.kode_retur_keluar).forEach(function(){
            $('#form_id_retur_out').append('<option class="appendOpt" value="'+data.kode_retur_keluar[key-1].id_retur_keluar+'">'+data.kode_retur_keluar[key-1].id_retur_keluar+'</option>');
            key++;
         });
      }
   });
}

function editReturMasuk(id)
{
   save_method = 'update';
   $('#form_ret_masuk')[0].reset(); // reset form on modals
   $('#modal_ret_masuk').modal('show'); // show bootstrap modal when complete loaded
   $('.modal-title').text('Edit Penerimaan Retur');
   $.ajax({
      url : "<?php echo site_url('retur_masuk_adm/edit_retur_masuk/')?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
         $('[name="formIdRetMasuk"]').val(data.data_header[0].id_retur_masuk);
         $('[name="formSupplierRetMasuk"]').val(data.data_header[0].id_supplier);
         $('[name="formIdSupplierRetMasuk"]').val(data.data_header[0].nama_supplier);
         //append option value
         $('[name="formIdRetOut"]').append('<option class="appendOpt" value="'+data.data_header[0].id_retur_keluar+'">'+data.data_header[0].id_retur_keluar+'</option>');
         // set option value selected
         $('[name="formIdRetOut"]').val(data.data_header[0].id_retur_keluar);
         //set attribute
         $('[name="formIdRetOut"]').attr("disabled", true); 
         
         let i = randString(5);
         let key = 1;
         Object.keys(data.data_isi).forEach(function(){
               $('#tabel_retur_masuk').append('<tr class="tbl_modal_row" id="row'+i+'">'
                  +'<td><input type="hidden" name="fieldIdRetOutDet[]" value="'+data.data_isi[key-1].id_retur_keluar_detail+'" id="field_id_ret_out_det" class="form-control">'
                  +'<input type="hidden" name="fieldIdRetOut[]" value="'+data.data_isi[key-1].id_retur_keluar+'" id="field_id_ret_order" class="form-control">'
                  +'<input type="text" name="fieldNamaProdukRetMasuk[]" value="'+data.data_isi[key-1].nama_produk+'" id="field_nama_produk_ret_masuk" class="form-control" required readonly>'
                  +'<input type="hidden" name="fieldIdProdukRetMasuk[]" value="'+data.data_isi[key-1].id_produk+'" id="field_id_produk_ret_masuk" class="form-control"></td>'
                  +'<td><input type="text" name="fieldNamaSatuanRetMasuk[]" value="'+data.data_isi[key-1].nama_satuan+'" id="field_nama_satuan_ret_masuk" class="form-control" required readonly>'
                  +'<input type="hidden" name="fieldIdSatuanRetMasuk[]" value="'+data.data_isi[key-1].id_satuan+'" id="field_id_satuan_ret_masuk" class="form-control"></td>'
                  +'<td><input type="text" name="fieldJumlahRetMasuk[]" value="'+data.data_isi[key-1].qty+'" id="field_jumlah_ret_masuk" class="form-control" required></td>'
                  +'<td><input type="text" name="fieldSizeRetMasuk[]" value="'+data.data_isi[key-1].ukuran+'" id="field_size_ret_masuk" class="form-control" required readonly>'
                  +'<input type="hidden" name="fieldIdStokRetMasuk[]" value="'+data.data_isi[key-1].id_stok+'" id="field_id_stok_ret_masuk" class="form-control" required readonly></td>'
                  +'<td><input type="text" name="fieldKetRetMasuk[]" value="'+data.data_isi[key-1].keterangan+'" id="field_ket_ret_masuk" class="form-control" placeholder="Keterangan produk hasil Retur (misal: baik/cacat)"></td>'
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

function saveRetMasuk()
{
   let url;

   if(save_method == 'add') {
      url = "<?php echo site_url('retur_masuk_adm/add_retur_masuk')?>";
   } else {
      url = "<?php echo site_url('retur_masuk_adm/update_retur_masuk')?>";
   }

   // ajax adding data to database
   let IsValid = $("form[name='formRetMasuk']").valid();
   if(IsValid) {
      $('#btnSave').text('saving...'); //change button text
      $('#btnSave').attr('disabled',true); //set button disable 
      $.ajax({
         url : url,
         type: "POST",
         data: $('#form_ret_masuk').serialize(),
         dataType: "JSON",
         success: function(data)
         {
            if(data.status) //if success close modal and reload ajax table
            {
               alert(data.pesan);
               $('#modal_ret_masuk').modal('hide');
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

function deleteReturMasuk(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('retur_masuk_adm/delete_penerimaan_retur')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                $('#modal_ret_masuk').modal('hide');
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
