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
   $("#modal_ret_keluar").on("hidden.bs.modal", function(){
      $('#form_ret_keluar')[0].reset();
      $("[name='formRetKeluar']").validate().resetForm();
      //clear tr append in modal
      $('tr').remove('.tbl_modal_row');
      $('option').remove('.appendOpt');
   });

   //datatables  
   // tabel retur masuk
	table = $('#tableReturKeluar').DataTable({
		
		"processing": true, 
		"serverSide": true, 
		//"order":[[ 2, 'desc' ]],
      "order":[], //initial no order 
		//load data for table content from ajax source
		"ajax": {
			"url": "<?php echo site_url('retur_keluar_adm/list_retur_keluar') ?>",
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
   $('#form_id_terima').change(function() {
      //remove tr before appending
      $('tr').remove('.tbl_modal_row');
      let idPenerimaan = this.value;
      $.ajax({
         url: "<?php echo site_url('retur_keluar_adm/list_penerimaan') ?>",
         type: 'POST',
         dataType: 'json',
         data: {idPenerimaan: idPenerimaan},
         success: function(data){
            $('#form_supplier_ret_keluar').val(data.supplier.nama_supplier);
            $('#form_id_supplier_ret_keluar').val(data.supplier.id_supplier);
            let i = randString(5);
            let key = 1;
            Object.keys(data.data_list).forEach(function(){
               $('#tabel_retur_keluar').append('<tr class="tbl_modal_row" id="row'+i+'">'
                  +'<td><input type="hidden" name="fieldIdMasukDet[]" value="'+data.data_list[key-1].id_trans_masuk_detail+'" id="field_id_masuk_det" class="form-control">'
                  +'<input type="hidden" name="fieldIdMasuk[]" value="'+data.data_list[key-1].id_trans_masuk+'" id="field_id_masuk" class="form-control">'
                  +'<input type="text" name="fieldNamaProdukRetKeluar[]" value="'+data.data_list[key-1].nama_produk+'" id="field_nama_produk_ret_keluar" class="form-control" required readonly>'
                  +'<input type="hidden" name="fieldIdProdukRetKeluar[]" value="'+data.data_list[key-1].id_produk+'" id="field_id_produk_ret_keluar" class="form-control"></td>'
                  +'<td><input type="text" name="fieldNamaSatuanRetKeluar[]" value="'+data.data_list[key-1].nama_satuan+'" id="field_nama_satuan_ret_keluar" class="form-control" required readonly>'
                  +'<input type="hidden" name="fieldIdSatuanRetKeluar[]" value="'+data.data_list[key-1].id_satuan+'" id="field_id_satuan_ret_keluar" class="form-control"></td>'
                  +'<td><input type="text" name="fieldJumlahRetKeluar[]" value="'+data.data_list[key-1].qty+'" id="field_jumlah_ret_keluar" class="form-control" required></td>'
                  +'<td><input type="text" name="fieldSizeRetKeluar[]" value="'+data.data_list[key-1].ukuran+'" id="field_size_ret_keluar" class="form-control" required readonly>'
                  +'<input type="hidden" name="fieldIdStokRetKeluar[]" value="'+data.data_list[key-1].id_stok+'" id="field_id_stok_ret_keluar" class="form-control" required readonly></td>'
                  +'<td><input type="text" name="fieldKetRetKeluar[]" value="" id="field_ket_ret_keluar" class="form-control" placeholder="Alasan Produk kenapa diretur ? (misal: cacat)"></td>'
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
   $("[name='formRetKeluar']").validate({
      // Specify validation rules
      errorElement: 'span',
      /*errorLabelContainer: '.errMsg',*/
      errorPlacement: function(error, element) {
         if (element.attr("name") == "formIdTerima") {
            error.insertAfter(".lblIdTerimaErr");
         } else {
            error.insertAfter(element);
         }
      },
      rules:{
         formIdTerima: "required"
      },
      // Specify validation error messages
      messages: {
         formIdTerima: " (Harus diisi !!)"
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

function addReturKeluar() 
{
	save_method = 'add'; 
   $('[name="formIdTerima"]').attr("disabled", false); 
	$('#form_ret_keluar')[0].reset(); //reset form on modals
	$('#modal_ret_keluar').modal('show'); //show bootstrap modal
	$('.modal-title').text('Tambah Pengeluaran Retur'); //set title modal
   //get data header
   $.ajax({
      url : "<?php echo site_url('retur_keluar_adm/get_header_form_retur_keluar/')?>",
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
         $('[name="formIdRetKeluar"]').val(data.kode_retur_keluar);
         let key = 1;
         Object.keys(data.kode_penerimaan).forEach(function(){
            $('#form_id_terima').append('<option class="appendOpt" value="'+data.kode_penerimaan[key-1].id_trans_masuk+'">'+data.kode_penerimaan[key-1].id_trans_masuk+'</option>');
            key++;
         });
      }
   });
}

function editReturKeluar(id)
{
   save_method = 'update';
   $('#form_ret_keluar')[0].reset(); // reset form on modals
   $('#modal_ret_keluar').modal('show'); // show bootstrap modal when complete loaded
   $('.modal-title').text('Edit Pengeluaran Retur');
   $.ajax({
      url : "<?php echo site_url('retur_keluar_adm/edit_retur_keluar/')?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
         $('[name="formIdRetKeluar"]').val(data.data_header[0].id_retur_keluar);
         $('[name="formIdSupplierRetKeluar"]').val(data.data_header[0].id_supplier);
         $('[name="formSupplierRetKeluar"]').val(data.data_header[0].nama_supplier);
         //append option value
         $('[name="formIdTerima"]').append('<option class="appendOpt" value="'+data.data_header[0].id_trans_masuk+'">'+data.data_header[0].id_trans_masuk+'</option>');
         // set option value selected
         $('[name="formIdTerima"]').val(data.data_header[0].id_trans_masuk);
         //set attribute
         $('[name="formIdTerima"]').attr("disabled", true); 
         
         let i = randString(5);
         let key = 1;
         Object.keys(data.data_isi).forEach(function(){
               $('#tabel_retur_keluar').append('<tr class="tbl_modal_row" id="row'+i+'">'
                  +'<td><input type="hidden" name="fieldIdMasukDet[]" value="'+data.data_isi[key-1].id_trans_masuk_detail+'" id="field_id_masuk_det" class="form-control">'
                  +'<input type="hidden" name="fieldIdMasuk[]" value="'+data.data_isi[key-1].id_trans_masuk+'" id="field_id_masuk" class="form-control">'
                  +'<input type="text" name="fieldNamaProdukRetKeluar[]" value="'+data.data_isi[key-1].nama_produk+'" id="field_nama_produk_ret_keluar" class="form-control" required readonly>'
                  +'<input type="hidden" name="fieldIdProdukRetKeluar[]" value="'+data.data_isi[key-1].id_produk+'" id="field_id_produk_ret_keluar" class="form-control"></td>'
                  +'<td><input type="text" name="fieldNamaSatuanRetKeluar[]" value="'+data.data_isi[key-1].nama_satuan+'" id="field_nama_satuan_ret_keluar" class="form-control" required readonly>'
                  +'<input type="hidden" name="fieldIdSatuanRetKeluar[]" value="'+data.data_isi[key-1].id_satuan+'" id="field_id_satuan_ret_keluar" class="form-control"></td>'
                  +'<td><input type="text" name="fieldJumlahRetKeluar[]" value="'+data.data_isi[key-1].qty+'" id="field_jumlah_ret_keluar" class="form-control" required></td>'
                  +'<td><input type="text" name="fieldSizeRetKeluar[]" value="'+data.data_isi[key-1].ukuran+'" id="field_size_ret_keluar" class="form-control" required readonly>'
                  +'<input type="hidden" name="fieldIdStokRetKeluar[]" value="'+data.data_isi[key-1].id_stok+'" id="field_id_stok_ret_keluar" class="form-control" required readonly></td>'
                  +'<td><input type="text" name="fieldKetRetKeluar[]" value="'+data.data_isi[key-1].keterangan+'" id="field_ket_ret_keluar" class="form-control" placeholder="Alasan Produk kenapa diretur ? (misal: cacat)"></td>'
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
      url = "<?php echo site_url('retur_keluar_adm/add_retur_keluar')?>";
   } else {
      url = "<?php echo site_url('retur_keluar_adm/update_retur_keluar')?>";
   }

   // ajax adding data to database
   let IsValid = $("form[name='formRetKeluar']").valid();
   if(IsValid) {
      $('#btnSave').text('saving...'); //change button text
      $('#btnSave').attr('disabled',true); //set button disable 
      $.ajax({
         url : url,
         type: "POST",
         data: $('#form_ret_keluar').serialize(),
         dataType: "JSON",
         success: function(data)
         {
            if(data.status) //if success close modal and reload ajax table
            {
               alert(data.pesan);
               $('#modal_ret_keluar').modal('hide');
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

function deleteReturKeluar(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('retur_keluar_adm/delete_retur_keluar')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                $('#modal_ret_keluar').modal('hide');
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
