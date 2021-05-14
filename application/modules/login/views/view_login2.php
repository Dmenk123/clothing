<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="shortcut icon" href="https://lawancovid-19.surabaya.go.id/assets/images/favicon.png">

        <title>Login</title>

        <link href="<?php echo base_url();?>assets/login/css/bootstrap.min.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo base_url();?>assets/login/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/login/css/responsive.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="<?php echo base_url();?>assets/login/modernizr.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <style>
            body {
                background-image: url("assets/images/pattern-2.png");
            }
            .wrapper-page .card-box {
                /* background: #ffffff; */
            }
        </style>
    </head>
    <body>

        <div class="account-pages"></div>
        
        <div class="clearfix"></div>
        <div class="wrapper-page">
        	<div class=" card-box">
                <div class="panel-heading">
                    <h3 class="text-center" style="font-family: monospace;"> Login CMS <br> <strong class="text-custom" style="color: #09B5A4">Crazy Property Tycoon</strong> </h3>
                </div> 

                

                <div class="panel-body">
                <div class="kt-grid kt-grid--hor kt-grid--root kt-login kt-login--v2 kt-login--signin" id="kt_login">
                    <form class="form-horizontal m-t-20 kt-form">
                        
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" name="username" type="text" required="" placeholder="Username">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input class="form-control" name="password" type="password" required="" placeholder="Password">
                            </div>
                        </div>
                        
                        <div class="form-group text-center m-t-40">
                            <div class="col-xs-12">
                                <button class="btn btn-success btn-block text-uppercase waves-effect waves-light" id="kt_login_signin_submit" style="background-color: #09B5A4;border-color: #09B5A4;" type="button">Log In</button>
                            </div>
                        </div>
                    </form> 
                    </div>
                </div>
        </div>

        <script>
			let base_url = '<?=base_url()?>';
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#5d78ff",
						"dark": "#282a3c",
						"light": "#ffffff",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": [
							"#c5cbe3",
							"#a1a8c3",
							"#3d4465",
							"#3e4466"
						],
						"shape": [
							"#f0f3ff",
							"#d9dffa",
							"#afb4d4",
							"#646c9a"
						]
					}
				}
			};

		</script>
        <script src="<?=base_url('assets/')?>login/js/pages/custom/login/login-general.js" type="text/javascript"></script>
        <script src="<?=base_url('assets/')?>login/global/plugins.bundle.js" type="text/javascript"></script>
		<script src="<?=base_url('assets/')?>login/js/scripts.bundle.js" type="text/javascript"></script>
	</body>
</html>
