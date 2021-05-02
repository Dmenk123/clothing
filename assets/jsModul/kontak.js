let baseUrl = "";
$(document).ready(function() {
	//set active class to navbar
	$('#li_nav_home').removeClass('active');
	$('#li_nav_kontak').addClass('active');
	$('#li_nav_faq').removeClass('active');
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
            msg_fname: "required",
            msg_email: {
                required: true,
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
            let emil=$('#email').val();
            let emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if( !emailReg.test( emil ) ) {
                alert('Format email anda tidak valid');
                $('#email').val("");
            } 
            /*else {
                alert('Format email anda valid');
            }*/
        })
    });
}); // end jquery  

//set uri string
function setParam(name, value) {
    let l = window.location;
    /* build params */
    let params = {};        
    let x = /(?:\??)([^=&?]+)=?([^&?]*)/g;        
    let s = l.search;
    for(let r = x.exec(s); r; r = x.exec(s))
    {
        r[1] = decodeURIComponent(r[1]);
        if (!r[2]) r[2] = '%%';
        params[r[1]] = r[2];
    }

    /* set param */
    params[name] = encodeURIComponent(value);

    /* build search */
    let search = [];
    for(let i in params)
    {
        let p = encodeURIComponent(i);
        let v = params[i];
        if (v != '%%') p += '=' + v;
        search.push(p);
    }
    
    search = search.join('&');
    /* execute search */
    l.search = search;
}

function kirim_pesan_proc() {
    let IsValid = $("form[name='formPesan']").valid();
    if(IsValid){
        $.ajax({
        url: baseUrl+"kontak/add_pesan",
        type: 'POST',
            dataType: "JSON",
            data: $('#form_kontak').serialize(),
            success :function(data){
                if (data.status) {
                    alert(data.pesan);
                    window.location.href = baseUrl+"home";
                }
            }, 
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Terdapat kesalahan / error');
            }
        });
    }    
}		
