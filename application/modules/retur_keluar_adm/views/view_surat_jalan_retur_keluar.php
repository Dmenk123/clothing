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
      <h2 style="text-align: center;"><strong>Surat Jalan Pengeluaran Retur</strong></h2>
      <table class="tbl-header">
        <tr>
          <td align="left">
              <p style="text-align: left;" class="head-left">ID Retur : <?php echo $val->id_retur_keluar; ?></p>
              <p style="text-align: left;" class="head-left">ID Penerimaan : <?php echo $val->id_trans_masuk; ?></p>
          </td>
          <td align="right">
              <p style="text-align: right; font-size: 12px" class="head-left"><strong>Surabaya, <?php echo $val->tgl_retur_keluar; ?></strong></p>
          </td>
        </tr>
        <tr> 
          <td align="left" class="head-left" colspan="2">
            <p style="text-align: left; font-size: 12px" class="head-left">Diretur Kepada : <strong><?php echo $val->nama_supplier; ?></strong></p>
            <p style="text-align: left; font-size: 12px" class="head-left">Alamat : <?php echo $val->alamat_supplier; ?></p>
          </td>
        </tr>    
      </table>
    <?php endforeach ?>

    <table id="tbl_content" class="table table-bordered table-hover" cellspacing="0" width="100%" border="1">
      <thead>
        <tr>
          <th style="width: 10px; text-align: center;">No</th>
          <th style="width: 50px; text-align: center;">Id Retur</th>
          <th style="width: 180px; text-align: center;">Nama Produk</th>
          <th style="width: 30px; text-align: center;">Satuan</th>
          <th style="width: 30px; text-align: center;">Ukuran</th>
          <th style="width: 30px; text-align: center;">Qty</th>
          <th style="width: 180px; text-align: center;">Keterangan</th>
        </tr>
      </thead>
      <tbody>
      <?php $no = 1; ?>
      <?php $harga_total_all = 0; ?>
      <?php foreach ($hasil_data as $val ) : ?>
        <tr>
          <td><?php echo $no++; ?></td>  
          <td><?php echo $val->id_retur_keluar; ?></td>
          <td><?php echo $val->nama_produk; ?></td>
          <td><?php echo $val->nama_satuan; ?></td>
          <td><?php echo $val->ukuran; ?></td>
          <td><?php echo $val->qty; ?></td>
          <td><?php echo $val->keterangan; ?></td>
        </tr>
      <?php endforeach ?>
      </tbody>
    </table>
    <table class="tbl-content-footer">
        <tr class="content-footer-left"> 
          <td align="left" class="content-footer-left" colspan="5">
            <p style="text-align: left; font-size: 12px" class="content-footer-left">Dimohon agar surat jalan ini <strong>dibawa kembali</strong> surat jalan ini ketika mengembalikan retur dari kami, Terima kasih.</p>
          </td>
        </tr>  
      </table>
    <table class="tbl-footer">
        <tr>
          <td align="left">
            <p style="text-align: left;" class="foot-left"><strong>Dibuat Oleh</strong> </p>
          </td>
          <td align="center">
            <p style="text-align: center;" class="foot-center"><strong>Owner</strong></p>
          </td>
          <td align="right">
            <p style="text-align: right;" class="foot-right"><strong>Diretur Kepada</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
          </td>
        </tr>
        <tr>
          <td align="left">
            <?php foreach ($hasil_header as $val ) : ?> 
              <p style="text-align: left;" class="foot-left">( <?php echo $val->fname_user." ".$val->lname_user;?> ) </p>
            <?php endforeach ?>      
          </td>
          <td align="center">
            <p style="text-align: center;" class="foot-center">( AULIA SHABRINA ) </p>
          </td>
          <td align="right">
            <p style="text-align: right;" class="foot-right">( <?php echo $val->nama_supplier;?> ) </p>
          </td>
        </tr>
      </table>
  </div>          
</body>
</html>