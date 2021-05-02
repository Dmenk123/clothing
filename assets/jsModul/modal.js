$(document).ready(function() {
	baseUrl = $('#base_url').text();
});

function login_proc() {
	$.ajax({
		url: baseUrl+"login/login_proc",
		type: 'POST',
		dataType: "JSON",
		// data: {email: email, password: password},
		data: $('#form_login').serialize(),
		success :function(data)
		{
			if (data.level == "2") 
			{
				alert(data.pesan);
				window.location.href = baseUrl+"home";				
			}
			else
			{
				alert(data.pesan);
				window.location.href = baseUrl+"dashboard_adm";
			}
		}, 
		error: function (jqXHR, textStatus, errorThrown)
		{
			alert('password / username anda tidak cocok');
		}
	});
}

function forgotPassProc() {
	$.ajax({
		url: baseUrl+"login/kirim_token_forgotpass",
		type: 'POST',
		dataType: "JSON",
		data: $('#form_forgot_pass').serialize(),
		success :function(data)
		{
			alert(data.pesan);
			window.location.href = baseUrl+'home';
		}, 
		error: function (e)
		{
		   	console.log("ERROR : ", e);
		}
	});
}

function logout_proc() {
	if(confirm('Apakah yakin anda ingin logout ?'))
	{
		$.ajax({
			url: baseUrl+'login/logout_proc',
			type: 'POST',
			dataType: "JSON",
			success :function(data){
				alert(data.pesan);
				window.location.href = baseUrl+'home';
			}
		});
	}
}