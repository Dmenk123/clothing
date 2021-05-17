<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="generator" content="">
	<title>Notifikasi</title>

	<!-- Bootstrap core CSS -->
	<link href="<?php echo base_url(); ?>assets/thanks_assets/bootstrap.min.css" rel="stylesheet" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

	<!-- Favicons -->
	<!-- <link rel="apple-touch-icon" href="/docs/4.5/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
		<link rel="icon" href="/docs/4.5/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
		<link rel="icon" href="/docs/4.5/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
		<link rel="manifest" href="/docs/4.5/assets/img/favicons/manifest.json">
		<link rel="mask-icon" href="/docs/4.5/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
		<link rel="icon" href="/docs/4.5/assets/img/favicons/favicon.ico">
		<meta name="msapplication-config" content="/docs/4.5/assets/img/favicons/browserconfig.xml">
		<meta name="theme-color" content="#563d7c"> -->
	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}

		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}

		/*.bgimg-1, .bgimg-2, .bgimg-3 {
        position: relative;
        opacity: 0.65;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;

      }*/

		.tops {
			position: absolute;
			top: 0px;
			right: 0px;
			z-index: 1;

		}

		.bottoms {
			position: absolute;
			bottom: 0px;
			right: 0px;
			z-index: 1;

		}

		.rounded {
			z-index: 19;
		}

		@media (min-width: 1200px) {

			.container,
			.container-lg,
			.container-md,
			.container-sm,
			.container-xl {
				max-width: 840px;
			}
		}

		@media (max-width: 500px) {
			.ndelik {
				display: none;
			}
		}

		@media (max-width: 767px) {
			.ndelik {
				display: none;
			}
		}

		.rounded {
			position: relative;
			border-radius: .65rem !important;
		}
	</style>
	<!-- Custom styles for this template -->
	<link href="offcanvas.css" rel="stylesheet">
</head>

<body class="bg-light">


	<main role="main" class="container">

		<div class="my-3 p-3 mt-4 bg-white rounded shadow-sm">

			<div class="row">
				<div class="col-md-12">
					<div class="media text-muted pt-3">
						<h2 class="text-primary">Terima kasih telah melakukan pembayaran secara Transfer.</h2>
					</div>
					<div class="media text-muted">
						<p>
						<h5 class="text-secondary">Setelah di konfirmasi, Kami akan mengirimi anda email yang berisi kode Resi Pengiriman, sehingga dapat dicek posisi barang anda.</h5>
						</p>
					</div>
				</div>
			</div>

		</div>

		<div class="my-3 p-3 mt-4 bg-white rounded shadow-sm">
			<h6 class="border-bottom border-gray pb-2 mb-0">
				<svg class="bi" width="21" height="21" fill="#007bff">
					<use xlink:href="<?php echo base_url(); ?>assets/thanks_assets/icons/bootstrap-icons.svg#info-square" />
				</svg>
				<i>Order Anda</i>
			</h6>

			<div class="media text-muted pt-3">
				<svg class="bi" width="32" height="32" fill="#007bff">
					<use xlink:href="<?php echo base_url(); ?>assets/thanks_assets/icons/bootstrap-icons.svg#calendar2-check" />
				</svg>

				<p class="media-body pb-3 mb-0 ml-3 small lh-125 border-bottom border-gray">
					<strong class="d-block text-primary">Order ID</strong>
					<span class="h6"><strong><?= $data->order_id; ?></strong></span>
				</p>
			</div>

			<div class="media text-muted pt-3">
				<svg class="bi" width="32" height="32" fill="#007bff">
					<use xlink:href="<?php echo base_url(); ?>assets/thanks_assets/icons/bootstrap-icons.svg#person" />
				</svg>
				<p class="media-body pb-3 mb-0 ml-3 small lh-125 border-bottom border-gray">
					<strong class="d-block text-primary">Nama</strong>
					<span class="h6"><?= $data->nama; ?></span>
				</p>
			</div>

			<div class="media text-muted pt-3">
				<svg class="bi" width="32" height="32" fill="#ffffff">
					<use xlink:href="<?php echo base_url(); ?>assets/thanks_assets/icons/bootstrap-icons.svg#mailbox" />
				</svg>
				<p class="media-body pb-3 mb-0 ml-3 small lh-125 border-bottom border-gray">
					<strong class="d-block text-primary">Email</strong>
					<span class="h6"><?= $data->email ?></span>
				</p>
			</div>

			<span class="btn btn-block btn-secondary disabled">Apabila ada masalah terkait pengiriman, silahkan email ke admin@crazypropertytycoon.com dan jangan lupa sertakan Order Id anda. terimakasih. </span>


			<div class="media text-muted pt-3">
				<form action="<?= base_url('checkout/finish_transfer'); ?>" method="post">
					<input type="hidden" value="<?= $data->order_id; ?>" class="form-control" name="orderid">
					<p class="media-body pb-3 mb-0 ml-3 small lh-125 border-bottom border-gray" style="text-align: center;">
						<strong class="d-block text-primary" style="color:salmon;">Terimakasih. Klik Tombol dibawah Untuk Selesai</strong>
					</p>
					<p style="text-align: center;">
						<input type="submit" class='btn btn-primary btn-md' value="Selesai">
					</p>
				</form>
			</div>


		</div>

	</main>

	<div class="tops">
		<img src="<?php echo base_url(); ?>assets/thanks_assets/header-illustration-light.svg" />
	</div>

	<div class="bottoms">
		<img src="<?php echo base_url(); ?>assets/thanks_assets/hero-media-illustration-light.svg" />
	</div>
</body>

</html>
