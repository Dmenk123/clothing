<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> 
        <!-- *** SIDEBAR-1 MENU *** -->
        <div class="panel panel-default sidebar-menu">
            <div class="panel-heading">
                <h3 class="panel-title">Kategori Produk</h3>
            </div>
            <div class="panel-body">
                <ul class="nav nav-pills nav-stacked category-menu">
                    <?php $urut = 1; ?>
                    <?php foreach ($menu_navbar as $value) { ?>
                    <li class="<?php echo 'li_submenu'.$urut; ?>">
                        <a href="#"><?php echo $value->nama_kategori; ?></a>
                        <?php for ($i=1; $i <=$count_kategori; $i++) { ?>
                            <?php if ($value->id_kategori == $i) { ?>
                                <?php foreach ($submenu[$i] as $val) { ?>
                                    <ul>
                                        <li><a href="<?php echo site_url('produk/sub_kategori/').$val->id_sub_kategori; ?>"><?php echo $val->nama_sub_kategori; ?></a></li>
                                    </ul>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>
                    </li>
                    <?php $urut++; ?>
                    <?php } ?>
                </ul>
            </div>
            <div id="segment" class="hidden"><?php echo $this->uri->segment(3); ?></div>
        </div>
        <!-- *** END SIDEBAR-1 MENU *** --> 