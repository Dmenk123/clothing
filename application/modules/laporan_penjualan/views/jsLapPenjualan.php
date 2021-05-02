<script type="text/javascript">
	var save_method; //for save method string
$(document).ready(function() {

	//set input/textarea/select event when change value, remove class error and remove text help block
	$("input").change(function() {
		$(this).parent().parent().removeClass('has-error');
		$(this).next().empty();
	});

	//datepicker
    $('#tgl_laporan_awal').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });

    //datepicker
    $('#tgl_laporan_akhir').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });

    //datatable
    // $('#laporanStokProduk').DataTable({
    //     "pageLength": 25
    // });
});	

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

</script>	