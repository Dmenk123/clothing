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
    $('#laporanStokProduk').DataTable({
        "pageLength": 25
    });

    //select2 with no content
    $( "#field_index_tampil" ).select2({ 
    });

    $( "#field_tampil_data" ).select2({ 
    });

    $('#field_index_tampil').change(function(){
        $('#field_tampil_data').empty();
        let jenis  = this.value;
        $("#field_tampil_data").select2({
            ajax: {
                url: '<?php echo site_url('laporan_history_order/suggest_tampil_data'); ?>/'+ jenis,
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
});	

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

</script>	