<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> 
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
      <?php $level = $this->session->userdata('id_level_user');?>
      <?php switch ($level) : 
      case '1': ?>
        <ul class="sidebar-menu">
          <!-- dashboard -->
          <li class="<?php if ($this->uri->segment('1') == 'dashboard_adm') {echo 'active';} ?>">
            <a href="<?php echo site_url('dashboard_adm');?>">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>
          <!-- end dashboard -->

          <!-- master treeview -->
          <!-- tentukan attribute active class -->
          <li class="
            <?php if ($this->uri->segment('1') == 'master_produk_adm') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'master_user_adm') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'master_kategori_adm') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'master_supplier_adm') {
                echo 'active treeview';
              } ?>">

            <a href="#">
              <i class="fa fa-database"></i>
              <span>Data Master</span>
               <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>

            <!-- tentukan attribute active class -->
            <ul class="treeview-menu">
              <li class="<?php if ($this->uri->segment('1') == 'master_user_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('master_user_adm');?>"><i class="fa fa-user-plus"></i> Master User</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'master_produk_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('master_produk_adm');?>"><i class="fa fa-tasks"></i> Master Produk</a>
              </li> 
              <li class="<?php if ($this->uri->segment('1') == 'master_kategori_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('master_kategori_adm');?>"><i class="fa fa-tags"></i> Master Kategori</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'master_supplier_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('master_supplier_adm');?>"><i class="fa fa-address-book"></i> Master Supplier</a>
              </li>
            </ul>
          </li>
          <!-- end master treeview -->

          <!-- transaksi treeview -->
          <!-- tentukan attribute active class -->
          <li class="
             <?php if ($this->uri->segment('1') == 'order_produk_adm') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'terima_produk_adm') {
                echo 'active treeview';  
              }elseif ($this->uri->segment('1') == 'confirm_penjualan_adm') {
                echo 'active treeview';  
              }elseif ($this->uri->segment('1') == 'retur_masuk_adm') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'retur_keluar_adm') {
                echo 'active treeview';
              } ?>">
            <a href="#">
              <i class="fa fa-exchange"></i>
              <span>Data Transaksi</span>
               <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <!-- tentukan attribute active class -->
            <ul class="treeview-menu">
              <li class="<?php if ($this->uri->segment('1') == 'order_produk_adm') {echo 'active';} ;?>">
                <a href="<?php echo site_url('order_produk_adm');?>"><i class="fa fa-shopping-cart"></i> Order Produk</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'terima_produk_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('terima_produk_adm');?>"><i class="fa fa-plus-square"></i> Penerimaan Produk</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'confirm_penjualan_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('confirm_penjualan_adm');?>"><i class="fa fa-check"></i> Konfirmasi Penjualan</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'retur_masuk_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('retur_masuk_adm');?>"><i class="fa fa-long-arrow-left"></i> Retur Produk Masuk</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'retur_keluar_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('retur_keluar_adm');?>"><i class="fa fa-long-arrow-right"></i> Retur Produk Keluar</a>
              </li>
            </ul>
          </li>
          <!-- end transaksi treeview -->

          <!-- laporan treeview -->
          <!-- tentukan attribute active class -->
          <li class="
             <?php if ($this->uri->segment('1') == 'laporan_stok') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'Laporan_permintaan') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'laporan_history_order') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'laporan_penerimaan') {
                echo 'active treeview';  
              }elseif ($this->uri->segment('1') == 'laporan_penjualan') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'laporan_retur_masuk') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'laporan_retur_keluar') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'laporan_mutasi') {
                echo 'active treeview';
              } ?>">
            <a href="#">
              <i class="fa fa-bar-chart-o"></i>
              <span>Laporan</span>
               <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <!-- tentukan attribute active class -->
            <ul class="treeview-menu">
              <li class="<?php if ($this->uri->segment('1') == 'laporan_stok') {echo 'active';} ;?>">
                <a href="<?php echo site_url('laporan_stok');?>"> Laporan Stok Produk</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'Laporan_permintaan') {echo 'active';} ?>">
                <a href="<?php echo site_url('Laporan_permintaan');?>"> Laporan Permintaan</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'laporan_history_order') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_history_order');?>"> Laporan Riwayat Permintaan</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'laporan_penerimaan') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_penerimaan');?>"> Laporan Penerimaan</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'laporan_penjualan') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_penjualan');?>"> Laporan Penjualan</a>
              </li>
               <li class="<?php if ($this->uri->segment('1') == 'laporan_retur_masuk') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_retur_masuk');?>"> Laporan Penerimaan Retur</a>
              </li>
               <li class="<?php if ($this->uri->segment('1') == 'laporan_retur_keluar') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_retur_keluar');?>"> Laporan Retur Penjualan</a>
              </li>
               <li class="<?php if ($this->uri->segment('1') == 'laporan_mutasi') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_mutasi');?>"> Laporan Mutasi</a>
              </li>
            </ul>
          </li>
          <!-- end laporan treeview -->

          <!-- pesan treeview -->
          <!-- tentukan attribute active class -->
          <li class="
             <?php if ($this->uri->segment('1') == 'pesan_adm') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'inbox_adm') {
                echo 'active treeview';
              } ?>">

            <a href="#">
              <i class="fa fa-envelope"></i>
              <span>pesan</span>
               <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>

            <!-- tentukan attribute active class -->
            <ul class="treeview-menu">
              <li class="<?php if ($this->uri->segment('1') == 'pesan_adm') {echo 'active';} ;?>">
                <a href="<?php echo site_url('pesan_adm');?>"> Tulis Pesan</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'inbox_adm') {echo 'active';} ;?>">
                <a href="<?php echo site_url('inbox_adm');?>"> Pesan Masuk</a>
              </li>
            </ul>
          </li>
          <!-- end pesan treeview -->
        </ul>
      <?php break; ?>
      <?php case '3': ?>
        <ul class="sidebar-menu">
          <!-- dashboard -->
          <li class="<?php if ($this->uri->segment('1') == 'dashboard_adm') {echo 'active';} ?>">
            <a href="<?php echo site_url('dashboard_adm');?>">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>
          <!-- end dashboard -->

          <!-- master treeview -->
          <!-- tentukan attribute active class -->
          <li class="
            <?php if ($this->uri->segment('1') == 'master_produk_adm') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'master_user_adm') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'master_kategori_adm') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'master_supplier_adm') {
                echo 'active treeview';
              }?>">

            <a href="#">
              <i class="fa fa-database"></i>
              <span>Data Master</span>
               <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>

            <!-- tentukan attribute active class -->
            <ul class="treeview-menu">
              <li class="<?php if ($this->uri->segment('1') == 'master_user_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('master_user_adm');?>"><i class="fa fa-user-plus"></i> Master User</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'master_produk_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('master_produk_adm');?>"><i class="fa fa-tasks"></i> Master Produk</a>
              </li> 
              <li class="<?php if ($this->uri->segment('1') == 'master_kategori_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('master_kategori_adm');?>"><i class="fa fa-tags"></i> Master Kategori</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'master_supplier_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('master_supplier_adm');?>"><i class="fa fa-address-book"></i> Master Supplier</a>
              </li>
            </ul>
          </li>
          <!-- end master treeview -->

          <!-- transaksi treeview -->
          <!-- tentukan attribute active class -->
          <li class="
             <?php if ($this->uri->segment('1') == 'order_produk_adm') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'terima_produk_adm') {
                echo 'active treeview';  
              }elseif ($this->uri->segment('1') == 'confirm_penjualan_adm') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'retur_masuk_adm') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'retur_keluar_adm') {
                echo 'active treeview';
              } ?>">

            <a href="#">
              <i class="fa fa-exchange"></i>
              <span>Data Transaksi</span>
               <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>

            <!-- tentukan attribute active class -->
            <ul class="treeview-menu">
              <li class="<?php if ($this->uri->segment('1') == 'order_produk_adm') {echo 'active';} ;?>">
                <a href="<?php echo site_url('order_produk_adm');?>"><i class="fa fa-shopping-cart"></i> Order Produk</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'terima_produk_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('terima_produk_adm');?>"><i class="fa fa-plus-square"></i> Penerimaan Produk</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'confirm_penjualan_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('confirm_penjualan_adm');?>"><i class="fa fa-check"></i> Konfirmasi Penjualan</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'retur_masuk_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('retur_masuk_adm');?>"><i class="fa fa-long-arrow-left"></i> Retur Produk Masuk</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'retur_keluar_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('retur_keluar_adm');?>"><i class="fa fa-long-arrow-right"></i> Retur Produk Keluar</a>
              </li>
            </ul>
          </li>
          <!-- end transaksi treeview -->

          <!-- laporan treeview -->
          <!-- tentukan attribute active class -->
          <li class="
             <?php if ($this->uri->segment('1') == 'laporan_stok') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'Laporan_permintaan') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'laporan_history_order') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'laporan_penerimaan') {
                echo 'active treeview';  
              }elseif ($this->uri->segment('1') == 'laporan_penjualan') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'laporan_retur_masuk') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'laporan_retur_keluar') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'laporan_mutasi') {
                echo 'active treeview';
              } ?>">

            <a href="#">
              <i class="fa fa-bar-chart-o"></i>
              <span>Laporan</span>
               <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>

            <!-- tentukan attribute active class -->
            <ul class="treeview-menu">
              <li class="<?php if ($this->uri->segment('1') == 'laporan_stok') {echo 'active';} ;?>">
                <a href="<?php echo site_url('laporan_stok');?>"> Laporan Stok Produk</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'Laporan_permintaan') {echo 'active';} ?>">
                <a href="<?php echo site_url('Laporan_permintaan');?>"> Laporan Permintaan</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'laporan_history_order') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_history_order');?>"> Laporan Riwayat Permintaan</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'laporan_penerimaan') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_penerimaan');?>"> Laporan Penerimaan</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'laporan_penjualan') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_penjualan');?>"> Laporan Penjualan</a>
              </li>
               <li class="<?php if ($this->uri->segment('1') == 'laporan_retur_masuk') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_retur_masuk');?>"> Laporan Penerimaan Retur</a>
              </li>
               <li class="<?php if ($this->uri->segment('1') == 'laporan_retur_keluar') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_retur_keluar');?>"> Laporan Retur Penjualan</a>
              </li>
               <li class="<?php if ($this->uri->segment('1') == 'laporan_mutasi') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_mutasi');?>"> Laporan Mutasi</a>
              </li>
            </ul>
          </li>
          <!-- end laporan treeview -->

          <!-- pesan treeview -->
          <!-- tentukan attribute active class -->
          <li class="
             <?php if ($this->uri->segment('1') == 'pesan_adm') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'inbox_adm') {
                echo 'active treeview';
              } ?>">

            <a href="#">
              <i class="fa fa-envelope"></i>
              <span>pesan</span>
               <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>

            <!-- tentukan attribute active class -->
            <ul class="treeview-menu">
              <li class="<?php if ($this->uri->segment('1') == 'pesan_adm') {echo 'active';} ;?>">
                <a href="<?php echo site_url('pesan_adm');?>"> Tulis Pesan</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'inbox_adm') {echo 'active';} ;?>">
                <a href="<?php echo site_url('inbox_adm');?>"> Pesan Masuk</a>
              </li>
            </ul>
          </li>
          <!-- end pesan treeview -->
        </ul>
      <?php break; ?>
      <?php default: ?>
        <ul class="sidebar-menu">
          <!-- dashboard -->
          <li class="<?php if ($this->uri->segment('1') == 'dashboard_adm') {echo 'active';} ?>">
            <a href="<?php echo site_url('dashboard_adm');?>">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
          </li>
          <!-- end dashboard -->

          <!-- laporan treeview -->
          <!-- tentukan attribute active class -->
          <li class="
             <?php if ($this->uri->segment('1') == 'laporan_stok') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'Laporan_permintaan') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'laporan_history_order') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'laporan_penerimaan') {
                echo 'active treeview';  
              }elseif ($this->uri->segment('1') == 'laporan_penjualan') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'laporan_retur_masuk') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'laporan_retur_keluar') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'laporan_mutasi') {
                echo 'active treeview';
              } ?>">

            <a href="#">
              <i class="fa fa-bar-chart-o"></i>
              <span>Laporan</span>
               <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>

            <!-- tentukan attribute active class -->
            <ul class="treeview-menu">
              <li class="<?php if ($this->uri->segment('1') == 'laporan_stok') {echo 'active';} ;?>">
                <a href="<?php echo site_url('laporan_stok');?>"> Laporan Stok Produk</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'Laporan_permintaan') {echo 'active';} ?>">
                <a href="<?php echo site_url('Laporan_permintaan');?>"> Laporan Permintaan</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'laporan_history_order') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_history_order');?>"> Laporan Riwayat Permintaan</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'laporan_penerimaan') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_penerimaan');?>"> Laporan Penerimaan</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'laporan_penjualan') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_penjualan');?>"> Laporan Penjualan</a>
              </li>
               <li class="<?php if ($this->uri->segment('1') == 'laporan_retur_masuk') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_retur_masuk');?>"> Laporan Penerimaan Retur</a>
              </li>
               <li class="<?php if ($this->uri->segment('1') == 'laporan_retur_keluar') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_retur_keluar');?>"> Laporan Retur Penjualan</a>
              </li>
               <li class="<?php if ($this->uri->segment('1') == 'laporan_mutasi') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_mutasi');?>"> Laporan Mutasi</a>
              </li>
            </ul>
          </li>
          <!-- end laporan treeview -->

          <!-- pesan treeview -->
          <!-- tentukan attribute active class -->
          <li class="
             <?php if ($this->uri->segment('1') == 'pesan_adm') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'inbox_adm') {
                echo 'active treeview';
              } ?>">

            <a href="#">
              <i class="fa fa-envelope"></i>
              <span>pesan</span>
               <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>

            <!-- tentukan attribute active class -->
            <ul class="treeview-menu">
              <li class="<?php if ($this->uri->segment('1') == 'pesan_adm') {echo 'active';} ;?>">
                <a href="<?php echo site_url('pesan_adm');?>"> Tulis Pesan</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'inbox_adm') {echo 'active';} ;?>">
                <a href="<?php echo site_url('inbox_adm');?>"> Pesan Masuk</a>
              </li>
            </ul>
          </li>
          <!-- end pesan treeview -->
        </ul>    
       <?php break;
      endswitch; ?>
    </section>
    <!-- /.sidebar -->
</aside>