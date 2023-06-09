<?php 
$uri        = $this->uri->segment(1);
$uri1       = $this->uri->segment(2);
$uri2       = $this->uri->segment(3);
$user_type  = $this->session->userdata('dealer_session')['user']['user_type']; 

?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="<?= (isset( $uri ) && $uri == 'dealer-admin' && empty( $uri1 )) ? 'active':'' ?>">
                <a href="<?= base_url('dealer-admin');?>"><i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <?php 
            if( isset( $user_type ) && $user_type != 'counter_person' ) {
            ?>
            <li class="treeview <?= (isset($uri1) && $uri1 == 'dealers' ) ? 'menu-open' : '' ?>">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Branch Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu" <?php if(isset($uri1) && $uri1 == 'dealers' ) { ?> style="display: block;"
                    <?php } ?>>
                    <!-- <li <?php if(isset($uri1) && $uri1 == 'dealers' && $uri2 == 'add' ) { ?> class="active" <?php } ?>>
                        <a href="<?= base_url('dealer-admin/dealers/add'); ?>"><i class="fa fa-plus"></i> Add Dealer</a>
                    </li>
                    <li <?php if(isset($uri1) && $uri1 == 'dealers' && empty( $uri2 ) ) { ?> class="active" <?php } ?>>
                        <a href="<?= base_url('dealer-admin/dealers'); ?>"><i class="fa fa-list-alt"></i> List Dealers
                        </a>
                    </li> -->
                    <li>
                        <a
                            href="<?= base_url('dealer-admin/dealers/'.$this->session->userdata('dealer_session')['dealer']['id'].'/location'); ?>"><i
                                class="fa fa-list-alt"></i> Branch Locations
                        </a>
                    </li>

                    <!-- <li>
                        <a href="<?= base_url('dealer-admin/dealers'); ?>"><i class="fa fa-list-alt"></i> Dealers Users
                        </a>
                    </li> -->
                </ul>
            </li>
            <li class="">
                <a href="<?= base_url('dealer-admin/dealers/reports')?>">
                    <i class="fa fa-files-o"></i>
                    <span> Reports </span>
                </a>

            </li>
            <?php } ?>
        </ul>
        </li>
        </ul>

    </section>
    <!-- /.sidebar -->
</aside>