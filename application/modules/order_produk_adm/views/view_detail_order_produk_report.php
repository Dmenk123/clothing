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
    }

    .tbl-footer{
      width: 100%;
      color:#070707;
      border-top: 0px solid white;
      border-color: white;
      padding-top: 75px;
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
      padding-top: 40px;
    } 

    .tbl-footer td{
      border-top: 0px;
      padding: 10px;
    }

    .tbl-footer tr{
      background: white;
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
      <h2 style="text-align: center;"><strong>Form Order Produk</strong></h2>
      <table class="tbl-header">
        <tr>
          <td align="left">
            <p style="text-align: left;" class="head-left">ID Order : <?php echo $val->id_trans_order; ?></p>
             <p style="text-align: left;" class="head-left">Supplier : <?php echo $val->nama_supplier; ?></p>
          </td>
          <td align="right">
            <p style="text-align: right;" class="head-right">Tanggal Pesan: <?php echo $val->tgl_trans_order; ?></p>
          </td>
        </tr>
      </table>
    <?php endforeach ?>

    <table id="tbl_content" class="table table-bordered table-hover" cellspacing="0" width="100%" border="1">
      <thead>
        <tr>
          <th style="width: 10px; text-align: left;">No</th>
          <th style="width: 300px; text-align: left;">Nama Produk</th>
          <th style="width: 50px; text-align: left;">Satuan</th>
          <th style="width: 50px; text-align: left;">Ukuran</th>
          <th style="width: 50px; text-align: left;">Qty</th>
          <th style="width: 50px; text-align: left;">Harga Satuan</th>
          <th style="width: 50px; text-align: left;">Harga Total</th>
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
           <td><?php echo $val->ukuran; ?></td>
          <td><?php echo $val->qty; ?></td>
          <td><?php echo $val->harga_satuan_beli; ?></td>
          <td><?php echo $val->harga_total_beli; ?></td>
        </tr>
          <?php $harga_total_all += $val->harga_total_beli; ?>
      <?php endforeach ?>
        <tr>
          <td colspan="5" align="center"><strong style="text-decoration: underline;">Harga Total Pembelian</strong></td>
          <td colspan="2" align="center"><strong style="text-decoration: underline;">Rp. <?php echo number_format($harga_total_all,0,",","."); ?></strong></td>
        </tr>
      </tbody>
    </table>
    <table class="tbl-footer">
        <tr>
          <td align="left">
            <p style="text-align: left;" class="foot-left"><strong>Dibuat Oleh</strong> </p>
          </td>
          <td align="right">
            <p style="text-align: right;" class="foot-right"><strong>Owner</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
          </td>
        </tr>
        <tr>
          <td align="left">
            <?php foreach ($hasil_header as $val ) : ?> 
              <p style="text-align: left;" class="foot-left">( <?php echo $val->fname_user." ".$val->lname_user;?> ) </p>
            <?php endforeach ?>      
          </td>
          <td align="right">
            <p style="text-align: right;" class="foot-right">( AULIA SHABRINA ) </p>
          </td>
        </tr>
      </table>
  </div>          
</body>
</html>