<script type="text/javascript">

	$(document).ready(function() {
		//set active class to navbar
		$('#li_nav_home').removeClass('active');
		$('#li_nav_kontak').removeClass('active');
		$('#li_nav_faq').addClass('active');
		$('#li_nav_login').removeClass('active');
		$('#li_nav_produk').removeClass('active');
        $('#li_nav_register').removeClass('active');
		
        //force integer input in textfield
        $('input.numberinput').bind('keypress', function (e) {
            return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
        });

        //jquery validation
        $("form[name='formPesan']").validate({
            // Specify validation rules
            errorElement: 'div',
            rules:{
                // The key name on the left side is the name attribute
                // of an input field. Validation rules are defined
                // on the right side
                msg_fname: "required",
                msg_email: {
                    required: true,
                    // Specify that email should be validated
                    // by the built-in "email" rule
                    email: true,

                },
                msg_subject: "required",
                msg_message: "required"
            },
            // Specify validation error messages
            messages: {
                msg_fname: "Nama depan is required",
                msg_email: "Valid email is required",
                msg_subject: "Subject pesan is required",
                msg_message: "Isi pesan is required"
            },
            submitHandler: function(form) {
              form.submit();
            }
        });

        //validasi format email
        $('#email').focusout(function(){
            $('#email').filter(function(){
                var emil=$('#email').val();
                var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                if( !emailReg.test( emil ) ) {
                    alert('Format email anda tidak valid');
                    $('#email').val("");
                } /*else {
                    alert('Thank you for your valid email');
                }*/
            })
        });
	

	}); // end jquery  

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

    function kirim_pesan_proc() {
        var IsValid = $("form[name='formPesan']").valid();
        if(IsValid){
            $.ajax({
            url: "<?php echo site_url('kontak/add_pesan'); ?>",
            type: 'POST',
            dataType: "JSON",
            data: $('#form_kontak').serialize(),
                success :function(data){
                    if (data.status) {
                        alert(data.pesan);
                        window.location.href = "<?php echo site_url('home'); ?>";
                    }
                }, 
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Terdapat kesalahan / error');
                }
            });
        }    
    }

		
</script>