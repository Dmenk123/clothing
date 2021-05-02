<?php require_once(APPPATH.'views/temp_img_laporan.php'); ?>
<html>
<head>
  <title><?php echo $title; ?></title>
  <style type="text/css">
    #outtable{
      padding: 20px;
      border:1px solid #e3e3e3;
      width:600px;
      border-radius: 5px;
    }
    .short{
      width: 50px;
    }
    .normal{
      width: 150px;
    }

    .tbl-outer{
      color:#070707;
      margin-bottom: 35px;
    }
    
    .outer-left{
      padding: 2px;
      border: 0px solid white;
      border-color: white;
      margin: 0px;
      background: white;
    }

    .head-left{
      padding-top: 5px;
      padding-bottom: 0px;
      border: 0px solid white;
      border-color: white;
      margin: 0px;
      background: white;
    }

    .tbl-footer{
      width: 100%;
      color:#070707;
      border-top: 0px solid white;
      border-color: white;
      padding-top: 30px;
    }

    .head-right{
       padding-bottom: 0px;
       border: 0px solid white;
       border-color: white;
       margin: 0px;
    }

    .tbl-header{
      width: 100%;
      color:#070707;
      border-color: #070707;
      border-top: 2px solid #070707;
    }

    #tbl_content{
      padding-top: 10px;
    } 

    .tbl-footer td{
      border-top: 0px;
      padding: 10px;
    }

    .tbl-footer tr{
      background: white;
    }

    .foot-center{
      padding-left: 70px;
    }

    .inner-head-left{
       padding-top: 20px;
       border: 0px solid white;
       border-color: white;
       margin: 0px;
       background: white;
    }

    .tbl-content-footer{
      width: 100%;
      color:#070707;
      padding-top: 0px;
    }

    table{
      border-collapse: collapse;
      font-family: arial;
      color:black;
      font-size: 12px;
    }

    thead th{
      text-align: left;
      padding: 10px;
      font-style: bold;
    }

    tbody td{
      padding: 10px;
    }

    tbody tr:nth-child(even){
      background: #F6F5FA;
    }

    tbody tr:hover{
      background: #EAE9F5
    }
  </style>
</head>
<body>
  <!-- Main content -->
  <div class="container">
    <?php foreach ($hasil_header as $val ) : ?>
      <table class="tbl-outer">
        <tr>
          <td align="left" class="outer-left">
            <?php echo $img_laporan; ?>
          </td>
          <td align="right" class="outer-left">
            <p style="text-align: left; font-size: 14px" class="outer-left">
              <strong>Dmenk Clothing E-shop</strong>
            </p>
            <p style="text-align: left; font-size: 12px" class="outer-left">Jl. Ngagel tirto II-B no 6, Kota Surabaya - Jawa Timur</p>
          </td>
        </tr>
      </table>
      <h2 style="text-align: center;"><strong>Nota Penjualan Produk</strong></h2>
      <table class="tbl-header">
        <tr>
          <td align="left">
              <p style="text-align: left;" class="head-left">ID Pembelian : <?php echo $val->id_pembelian; ?></p>
              <p style="text-align: left;" class="head-left">ID Checkout : <?php echo $val->id_checkout; ?></p>
          </td>
          <td align="center">
            <?php if ($val->method_checkout != "COD"): ?>
              <p style="text-align: center;" class="head-left">Ekspedisi : <?php echo $val->jasa_ekspedisi." | ".$val->pilihan_paket." | ".$val->estimasi_datang; ?></p>
              <p style="text-align: center;" class="head-left">Biaya Ongkir : Rp. <?php echo number_format($val->ongkos_kirim,0,",","."); ?></p>
            <?php endif ?>
          </td>
          <td align="right">
              <p style="text-align: right; font-size: 14px" class="head-left"><strong>Surabaya, <?php echo $val->tgl_pembelian; ?></strong></p>
          </td>
        </tr>
        <tr> 
          <td align="left" class="head-left" colspan="3">
            <p style="text-align: left; font-size: 12px" class="head-left">Kepada Yth : <strong><?php echo $val->fname_kirim." ".$val->lname_kirim; ?></strong></p>
            <p style="text-align: left; font-size: 12px" class="head-left">Alamat : <?php echo $val->alamat_kirim; ?></p>
          </td>
        </tr>
        <tr class="inner-head-left"> 
          <td align="left" class="inner-head-left" colspan="3">
            <p style="text-align: left; font-size: 12px" class="inner-head-left">Terimakasih telah membeli produk dari kami, berikut adalah produk-produk pembelian dari anda yang akan kami kirimkan :</p>
          </td>
        </tr>    
      </table>
    <?php endforeach ?>

    <table id="tbl_content" class="table table-bordered table-hover" cellspacing="0" width="100%" border="1">
      <thead>
        <tr>
          <th style="width: 10px; text-align: center;">No</th>
          <th style="width: 180px; text-align: center;">Nama Produk</th>
          <th style="width: 30px; text-align: center;">Satuan</th>
          <th style="width: 30px; text-align: center;">Ukuran</th>
          <th style="width: 30px; text-align: center;">Qty</th>
          <th style="width: 50px; text-align: center;">Harga Satuan</th>
          <th style="width: 50px; text-align: center;">Harga Total</th>
        </tr>
      </thead>
      <tbody>
      <?php $no = 1; ?>
      <?php $harga_total_all = 0; ?>
      <?php foreach ($hasil_data as $val ) : ?>
        <tr>
          <td><?php echo $no++; ?></td>  
          <td><?php echo $val->nama_produk; ?></td>
          <td><?php echo $val->nama_satuan; ?></td>
          <td><?php echo $val->ukuran_produk; ?></td>
          <td><?php echo $val->qty; ?></td>
          <td>Rp. <?php echo number_format($val->harga,0,",","."); ?></td>
          <td>Rp. <?php echo number_format($val->harga * $val->qty,0,",","."); ?></td>
        </tr>
      <?php endforeach ?>
      <tr>
        <?php foreach ($hasil_header as $val ) : ?>
          <td colspan="5" align="center"><strong>Harga Keseluruhan</strong></td>
          <td colspan="2" align="center">
            <strong>Rp. <?php echo number_format($val->ongkos_total,0,",","."); ?></strong>
          </td>
        <?php endforeach ?> 
      </tr>
      </tbody>
    </table>
    <table class="tbl-footer">
        <tr>
          <td>
            <p><strong>Dibuat Oleh</strong> </p>
          </td>
          <td>
            <p style="text-align: center;"><strong>Owner</strong></p>
          </td>
          <td>
            <p style="text-align: center;"><strong>Petugas Kirim</strong></p>
          </td>
          <td>
            <p style="text-align: right;"><strong>Customer</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
          </td>
        </tr>
        <tr>
          <td> 
            <p>
              ( <?php echo $this->session->userdata('fname_user')." ".$this->session->userdata('lname_user');?> )
            </p>      
          </td>
          <td>
            <p style="text-align: center;">( AULIA SHABRINA ) </p>
          </td>
          <td>
            <p style="text-align: center;">( PURNOMO, SH ) </p>
          </td>
          <?php foreach ($hasil_header as $val ) : ?>
          <td>
            <p style="text-align: right;">( <?php echo $val->fname_kirim." ".$val->lname_kirim;?> ) </p>
          </td>
          <?php endforeach ?>
        </tr>
      </table>
  </div>          
</body>
</html>