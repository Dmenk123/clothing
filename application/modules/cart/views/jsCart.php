<script type="text/javascript">

	$(document).ready(function() {

		//force integer input in textfield
		$('input.numberinput').bind('keypress', function (e) {
			return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
		});

		//set active class to navbar
		var uriValue = "produk";
		$('#li_nav_home').removeClass('active');
		$('#li_nav_kontak').addClass('active');
		
		// Load shopping cart
        $('#detail_cart').load("<?php echo site_url('cart/load_cart'); ?>");


        var nilaiDetail = $('#countItems').text();
        if (nilaiDetail == "0") {
            $('.btnNextStep1').prop('disabled',true); //set button disable 
        }else{
            $('.btnNextStep1').prop('disabled',false); //set button enable 
        }

        //Hapus Item Cart
        //berhubung element hapus_cart ada banyak menggunakan ($document) ketimbang ('selector')
        $(document).on('click','.hapus_cart',function(){
            if(confirm('Yakin hapus item terpilih ?')){
                var row_id=$(this).attr("id"); //mengambil row_id dari artibut id
                $.ajax({
                    url : "<?php echo site_url('cart/hapus_cart') ?>",
                    method : "POST",
                    data : {row_id : row_id},
                    success :function(data){
                        $('#detail_cart').html(data);
                        location.reload();
                    }
                });
            }
        });

        //load total cost summary
        $('#detail_summary').load("<?php echo site_url('cart/load_summary'); ?>");
			
	});

	const gantiQtyCart = (cb) => {
		var row_id = cb.attr("data-id"); //mengambil row_id dari artibut id
		// var qty = cb.val(); //mengambil value
		var qty = $('input#'+row_id).val(); //mengambil value
		$.ajax({
			url : "<?php echo site_url('cart/update_cart') ?>",
			method : "POST",
			data : {row_id : row_id, qty : qty},
			success :function(data){
				$('#detail_cart').html(data);
				location.reload();
			}
		});
	}

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
		
</script>
