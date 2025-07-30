<?php $identitas = $this->db->get('tbl_aplikasi')->row(); ?>
<!-- Main Sidebar Container -->
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" width="50%" height="50%" class="rounded-circle" src="<?php echo base_url('assets/dist/img/profile/' . $user['image']); ?>"/>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold"><?php echo $user['nama']; ?></span>
                        <span class="text-muted text-xs block"><?php echo $user['level']; ?> <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                     
                        <li><a class="dropdown-item logout" href="#">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            <li>
                <a href="<?php echo base_url('admin/index'); ?>"><i class="fa fa-home"></i> <span class="nav-label">Dashboards</span>  </a>

            </li>
       
            <li>
                <a href="#"><i class="fa fa-database"></i> <span class="nav-label">Master Data</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <!-- <li><a href="<?php echo base_url('admin/man_user'); ?>">Management User</a></li> -->
                    <li><a href="<?php echo base_url('alternatif'); ?>">Data Alternatif</a></li>
                    <li><a href="<?php echo base_url('kriteria'); ?>">Data Kriteria</a></li>
                    <li><a href="<?php echo base_url('subkriteria'); ?>">Data Subkriteria</a></li>
                </ul>
            </li>
            <li>
                <a href="<?php echo base_url('penilaian'); ?>"><i class="fa fa-star"></i> <span class="nav-label">Penilaian</span>  </a>

            </li>
            <li>
                <a href="#"><i class="fa fa-files-o"></i> <span class="nav-label">Laporan</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="<?php echo base_url('laporan'); ?>">Periode Penilaian</a></li>
                    <!-- <li><a href="<?php echo base_url('laporan/detail_perhitungan'); ?>">Detail Penilaian</a></li> -->
                </ul>
            </li>
            
         
            <!-- <li>
                <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Settings</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="<?php echo base_url('admin/setup_aplikasi'); ?>">Identitas Aplikasi</a></li>
                </ul>
            </li> -->
            

            <!-- <li>
                <a href="#" class="backup"><i class="fa fa-download"></i> <span class="nav-label">Backup Database</span></a>
            </li> -->
           
            <li>
                <a href="#" class="logout"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout </span></a>
            </li>
           
        </ul>

    </div>
</nav>


<div id="page-wrapper" class="gray-bg">
<div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="search_results.html">
                <div class="form-group">
                    
                </div>
            </form>
        </div>
        <ul class="nav navbar-top-links navbar-right">
           <!--  <li>

                
                <span class="m-r-sm text-muted welcome-message"><marquee><?= $identitas->nama_aplikasi ?></marquee></span>
            </li> -->
          

            <li>
                <a href="#" class="logout">
                    <i class="fa fa-sign-out"></i> Log out
                </a>
            </li>
        </ul>

    </nav>
</div>
 <div class="">
    