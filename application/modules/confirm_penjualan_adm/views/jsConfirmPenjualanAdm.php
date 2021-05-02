<script type="text/javascript">
	let save_method; //for save method string
	let table;
   let baseUrl = '<?php echo base_url(); ?>';

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
   $("#modal_confirm_jual").on("hidden.bs.modal", function(){
      $('#form_confirm_jual')[0].reset();
      //clear tr append in modal
      $('tr').remove('.tbl_modal_row');
      $('option').remove('.appendOpt');
   });

   //datatables  
   // tabel trans masuk
	table = $('#tableConfirmJual').DataTable({
		
		"processing": true, 
		"serverSide": true, 
		//"order":[[ 2, 'desc' ]],
      "order":[], //initial no order 
		//load data for table content from ajax source
		"ajax": {
			"url": "<?php echo site_url('confirm_penjualan_adm/list_penjualan') ?>",
			"type": "POST" 
		},

		"columnDefs": [
			{
				"targets": [-1], //last column
				"orderable": false, //set not orderable
			},
		],
	});

   //modal gambar transfer detail
   $('.modalGbrTransfer').click(function() {
      let nmGbr = $(this).data("id");
      $('#imgGbrDetail').attr('src', baseUrl+'assets/img/bukti_transfer/'+nmGbr);
      $('.txtJudul').text('Gambar Bukti Transfer');
      $('#modal_gambar_detail').modal('show');
   });

   //modal gambar konfirmasi detail
   $('.modalGbrKonfirmasi').click(function() {
      let nmGbr = $(this).data("id");
      $('#imgGbrDetail').attr('src', baseUrl+'assets/img/bukti_konfirmasi/'+nmGbr);
      $('.txtJudul').text('Gambar Bukti Konfirmasi Pembelian');
      $('#modal_gambar_detail').modal('show');
   });
  
   //jquery validate
   //validasi form master produk
   $("[name='formConfirmJual']").validate({
      // Specify validation rules
      errorElement: 'span',
      /*errorLabelContainer: '.errMsg',*/
      errorPlacement: function(error, element) {
         if (element.attr("name") == "buktiConfirm") {
            error.insertAfter(".lblGambarErr");
         }else {
            error.insertAfter(element);
         }
      },
      rules:{
         buktiConfirm: "required"
      },
      // Specify validation error messages
      messages: {
         buktiConfirm: " (Harus diisi !!)"
      },
      submitHandler: function(form) {
         form.submit();
      }
   });

   //change status pembelian (aktif/batal)
   $(document).on('click', '.btn_edit_status', function(){
      if(confirm('Apakah anda yakin ubah status Penjualan ini ?'))
      {
         var id = $(this).attr('id');
         var status = $(this).text();
         // ajax delete data to database
         $.ajax({
            url : "<?php echo site_url('confirm_penjualan_adm/edit_status_penjualan')?>/"+id,
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

function editConfirmPenjualan(id)
{
   save_method = 'update';
   $('#form_confirm_jual')[0].reset(); // reset form on modals
   $('#modal_confirm_jual').modal('show'); // show bootstrap modal when complete loaded
   $('.modal-title').text('Konfirmasi Penjualan');
   $.ajax({
      url : "<?php echo site_url('confirm_penjualan_adm/get_konfirmasi_penjualan/')?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
         $('[name="fieldIdBeli"]').val(data.data_header[0].id_pembelian);
         $('[name="fieldEmailCustomer"]').val(data.data_header[0].email);
         $('.txtBuktiConfirm').text(data.data_header[0].bconfirm_adm);
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

function saveKonfirmasi()
{
   let IsValid = $("form[name='formConfirmJual']").valid();
   if(IsValid)
   {
      if($("#cfrm_check").prop('checked') == true)
      {
         // Get form
         let form = $('#form_confirm_jual')[0];
         let data = new FormData(form);
         let idBeli = $('#field_id_beli').val();
         // ajax adding data to database
         $('#btnSave').text('saving...'); //change button text
         $('#btnSave').attr('disabled',true); //set button disable 
         $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "<?php echo site_url('confirm_penjualan_adm/konfirmasi_penjualan/'); ?>"+idBeli,
            data: data,
            dataType: "JSON",
            processData: false, // false, it prevent jQuery form transforming the data into a query string
            contentType: false, 
            cache: false,
            timeout: 600000,
            success: function (data) {
               if (data.status) {
                  alert(data.pesan);
                  $("#btnSave").attr("disabled", false);
                  window.location.href = "<?php echo site_url('confirm_penjualan_adm'); ?>";
               }
            },
            error: function (e) {
               console.log("ERROR : ", e);
               $("#btnSave").prop("disabled", false);
            }
         });
      }
      else
      {
         alert("Mohon centang \"Saya memastikan data telah valid\"");
      }
   }
}

</script>	
