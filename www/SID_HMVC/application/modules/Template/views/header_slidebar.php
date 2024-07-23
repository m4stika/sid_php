<?php
    // if (isset($_GET["page"])) {
    //     $page = $_GET["page"];
    // } else {
    //     $page = "";
    // }

    // if (isset($_GET["content"])) {
    //     $content = $_GET["content"];
    // } else {
    //     $content = "";
    // }

    if (! isset($page)) {       
        @$page = "";
    }

    if (! isset($content)) {        
        @$content = "";
    }
    
?>
<div class="page-container">
<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu page-sidebar-menu-light page-sidebar-menu-hover-submenu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper hide">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler">
                    <span></span>
                </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>
            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
            <li class="sidebar-search-wrapper">
                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                <form class="sidebar-search  sidebar-search-bordered" action="#" method="POST">
                    <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                    </a>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <a href="javascript:;" class="btn submit">
                                <i class="icon-magnifier"></i>
                            </a>
                        </span>
                    </div>
                </form>
                <!-- END RESPONSIVE QUICK SEARCH FORM -->
            </li>
            <?php //echo "<li class= \"nav-item start $aktif\">"; $aktif = $_GET["aktif_pemasaran"] ?>
			<li id="dashboard" class="nav-item <?php if (($page == "dashboard")) { ?> start active open <?php } ?> "> <!-- start active open"> -->
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">Dashboard</span>
                    <span class="arrow"></span>
                    <?php if ($page == "") {?> <span class="selected"></span> <?php } ?>
                    
                </a>
                <ul class="sub-menu">
                    <li id="db-perencanaan" class="nav-item <?php if ($content == "perencanaan") { ?>  active open <?php } ?> ">
                        <a href="<?php echo site_url()?>dashboard" class="nav-link ">
                            <i class="icon-bar-chart"></i>
                            <span class="title">Perencanaan</span>
                            <?php if ($content == "") {?> <span class="selected"></span> <?php } ?>
                        </a>
                    </li>
                    <li id="db-pemasaran" class="nav-item <?php if ($content == "dbpemasaran") { ?>  active open <?php } ?> ">
                        <a href="<?php echo site_url()?>dashboard" class="nav-link ">
                            <i class="icon-bulb"></i>
                            <span class="title">Pemasaran</span>
                            <span class="badge badge-success">1</span>
                            <?php if ($content == "dbpemasaran") {?> <span class="selected"></span> <?php } ?>
                        </a>
                    </li>
                    <li id="db-kasbank" class="nav-item  <?php if ($content == "dbkasbank") { ?>  active open <?php } ?> ">
                        <a href="<?php echo site_url()?>dashboard" class="nav-link ">
                            <i class="icon-graph"></i>
                            <span class="title">Kas Bank</span>
                            <span class="badge badge-danger">5</span>
                            <?php if ($content == "kasbank") {?> <span class="selected"></span> <?php } ?>
                        </a>
                    </li>
					<li id="db-accounting" class="nav-item <?php if ($content == "dbaccounting") { ?>  active open <?php } ?> ">
                        <a href="<?php echo site_url()?>dashboard" class="nav-link ">
                            <i class="icon-graph"></i>
                            <span class="title">Accounting</span>
                            <span class="badge badge-danger">5</span>
                            <?php if ($content == "dbaccounting") {?> <span class="selected"></span> <?php } ?>
                        </a>
                    </li>
					<li id="db-inventory" class="nav-item <?php if ($content == "dbinventory") { ?>  active open <?php } ?> ">
                        <a href="<?php echo site_url()?>dashboard" class="nav-link ">
                            <i class="icon-graph"></i>
                            <span class="title">Inventory</span>
                            <span class="badge badge-danger">5</span>
                            <?php if ($content == "dbinventory") {?> <span class="selected"></span> <?php } ?>
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- <li id="perencanaan"  class="nav-item <?php //if ($page == "perencanaan") { ?> active open <?php //} ?> "> 
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-notebook"></i>
                    <span class="title">Perencanaan</span>
                    <span class="arrow"></span>
                    <?php //if ($page == "perencanaan") {?> <span class="selected"></span> <?php //} ?>
                </a>
                <ul class="sub-menu">
                    <li id="typerumah" class="nav-item <?php //if ($content == "typerumah") { ?>  active open <?php //} ?> ">
                        <a href="<?php //echo base_url(); ?>Perencanaan/typerumah" class="nav-link ">
                            <span class="title">Type Rumah</span>
                            <?php //if ($content == "typerumah") {?> <span class="selected"></span> <?php //} ?>
                        </a>
                    </li>
                    <li id="masterkavling" class="nav-item <?php //if ($content == "masterkavling") { ?>  active open <?php //} ?> ">
                        <a href="<?php echo base_url(); ?>Perencanaan/masterkavling" class="nav-link ">
                            <span class="title">Master Kavling</span>
                            <?php //if ($content == "masterkavling") {?> <span class="selected"></span> <?php //} ?>
                        </a>
                    </li>
                                                   
                </ul>
            </li> -->
			
			<li id="pemasaran"  class="nav-item <?php if ($page == "pemasaran") { ?> active open <?php } ?> "> 
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-basket-loaded"></i>
                    <span class="title">Pemasaran</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <?php if ($content == "karyawan") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Pemasaran/karyawan" class="nav-link ">
                            <span class="title">Daftar Karyawan</span>  
                            <?php if ($content == "karyawan") {?> <span class="selected"></span> <?php } ?>                                      
                        </a>
                    </li>  
                    <li class="nav-item <?php if ($content == "masterdokumen") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Pemasaran/masterdokumen" class="nav-link ">
                            <span class="title">Master Dokumen dan Progress</span>  
                            <?php if ($content == "masterdokumen") {?> <span class="selected"></span> <?php } ?>                                      
                        </a>
                    </li>   
                    <li class="divider"></li>
                    <li id="typerumah" class="nav-item <?php if ($content == "typerumah") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Perencanaan/typerumah" class="nav-link ">
                            <span class="title">Type Rumah</span>
                            <?php if ($content == "typerumah") {?> <span class="selected"></span> <?php } ?>
                        </a>
                    </li>
                    <li id="masterkavling" class="nav-item <?php if ($content == "masterkavling") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Perencanaan/masterkavling" class="nav-link ">
                            <span class="title">Master Kavling</span>
                            <?php if ($content == "masterkavling") {?> <span class="selected"></span> <?php } ?>
                        </a>
                    </li>
                    <li class="divider"></li>

                    <!-- <li id="hargatyperumah" class="nav-item <?php if ($content == "hargatyperumah") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Pemasaran/harga_typerumah" class="nav-link ">
                            <span class="title">Harga Type Rumah</span>
                            <?php if ($content == "hargatyperumah") {?> <span class="selected"></span> <?php } ?>
                        </a>
                    </li>
                    <li class="nav-item <?php if ($content == "hargakavling") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Pemasaran/harga_kavling" class="nav-link ">
                            <span class="title">Harga kavling</span>  
                            <?php if ($content == "hargakavling") {?> <span class="selected"></span> <?php } ?>                                      
                        </a>
                    </li> -->
                                     					
					<li class="nav-item <?php if ($content == "browsepemesanan") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Pemasaran/pemesanan" class="nav-link ">
                            <span class="title">Browse Pemesanan</span>  
                            <?php if ($content == "browsepemesanan") {?> <span class="selected"></span> <?php } ?>                                      
                        </a>
                    </li>   
                    <li class="nav-item <?php if ($content == "pemesanan") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Pemasaran/pemesanan/pemesanan_new" class="nav-link ">
                            <span class="title">Pemesanan-New</span>  
                            <?php if ($content == "pemesanan") {?> <span class="selected"></span> <?php } ?>                                      
                        </a>
                    </li>   
					<li class="nav-item <?php if ($content == "kwitansi") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Pemasaran/pembayaran" class="nav-link ">
                            <span class="title">Kwitansi</span>  
                            <?php if ($content == "kwitansi") {?> <span class="selected"></span> <?php } ?>                                      
                        </a>
                    </li>  
                </ul>
            </li>
            <li class="nav-item <?php if ($page == "kasbank") { ?> active open <?php } ?> "> 
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-money"></i>
                    <span class="title">Kas Bank</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <?php if ($content == "cash") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Kasbank/kasbank" class="nav-link ">
                            <span class="title">Cash IN
                                <br>(OUT)</span>
                            <?php if ($content == "cashin") {?> <span class="selected"></span> <?php } ?>
                        </a>
                    </li>

                    <li class="nav-item <?php if ($content == "bank") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Kasbank/get_BankInOut" class="nav-link ">
                            <span class="title">Bank IN
                                <br>(OUT)</span>
                            <?php if ($content == "bankin") {?> <span class="selected"></span> <?php } ?>
                        </a>
                    </li>
					<!-- <li class="nav-item  ">
                        <a href="form_controls_md.html" class="nav-link ">
                            <span class="title">Journal Browse</span>
                        </a>
                    </li> -->
					<li class="nav-item <?php if ($content == "kbassign") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Kasbank/get_assign" class="nav-link ">
                            <span class="title">Jurnal Assign</span>
                            <?php if ($content == "kbassign") {?> <span class="selected"></span> <?php } ?>
                        </a>
                    </li>
                    <li class="nav-item <?php if ($content == "kbextract") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Kasbank/get_extract" class="nav-link ">
                            <span class="title">Extract Data</span>
                            <?php if ($content == "kbextract") {?> <span class="selected"></span> <?php } ?>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item <?php if ($page == "accounting") { ?> active open <?php } ?> "> 
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-book-open"></i>
                    <span class="title">Accounting</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <?php if ($content == "perkiraan") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Accounting/perkiraan" class="nav-link ">
                            <span class="title">Daftar Perkiraan</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if ($content == "openingbalance") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Accounting/openingbalance" class="nav-link ">
                            <span class="title">Saldo Awal</span>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li class="nav-item <?php if ($content == "journal") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Accounting/journal" class="nav-link ">
                            <span class="title">Jurnal Umum</span>
                        </a>
                    </li>
					<li class="nav-item <?php if ($content == "extract") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Accounting/extract" class="nav-link ">
                            <span class="title">Jurnal Extract</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if ($content == "assign") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Accounting/assign" class="nav-link ">
                            <span class="title">Jurnal Assign</span>
                        </a>
                    </li>
                    <li class="divider"></li>
					<li class="nav-item <?php if ($content == "fixedasset") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Accounting/fixedasset" class="nav-link ">
                            <span class="title">Aktiva Tetap</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if ($content == "penyusutan") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Accounting/penyusutan" class="nav-link ">
                            <span class="title">Proses Penyusutan</span>
                        </a>
                    </li>
                    <li class="divider"></li>
					<li class="nav-item  ">
                        <a href="elements_lists.html" class="nav-link ">
                            <span class="title">Tutup Buku</span>
                        </a>
                    </li>
                </ul>
            </li>
           
            <li class="nav-item ">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-layers"></i>
                    <span class="title">Inventory</span>                                
                    <span class="arrow open"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  active open">
                        <a href="layout_blank_page.html" class="nav-link ">
                            <span class="title">Supplier</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="layout_language_bar.html" class="nav-link ">
                            <span class="title">Barang</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="layout_footer_fixed.html" class="nav-link ">
                            <span class="title">Surat Pemesanan <br> (PO)</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="layout_boxed_page.html" class="nav-link ">
                            <span class="title">Pembayaran Hutang</span>
                        </a>
                    </li>
					<li class="nav-item  ">
                        <a href="layout_boxed_page.html" class="nav-link ">
                            <span class="title">Retur Pembelian</span>
                        </a>
                    </li>
					<li class="nav-item  ">
                        <a href="layout_boxed_page.html" class="nav-link ">
                            <span class="title">Kartu Stock</span>
                        </a>
                    </li>
					<li class="nav-item  ">
                        <a href="layout_boxed_page.html" class="nav-link ">
                            <span class="title">Kartu Hutang</span>
                        </a>
                    </li>
                </ul>
            </li>  
            
            <li class="nav-item <?php if ($page == "utility") { ?> active open <?php } ?> "> 
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-book-open"></i>
                    <span class="title">Utility</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item <?php if ($content == "report") { ?>  active open <?php } ?> ">
                        <a href="<?php echo base_url(); ?>Report/report" class="nav-link ">
                            <span class="title">Daftar Laporan</span>  
                            <?php if ($content == "report") {?> <span class="selected"></span> <?php } ?>                                      
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="table_static_responsive.html" class="nav-link ">
                            <span class="title">Parameter System</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="table_bootstrap.html" class="nav-link ">
                            <span class="title">Group User</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="table_bootstrap.html" class="nav-link ">
                            <span class="title">Ganti Password</span>
                        </a>
                    </li>
                </ul>
            </li> 
           
        </ul>
        <!-- END SIDEBAR MENU -->
        
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="<?php echo base_url(); ?>">
				<img src="<?php echo base_url(); ?>assets/pages/img/logo-harmony2.png" alt="logo"/> </a>                    
		</div>
    </div>
    <!-- END SIDEBAR -->
</div>
