<!-- ambil uri segment 3 -->
<?php $val_url = $this->uri->segment(3); ?>
<script type="text/javascript">
	var save_method; //for save method string
	var table;
    var table2;
    var idKategori = "<?php echo $val_url; ?>";
$(document).ready(function() {

    //force integer input in textfield
    $('input.numberinput').bind('keypress', function (e) {
        return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

	//datatables
	table = $('#tabelTag').DataTable({
		
		"processing": true, //feature control the processing indicator
		"serverSide": true, //feature control DataTables server-side processing mode
		"order":[], //initial no order

		//load data for table content from ajax source
		"ajax": {
			"url": "<?php echo site_url('master_tag_adm/list_tag') ?>",
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

    $("[name='formTag']").validate({
        // Specify validation rules
        errorElement: 'span',
        /*errorLabelContainer: '.errMsg',*/
        errorPlacement: function(error, element) {
            if (element.attr("name") == "namaTag") {
                error.insertAfter(".lblNamaErr");
            } else if (element.attr("name") == "warnaTag") {
                error.insertAfter(".lblWarnaErr");
            } else {
                error.insertAfter(element);
            }
        },
		rules:{
			namaTag: "required",
			warnaTag: "required",
			// akronimKategori: {
			// 	required: true,
			// 	minlength: 2
			// }
		},
		// Specify validation error messages
		messages: {
			namaKategori: " (Harus diisi !!)",
			keteranganKategori: " (Harus diisi !!)",
			// akronimKategori: {
			// 	required: " (Harus diisi !!)",
			// 	minlength: " (Akronim anda setidaknya minimal 2 karakter !!)"
			// }
		},
		submitHandler: function(form) {
			form.submit();
		}
    });

	$("#picker1").colorPick({
		'initialColor' : '#8e44ad',
		'palette': ["#1abc9c", "#16a085", "#2ecc71", "#27ae60", "#3498db", "#2980b9", "#9b59b6", "#8e44ad", "#34495e", "#2c3e50", "#f1c40f", "#f39c12", "#e67e22", "#d35400", "#e74c3c", "#c0392b", "#ecf0f1"],
		'onColorSelected': function() {
			// console.log("The user has selected the color: " + this.color)
			$("[name='warnaTag']").val(this.color);
			this.element.css({'backgroundColor': this.color, 'color': this.color});
		}
	});

    // select class modal whenever bs.modal hidden
    $(".modal").on("hidden.bs.modal", function(){
        $('#form_tag')[0].reset(); // reset form on modals
        $("[name='formTag']").validate().resetForm();
    });

});	

function add_tag()
{
    save_method = 'add';
	$('#modal_tag_form').modal('show'); //show bootstrap modal
	$('.modal-title').text('Add Kategori'); //set title modal
}

function saveTag()
{
    var url = "<?php echo site_url('master_tag_adm/add_master_tag')?>";
	// ajax adding data to database
    var IsValid = $("form[name='formTag']").valid();
	
    if(IsValid)
    {
        $("#btnSave").prop("disabled", true);
        $('#btnSave').text('saving...'); //change button text
        $.ajax({
            url : url,
            type: "POST",
            data: $('#form_tag').serialize(),
            dataType: "JSON",
            success: function (data) {
                if (data.status) {
                    alert(data.pesan);
                    $("#btnSave").prop("disabled", false);
                    $("#btnSave").text('Save'); //change button text
                    $('#modal_tag_form').modal('hide');
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

function delete_tag(id)
{
    if(confirm('Anda yakin hapus data ini ?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('master_tag_adm/delete_master_tag')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                if (data.status) {
                    $('#modal_tag_form').modal('hide');
                    alert(data.pesan);
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

function reload_table2()
{
    table2.ajax.reload(null,false); //reload datatable ajax 
}

</script>	
