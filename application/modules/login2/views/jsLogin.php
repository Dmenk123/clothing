<script type="text/javascript">

	$(document).ready(function() {

    	//set active class to navbar
		let  uriValue = "login";
		$('#li_nav_home').removeClass('active');
		$('#li_nav_kontak').removeClass('active');
		$('#li_nav_faq').removeClass('active');
		$('#li_nav_login').addClass('active');
		$('#li_nav_produk').removeClass('active');
        $('#li_nav_register').removeClass('active');
	
        //confirm password
        $('#pass_forgot, #pass_forgot2').on('keyup', function (){
            var password = $('#pass_forgot').val();
            var rePassword = $('#pass_forgot2').val();
            var panjang = 6;
            if (password == rePassword && rePassword.length >= panjang) 
            {
                $('#message').html('Password Anda Cocok').css('color', 'green');
            } 
            else 
            {
                $('#message').html('Maaf, Password Anda Tidak Cocok').css('color', 'red');
            }
        });

        //force integer input in textfield
        $('input.numberinput').bind('keypress', function (e) {
            return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
        });

         //validasi form master produk
        $("[name='formResetPass']").validate({
            // Specify validation rules
            errorElement: 'span',
            /*errorLabelContainer: '.errMsg',*/
            errorPlacement: function(error, element) {
                if (element.attr("name") == "passForgot") {
                    error.insertAfter(".lblPassForgotErr");
                } else if (element.attr("name") == "passForgot2") {
                    error.insertAfter(".lblPassForgotErr2");
                } else {
                    error.insertAfter(element);
                }
            },
            rules:{
                passForgot: {
                    required: true,
                    minlength: 6
                },
                passForgot2: {
                    required: true,
                    minlength: 6
                }
            },
            // Specify validation error messages
            messages: {
                passForgot: {
                    required: " Password is required",
                    minlength: " Password anda setidaknya minimal 6 karakter"
                },
                passForgot2: {
                    required: " Confirm password is required",
                    minlength: " Password anda setidaknya minimal 6 karakter"
                }
            },
            submitHandler: function(form) {
              form.submit();
            }
        });	
	}); // end jquery  

    function resetPassProc() {
        let IsValid = $("form[name='formResetPass']").valid();
        if(IsValid)
        {
            $.ajax({
                url: "<?php echo site_url('login/update_user_data'); ?>",
                type: 'POST',
                dataType: "JSON",
                data: $('#form_reset_pass').serialize(),
                success :function(data)
                {
                    alert(data.pesan);
                    window.location.href = "<?php echo site_url('home'); ?>";
                }, 
                error: function (e)
                {
                    console.log("ERROR : ", e);
                }
            });
        }
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