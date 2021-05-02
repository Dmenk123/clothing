<header class="main-header">
   <!-- Logo -->
   <a href="<?php echo site_url('home');?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="<?php echo base_url('assets/img/logo_thumb.png');?>"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?php echo base_url('assets/img/logo_small.png');?>"></span>
   </a>
   
   <!-- Header Navbar: style can be found in header.less -->
   <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
         <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- custom menu -->
      <div class="navbar-custom-menu">
         <ul class="nav navbar-nav">
         <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">
               <?php foreach ($data_user as $val) { ?>
                  <span class="hidden-xs" style="padding: 30px;"><?php echo $val->fname_user." ".$val->lname_user;?></span>
              <?php } ?>
               </a>
               <ul class="dropdown-menu">

                  <!-- User image -->
                  <li class="user-header">
                  <?php foreach ($data_user as $val) { ?>
                     <img src="<?php echo config_item('assets'); ?>img/foto_profil/<?php echo $val->foto_user; ?>" class="img-circle" alt="User Image">  
                     <p><?php echo $val->fname_user." ".$val->lname_user;?></p>
                  <?php } ?>
                  </li>

                  <!-- Menu Footer-->
                  <li class="user-footer">
                     <div class="pull-left">
                     <?php $id_user = $this->session->userdata('id_user');?>
                  	  <a href='<?php echo site_url("profil/edit_profil/$id_user");?>' class="btn btn-default btn-flat">Profile</a>
                     </div>
                     <div class="pull-right">
                        <a  href="javascript:void(0);" onclick="logout_proc()" class="btn btn-default btn-flat">Logout</a>
                     </div>
                  </li>
               </ul>  
            </li> 
         </ul>
      </div>
      <!-- notifikasi -->
      <div class="navbar-custom pull-right"> 
         <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i>
               <?php if ($qty_notif > 0) { ?>
                  <span class="badge badge-danger" id="load_row"><?php echo $qty_notif;?></span>
               <?php } ?> 
               </a>
               <?php $no=0;
               if (count($isi_notif) > 0) { ?>
                  <?php $link = site_url('inbox/index'); ?>
                  <ul class="dropdown-menu" role="menu" id="load_data">
                  <?php foreach($isi_notif as $notif) { 
                  $no++;
                  if($no % 2==0) {
                     $strip='strip1';
                  }else {
                     $strip='strip2';
                  } ?>
                     <li>
                        <a href="#" class="<?php echo $strip; ?> linkNotif" id="<?php echo $notif->id_pesan;?>">
                           <?php echo $notif->subject_pesan; ?> <br>
                           <small>
                              <strong><?php echo $notif->email_pesan; ?></strong> (<?php echo timeAgo($notif->time_post);?>)</small>
                        </a>
                     </li>
                  <?php } ?>
                  </ul>
               <?php } ?>
            </li>  
         </ul>
      </div>  
   </nav>
</header>