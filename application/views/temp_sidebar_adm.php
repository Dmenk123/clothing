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
              }elseif ($this->uri->segment('1') == 'master_tag_adm') {
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
                <a href="<?php echo site_url('master_kategori_adm');?>"><i class="fa fa-bookmark"></i> Master Kategori</a>
              </li>
							<li class="<?php if ($this->uri->segment('1') == 'master_tag_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('master_tag_adm');?>"><i class="fa fa-tags"></i> Master Tag Produk</a>
              </li>
            </ul>
          </li>
          <!-- end master treeview -->

          <!-- transaksi treeview -->
          <!-- tentukan attribute active class -->
          <li class="
             <?php if ($this->uri->segment('1') == 'confirm_penjualan_adm') {
                echo 'active treeview';  
              }else if ($this->uri->segment('1') == 'penjualan_fix_adm') {
                echo 'active treeview';
              }?>">
            <a href="#">
              <i class="fa fa-exchange"></i>
              <span>Data Transaksi</span>
               <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <!-- tentukan attribute active class -->
            <ul class="treeview-menu">
              <li class="<?php if ($this->uri->segment('1') == 'confirm_penjualan_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('confirm_penjualan_adm');?>"><i class="fa fa-check"></i> Konfirmasi Penjualan</a>
              </li>
							<li class="<?php if ($this->uri->segment('1') == 'penjualan_fix_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('penjualan_fix_adm');?>"><i class="fa fa-plus-square"></i> Penjualan Fix</a>
              </li>
            </ul>
          </li>
          <!-- end transaksi treeview -->

          <!-- laporan treeview -->
          <!-- tentukan attribute active class -->
          <li class="
             <?php if ($this->uri->segment('1') == 'laporan_keuangan') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'laporan_penjualan') {
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
              <li class="<?php if ($this->uri->segment('1') == 'laporan_keuangan') {echo 'active';} ;?>">
                <a href="<?php echo site_url('laporan_keuangan');?>"> Laporan Keuangan</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'laporan_penjualan') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_penjualan');?>"> Laporan Penjualan</a>
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
              }elseif ($this->uri->segment('1') == 'master_tag_adm') {
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
                <a href="<?php echo site_url('master_kategori_adm');?>"><i class="fa fa-bookmark"></i> Master Kategori</a>
              </li>
							<li class="<?php if ($this->uri->segment('1') == 'master_tag_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('master_tag_adm');?>"><i class="fa fa-tags"></i> Master Tag Produk</a>
              </li>
            </ul>
          </li>
          <!-- end master treeview -->

          <!-- transaksi treeview -->
          <!-- tentukan attribute active class -->
          <li class="
             <?php if ($this->uri->segment('1') == 'confirm_penjualan_adm') {
                echo 'active treeview';
              }else if ($this->uri->segment('1') == 'penjualan_fix_adm') {
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
              <li class="<?php if ($this->uri->segment('1') == 'confirm_penjualan_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('confirm_penjualan_adm');?>"><i class="fa fa-check"></i> Konfirmasi Penjualan</a>
              </li>
							<li class="<?php if ($this->uri->segment('1') == 'penjualan_fix_adm') {echo 'active';} ?>">
                <a href="<?php echo site_url('penjualan_fix_adm');?>"><i class="fa fa-plus-square"></i> Penjualan Fix</a>
              </li>
            </ul>
          </li>
          <!-- end transaksi treeview -->

          <!-- laporan treeview -->
          <!-- tentukan attribute active class -->
          <li class="
             <?php if ($this->uri->segment('1') == 'laporan_keuangan') {
                echo 'active treeview';
              }elseif ($this->uri->segment('1') == 'laporan_penjualan') {
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
              <li class="<?php if ($this->uri->segment('1') == 'laporan_keuangan') {echo 'active';} ;?>">
                <a href="<?php echo site_url('laporan_keuangan');?>"> Laporan Keuangan</a>
              </li>
              <li class="<?php if ($this->uri->segment('1') == 'laporan_penjualan') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_penjualan');?>"> Laporan Penjualan</a>
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
              }elseif ($this->uri->segment('1') == 'laporan_penjualan') {
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
              <li class="<?php if ($this->uri->segment('1') == 'laporan_penjualan') {echo 'active';} ?>">
                <a href="<?php echo site_url('laporan_penjualan');?>"> Laporan Penjualan</a>
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
