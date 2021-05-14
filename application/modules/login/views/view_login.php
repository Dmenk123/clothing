<!DOCTYPE html>

<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="../../../">
		<meta charset="utf-8" />
		<title>Halaman Login</title>
		<meta name="description" content="Login page example">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!--begin::Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

		<!--end::Fonts -->

		<!--begin::Page Custom Styles(used by this page) -->
		<link href="<?= base_url('assets/template/')?>assets/css/pages/login/login-2.css" rel="stylesheet" type="text/css" />

		<!--end::Page Custom Styles -->

		<!--begin::Global Theme Styles(used by all pages) -->
		<link href="<?= base_url('assets/template/')?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/template/')?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

		<!--end::Global Theme Styles -->

		<!--begin::Layout Skins(used by all pages) -->
		<link href="<?= base_url('assets/template/')?>assets/css/skins/header/base/light.css" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/template/')?>assets/css/skins/header/menu/light.css" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/template/')?>assets/css/skins/brand/dark.css" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/template/')?>assets/css/skins/aside/dark.css" rel="stylesheet" type="text/css" />

		<!--end::Layout Skins -->
		<link rel="shortcut icon" href="<?= base_url('assets/template/')?>assets/media/logos/wijaya.png" />
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

		<!-- begin:: Page -->
		<div class="kt-grid kt-grid--ver kt-grid--root">
			<div class="kt-grid kt-grid--hor kt-grid--root kt-login kt-login--v2 kt-login--signin" id="kt_login">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url(<?=base_url('assets/template/')?>assets/media/bg/bg-1.jpg);">
					<div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
						<div class="kt-login__container">
							<div class="kt-login__signin">
								<div class="kt-login__head">
									<h3 class="kt-login__title">Label Nama Usaha Anda</h3>
								</div>
								<form class="kt-form">
									<div class="input-group">
										<input class="form-control" type="text" placeholder="Username" name="username" autocomplete="off">
									</div>
									<div class="input-group">
										<input class="form-control" type="password" placeholder="Password" name="password">
									</div>
									<div class="kt-login__actions">
										<button id="kt_login_signin_submit" class="btn btn-pill kt-login__btn-primary">Login</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<!-- begin::Global Config(global config for global JS sciprts) -->
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

		<!-- end::Global Config -->

		<!--begin::Global Theme Bundle(used by all pages) -->
		<script src="<?=base_url('assets/template/')?>assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
		<script src="<?=base_url('assets/template/')?>assets/js/scripts.bundle.js" type="text/javascript"></script>

		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts(used by this page) -->
		<script src="<?=base_url('assets/template/')?>assets/js/pages/custom/login/login-general.js" type="text/javascript"></script>

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>