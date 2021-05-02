<script type="text/javascript">
$(document).ready(function() {

	//set input/textarea/select event when change value, remove class error and remove text help block
	$("input").change(function() {
		$(this).parent().parent().removeClass('has-error');
		$(this).next().empty();
	});

    //datepicker
    $('#tgl_lap_awal').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });

    //datepicker
    $('#tgl_lap_akhir').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });

    //datatable
    $('#tblLaporanMutasiDetail').DataTable({
        "pageLength": 25
    });

});	

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

</script>	