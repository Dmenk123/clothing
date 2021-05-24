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
      margin-bottom: 10px;
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
      margin-left: -10px;
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
      text-align: center;
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
  <div class="container">     
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
    <table class="tbl-header">
      <tr>
        <td align="center">
          <h2 style="text-align: center;"><strong>Laporan Mutasi Produk - Dmenk Clothing E-shop</strong></h2>
          <h4 style="text-align: center;">Periode Tanggal : <?php echo date("d-m-Y", strtotime($tanggal_awal))." s/d ".date("d-m-Y", strtotime($tanggal_akhir)); ?></h4>
        </td>
      </tr>           
    </table>
    <table id="tbl_content" class="table table-bordered table-hover" cellspacing="0" width="100%" border="2">
      <thead>
        <tr>
          <th style="width: 10px; text-align: left;">No</th>
          <th style="width: 40px; text-align: center;">ID</th>
          <th style="width: 200px; text-align: left;">Nama Barang</th>
          <th style="width: 40px; text-align: center;">Ukuran</th>
          <th style="width: 40px; text-align: center;">Satuan</th>
          <th style="width: 20px; text-align: center;">Stok Awal</th>
          <th style="width: 20px; text-align: center;">IN</th>
          <th style="width: 20px; text-align: center;">OUT</th>
          <th style="width: 20px; text-align: center;">Stok Akhir</th>
        </tr>
      </thead>
      <tbody>
      <?php $no = 1; ?>
      <?php foreach ($hasil_data as $val ) : ?>
        <tr>
          <td><?php echo $no++; ?></td> 
          <td><?php echo $val->id_produk; ?></td>
          <td><?php echo $val->nama_produk; ?></td>
          <td><?php echo $val->ukuran_produk; ?></td>
          <td><?php echo $val->nama_satuan; ?></td>
          <td><?php echo $val->stok_awal; ?></td>
          <td><?php echo $val->masuk; ?></td>
          <td><?php echo $val->keluar; ?></td>
          <td><?php echo $val->sisa_stok; ?></td>
        </tr>
      <?php endforeach ?>
      </tbody>
    </table>
    <table class="tbl-footer">
        <tr>
          <td align="left">
            <strong>Surabaya,  <?php echo date('d-m-Y'); ?></strong>
            <p style="text-align: left;" class="foot-left">
              <strong>Dibuat Oleh</strong> 
            </p>
          </td>
          <td align="right">
            <p style="text-align: right;" class="foot-right"><strong>Owner</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
          </td>
        </tr>
        <tr>
          <td align="left">
            <p style="text-align: left;" class="foot-left">( <?php echo $this->session->userdata('fname_user')." ".$this->session->userdata('lname_user');?> ) </p>     
          </td>
          <td align="right">
            <p style="text-align: right;" class="foot-right">( AULIA SHABRINA ) </p>
          </td>
        </tr>
    </table>
  </div>          
</body>
</html>