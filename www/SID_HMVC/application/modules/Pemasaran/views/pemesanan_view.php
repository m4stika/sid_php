
<head>
    <link href="<?php echo base_url(); ?>assets/layouts/layout/css/custom.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />        
    <link href="<?php echo base_url(); ?>assets/pages/css/kwitansi.css" rel="stylesheet" type="text/css"/>

    <!-- <script src="../assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript"></script>
    <script src="../assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript"></script> -->
    <link href="https://fonts.googleapis.com/css?family=Vast+Shadow" rel="stylesheet">
    
    <!-- <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/jquery-ui.min.css" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script> -->

    <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>    
    <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/pages/scripts/form-input-mask.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/pages/scripts/modal-reposition.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/pages/scripts/form-pembayaran.js" type="text/javascript"></script>     
    <!-- <script src="<?php echo base_url(); ?>assets/pages/scripts/my-toastr.js" type="text/javascript"></script> -->
    <script src="<?php echo base_url(); ?>assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/pages/scripts/modal-reposition.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/pages/scripts/grid_dropdown.js" type="text/javascript"> </script>
    <script src="<?php echo base_url(); ?>assets/pages/scripts/pemesanan.js" type="text/javascript"></script>

    <!-- END HEAD -->
    <script type="text/javascript">
        var nokavlingOption = <?php echo json_encode($options); ?>;
        (function(original) {
            parseInt = function() {
                return original.apply(window, arguments) || 0;
            };
        })(parseInt);
    </script>
    
</head>

<body>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            
			<!-- BEGIN THEME PANEL -->
            <?php //$this->load->view('Template/theme_panel');?>
            <!-- END THEME PANEL -->
			
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <a href="#">Home</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <a href="#">Pemarasan</a>
                        <i class="fa fa-circle"></i>
                    </li>
                    <li>
                        <span>Browse Pemesanan</span>
                    </li>
                </ul>
                <div class="page-toolbar">
                    <div class="btn-group pull-right">
                        <button type="button" class="btn green btn-sm btn-outline dropdown-toggle" data-toggle="dropdown"> Actions
                            <i class="fa fa-angle-down"></i>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li>
                                <a href="#">
                                    <i class="icon-bell"></i> Action</a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="icon-shield"></i> Another action</a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="icon-user"></i> Something else here</a>
                            </li>
                            <li class="divider"> </li>
                            <li>
                                <a href="#">
                                    <i class="icon-bag"></i> Separated link</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="browsepemesanan">
                <!-- END PAGE BAR -->
                <!-- BEGIN PAGE TITLE-->
                <h3 class="page-title"> Pemasaran 
                    <small>Browse pemesanan</small>
                </h3>
                <!-- END PAGE TITLE-->
                <!-- END PAGE HEADER-->
				<!-- <div class="m-heading-1 border-green m-bordered">
                    <h3>Uraian</h3>						
                    <p> </p>
                    <p> </p>
                </div>   -->                  
				
				<div class="row">
                    <div class="col-md-12">
                        <!-- Begin: life time stats 
                        <div class="portlet light portlet-fit portlet-datatable bordered"> -->
						
						<div class="portlet box green"> 
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-settings font-white"></i>
                                    <span class="caption-subject font-white">Browse Pemesanan</span>
                                </div>
                                <?php $this->load->view('Template/export_tools');?>
                            </div>
                            <div class="portlet-body">
                               <!-- <div class="table-container"> -->
                               <!-- <div class="table-toolbar">
                                    <div class="row">
                                        <div class="col-md-6">                                                    
                                            <button type="button" class="new btn btn-icon-only green"><i class="fa fa-plus fa-2x"></i></button>
                                            <button type="button" class="edit btn btn-icon-only blue" disabled><i class="fa fa-edit fa-2x"></i></button>
                                            <button type="button" class="copy btn btn-icon-only purple-plum" disabled><i class="fa fa-copy fa-2x"></i></button>
                                            <button type="button" class="delete btn btn-icon-only red-mint" disabled><i class="fa fa-trash-o fa-2x"></i></button>
                                            <button type="button" class="payment btn btn-icon-only green-meadow" disabled value=0><i class="fa fa-money fa-2x"></i></button>
                                        </div>
                                        <div class="col-md-6 pemesanan_tools">                                                
                                            
                                        </div>
                                    </div>
                               </div> -->
							   <div class="table-container">
									<div class="table-toolbar">
                                        <!-- <div class="row">
                                            <div class="col-md-6"> -->
                                        <button type="button" class="new btn btn-icon-only green"><i class="fa fa-plus fa-2x"></i></button>
                                        <button type="button" class="edit btn btn-icon-only blue" disabled><i class="fa fa-edit fa-2x"></i></button>
                                        <button type="button" class="copy btn btn-icon-only purple-plum" disabled><i class="fa fa-copy fa-2x"></i></button>
                                        <button type="button" class="delete btn btn-icon-only red-mint" disabled><i class="fa fa-trash-o fa-2x"></i></button>
                                        <button type="button" class="payment btn btn-icon-only green-meadow" disabled value=0><i class="fa fa-money fa-2x"></i></button>
                                        <button type="button" class="export btn btn-icon-only green-dark"><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i></button>
                                        <!-- <button type="button" class="print btn btn-icon-only green-dark"><i class="fa fa-file-excel-o fa-2x" aria-hidden="true" onclick="javascript:window.print();"></i></button> -->
                                        

                                        <!-- <button type="button" class="payment btn btn-icon-only green-meadow" disabled value=0><i class="fa fa-money fa-2x"></i></button> -->
                                            <!-- <div class="col-md-6 pemesanan_tools">                                                
                                                <?php //$this->load->view('Template/export_tools');?>
                                            </div> -->
                                        <!-- </div> -->
                                   </div>
									
                                    <table class="table table-striped table-bordered table-hover" id="table_pemesanan">	
                                        <thead>
									  
										  <!-- <tr role="row" class="heading">
												<th width="30%" colspan=2 class="header-sub dt-head-center"> # Actions </th>
                                                <th width="30%" colspan=8 class="header-sub dt-head-center"> Data Konsumen </th>
												<th width="10%" colspan=2 class="header-sub dt-head-center"> Harga Standard </th>
												<th width="40%" colspan=4 class="header-sub dt-head-center"> Harga Tambahan </th>
												<th width="10%" colspan=3  class="header-sub dt-head-center"> TOTAL HARGA </th>
                                                <th width="10%" colspan=12  class="header-sub dt-head-center"> Pembayaran </th>
                                                <th width="10%" colspan=2  class="header-sub dt-head-center"> SALDO </th>
											</tr> -->

											<tr role="row" class="heading">
                                                <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
                                                <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
                                                <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
                                                <th></th><th></th><th></th><th></th>
												
                                                <!-- <th class="all"> # </th>
                                                <th class="all"> Actions </th>
                                                <th class="min-tablet-p dt-body-right"> Noid </th>
                                                <th class="all"> NoPesanan </th>
                                                <th class="min-tablet-l"> Pola&nbsp;Pemby. </th>
                                                <th style='width: 200px !important;' class="all"> Nama&nbsp;Pemesan </th>
												<th class="none"> Blok </th>
												<th class="none"> No&nbsp;Kav. </th>
                                                <th class="none"> Type </th>
                                                <th class="all"> Status </th>
                                                <th class="all"> Harga&nbsp;Jual </th>
                                                <th class="min-tablet-p"> Diskon </th>
												<th class="min-tablet-l"> KLT </th>
												<th class="min-tablet-l"> Sudut </th>
												<th class="min-tablet-l"> Hadap&nbsp;Jln </th>
                                                <th class="min-tablet-l"> Fasum </th>
                                                <th class="min-tablet-l"> Redesign </th>
                                                <th class="min-tablet-l"> Tambah&nbsp;KW. </th>
                                                <th class="min-tablet-l"> Kerja&nbsp;Tambah </th>
												<th class="all"> Tot.&nbsp;Harga</th>
												<th class="min-tablet-p"> Book.&nbsp;Fee</th>
                                                <th class="min-tablet-p"> Tot.&nbsp;UM.</th>

                                                <th class="min-tablet-l"> Bayar&nbsp;BF</th>
                                                <th class="min-tablet-l"> Bayar&nbsp;UM</th>
                                                <th class="min-tablet-l"> Bayar&nbsp;Sudut</th>
                                                <th class="min-tablet-l"> Bayar&nbsp;Jln</th>
                                                <th class="min-tablet-l"> Bayar&nbsp;KLT</th>
                                                <th class="min-tablet-l"> Bayar&nbsp;Fasum</th>
                                                <th class="min-tablet-l"> Bayar&nbsp;Redisign</th>
                                                <th class="min-tablet-l"> Bayar&nbsp;KW</th>
                                                <th class="min-tablet-l"> Bayar&nbsp;Krj&nbsp;Tmbh</th>
                                                <th class="min-tablet-l"> Bayar&nbsp;Pokok</th>
                                                <th class="all"> TOT.&nbsp;Bayar</th>
                                                <th class="all"> Tot.&nbsp;Byr.&nbsp;Titipan</th>
                                                <th class="all"> TOTAL</th> -->
                                                
                                                <!-- <th style='width: 200px !important;' class="all"> New/Edit/Delete</th> -->

                                                <!-- <th > &nbsp;</th>
                                                <th > &nbsp; </th> -->
                                            </tr>
											
											<!--
                                            <tr role="row" class="filter">                                                    
												<td> </td>
                                                <td>
                                                    <input type="text" class="form-control form-filter input-sm" name="noid"> </td>
                                                <td>
                                                    <input type="text" class="form-control form-filter input-sm" name="typerumah"> </td>                                                    
                                                <td>
                                                    <input type="text" class="form-control form-filter input-sm" name="keterangan"> </td>													
												<td> </td>
												<td> </td>
												<td>
                                                    <div class="margin-bottom-5">
                                                        <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                                            <i class="fa fa-search"></i> Search</button>															
                                                    </div>
                                                    <button class="btn btn-sm red btn-outline filter-cancel">
                                                        <i class="fa fa-times"></i> Reset</button>
                                                </td>-->
												<!--
                                                <td>
                                                    <select name="order_status" class="form-control form-filter input-sm">
                                                        <option value="">Select...</option>
                                                        <option value="pending">Pending</option>
                                                        <option value="closed">Closed</option>
                                                        <option value="hold">On Hold</option>
                                                        <option value="fraud">Fraud</option>
                                                    </select>
                                                </td>
                                                
                                            </tr>
											-->
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
								</div>
                               <!-- </div> -->
                            </div>
                        </div>
                        <!-- End: life time stats -->
                    </div>
                </div>
            </div> <!-- end of browse pemesanan -->

            

            <div id="row_pemesanan" style="display: none;"> <!-- View Form Pemesanan -->                        
                <?php $this->load->view('Pemasaran/pemesanan_form') ?>
            </div> <!-- end of view form pemesanan -->

            <div id="row_pembayaran" style="display: none;"> <!-- View Form Pemesanan -->                        
                <?php //$this->load->view('pemasaran/pembayaran_form') ?>
            </div> <!-- end of view form pemesanan -->

        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
		
	<div class="row" id="row_delete" style="display: none;">
    <!--<div id="delete" class="modal modal-message modal-danger fade" style="display: none;" aria-hidden="true"> -->
        <div class="col-md-12">
            <div class="portlet box red">
                <div class="portlet-title">
                    <div class="caption">Anda Yakin Mau Menghapus Data ?</div>
                </div>
                <div class="portlet-body">
                    <div class="row static-info">
                        <div class="col-md-3 name">No. ID</div>
                        <div class="col-md-4 value" id="noid"> </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-3 name">Nama</div>
                        <div class="col-md-4 value" id="namapemesan"> </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-3 name">Kavling</div>
                        <div class="col-md-4 value" id="kavling"> </div>
                    </div>
                    <div class="row static-info">
                        <div class="col-md-3 name">Type</div>
                        <div class="col-md-4 value"  id="typerumah"> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="row_batal" class="modal fade draggable-modal" role="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="padding:20px 30px; background-color: #D05454; color: white; text-align: center; font-size: 30px;">
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> -->
                    <h4 class="modal-title" style="font-size: 30px;">Pembatalan Pesanan</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="row static-info">
                            <div class="col-md-4 col-sm-4 name">No. Booking</div>
                            <div class="col-md-8 col-sm-8 value" id="nopesanan">-</div>
                            <div class="col-md-12 col-sm-12 margin-top-10">
                                <address  style="margin-bottom: 0"></address>
                            </div>
                        </div>    
                    </div>
                    <div class="col-md-6"  style="margin-bottom: 1px">
                        <div class="row static-info">
                            <div class="col-md-4 col-sm-5 name">Tanggal</div>
                            <div class="col-md-8 col-sm-7 value" id="tgltransaksi">-</div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-4 col-sm-5 name">Kavling</div>
                            <div class="col-md-8 col-sm-7 value" id="kavling">-</div>
                        </div>
                        <div class="row static-info">    
                            <div class="col-md-4 col-sm-5 name">Type Rumah</div>
                            <div class="col-md-8 col-sm-7 value" id="typerumah">-</div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-4 col-sm-5 name">Harga Total</div>
                            <div class="col-md-5 mask_decimal value" id="totaltransaksi">0</div>
                        </div>
                    </div>
                    </div> <!-- end of row -->

                    <hr style="margin-top: 0; padding: 0; border: none; border-bottom: 1px solid #1BBC9B;">
                    <div class="hidden" id="polapembayaran"></div>
                    <!-- <div class="margin-bottom-20 divider"></div> -->
                    <form action="" method="post" class="form-horizontal" role="form" id="form_batal">
                        <div class="form-body">
                            <input type="hidden" name="noid" id="noid">
                            <input type="hidden" name="nokavling" id="nokavling">

                            <div class="form-group">
                                <input type="hidden" name="tglbatal" id="tglbatal">
                                <label class="col-md-2 col-sm-2  control-label" for="tglpembatalan">Tanggal</label>
                                <div class="col-md-3 col-sm-3"> 
                                    <div class="input-group date date-picker" id = "dptglpembatalan">
                                        <input class="form-control" type="text"value="" name="tglpembatalan" id="tglpembatalan" data-date-start-date="+0d" readonly required/>
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <label class="col-md-2 col-sm-2 control-label" for="cbbankout">Bank Pengeluaran</label>
                                <div class="col-md-5 col-sm-5">
                                    <select class="selectpicker form-control" id="cbbankout" name="cbbankout" data-size=8 data-style="btn-default" required>
                                        <option value="" data-value="" data-content="Select from list..."></option>
                                        <?php echo $optionbank ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">No. Bukti:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-4">
                                    <input type="text" name="nobukti" class="form-control" required>
                                </div>
                                <label class="col-md-2 control-label">No. Cek:</label>
                                <div class="col-md-4">
                                    <input type="text" name="nomorcek" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Alasan Batal:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-10">
                                    <textarea rows="2" class="form-control  required" name="alasanbatal" required></textarea>
                                </div>
                            </div>
                            <div class="form-group blokpembayaran">
                                <div col-md-12>
                                    <label class="col-md-offset-2 col-md-5 col-sm-5 hidden-xs control-label" for="bookingfeebyr">Terbayar</label>
                                    <label class="col-md-5 col-sm-5 hidden-xs control-label bold" for="bookingfee">Pengembalian</label>
                                </div>
                                <div class="form-group no-gutter blokbookingfee"><div class="col-md-12">
                                    <label class="col-sm-3 control-label" for="bookingfeebyr">Booking Fee</label>
                                    <div class="col-sm-4 hidden-xs"><input type="text" class="form-control mask_decimal" id="bookingfeebyr" disabled></div>
                                    <div class="col-sm-5"><input type="text" class="form-control mask_decimal change-total" name="bookingfee" id="bookingfee"></div>
                                </div></div>
                                <div class="form-group no-gutter blokuangmuka"><div class="col-md-12">
                                    <label class="col-sm-3 control-label" for="uangmukabyr">Uang Muka</label>
                                    <div class="col-sm-4 hidden-xs"><input type="text" class="form-control mask_decimal" id="uangmukabyr" disabled></div>
                                    <div class="col-sm-5"><input type="text" class="form-control mask_decimal change-total" name="uangmuka" id="uangmuka"></div>
                                </div></div>
                                <div class="blokkpr">
                                <div class="form-group no-gutter blokklt"><div class="col-md-12">
                                    <label class="col-sm-3 control-label" for="kelebihantanahbyr">Kelebihan Tanah</label>
                                    <div class="col-sm-4 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargakltbyr" disabled></div>
                                    <div class="col-sm-5"><input type="text" class="form-control mask_decimal change-total" name="hargaklt" id="hargaklt"></div>
                                </div></div>
                                <div class="form-group no-gutter bloksudut"><div class="col-md-12">
                                    <label class="col-sm-3 control-label" for="hargasudutbyr">Posisi Sudut</label>
                                    <div class="col-sm-4 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargasudutbyr" disabled></div>
                                    <div class="col-sm-5"><input type="text" class="form-control mask_decimal change-total" name="hargasudut" id="hargasudut"></div>
                                </div></div>
                                <div class="form-group no-gutter blokhadapjalan"><div class="col-md-12">
                                    <label class="col-sm-3 control-label" for="hargahadapjalanbyr">Hadap Jalan</label>
                                    <div class="col-sm-4 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargahadapjalanbyr" disabled></div>
                                    <div class="col-sm-5"><input type="text" class="form-control mask_decimal change-total" name="hargahadapjalan" id="hargahadapjalan"></div>
                                </div></div>
                                <div class="form-group no-gutter blokfasum"><div class="col-md-12">
                                    <label class="col-sm-3 control-label" for="hargafasumbyr">Hadap Taman</label>
                                    <div class="col-sm-4 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargafasumbyr" disabled></div>
                                    <div class="col-sm-5"><input type="text" class="form-control mask_decimal change-total" name="hargafasum" id="hargafasum"></div>
                                </div></div>
                                <div class="form-group no-gutter blokredesign"><div class="col-md-12">
                                    <label class="col-sm-3 control-label" for="hargaredesignbyr">Redesign Bangunan</label>
                                    <div class="col-sm-4 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargaredesignbyr" disabled></div>
                                    <div class="col-sm-5"><input type="text" class="form-control mask_decimal change-total" name="hargaredesign" id="hargaredesign"></div>
                                </div></div>
                                <div class="form-group no-gutter bloktambahkw"><div class="col-md-12">
                                    <label class="col-sm-3 control-label" for="hargatambahkwbyr">Penambahan Kwalitas</label>
                                    <div class="col-sm-4 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargatambahkwbyr" disabled></div>
                                    <div class="col-sm-5"><input type="text" class="form-control mask_decimal change-total" name="hargatambahkwalitas" id="hargatambahkwalitas"></div>
                                </div></div>
                                <div class="form-group no-gutter bloktambahkontruksi"><div class="col-md-12">
                                    <label class="col-sm-3 control-label" for="hargakerjatambahbyr">Penambahan Kontruksi</label>
                                    <div class="col-sm-4 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargakerjatambahbyr" disabled></div>
                                    <div class="col-sm-5"><input type="text" class="form-control mask_decimal change-total" name="hargapekerjaantambah" id="hargapekerjaantambah"></div>
                                </div></div>
                                </div> <!-- end of blok kpr -->
                                <div class="form-group no-gutter bloktunai"><div class="col-md-12">
                                    <label class="col-sm-3 control-label" for="totalangsuranbyr">Harga Tunai</label>
                                    <div class="col-sm-4 hidden-xs"><input type="text" class="form-control mask_decimal" id="totalangsuranbyr" disabled></div>
                                    <div class="col-sm-5"><input type="text" class="form-control mask_decimal change-total" name="totalangsuran" id="totalangsuran"></div>
                                </div></div>
                                <!-- <div class="clearfix margin-bottom-10"> </div> -->
                                <div class="col-md-offset-3 col-md-9"><hr style="border: none; border-bottom: 1px solid #1BBC9B;"></div>

                                <div class="form-group no-gutter"><div class="col-md-12">
                                    <div class="col-sm-3 control-label"><span class="label label-info" for="totaloff">TOTAL</span></div>
                                    <div class="col-sm-4 hidden-xs"><input type="text" class="form-control mask_decimal" id="totalbyr" disabled></div>
                                    <div class="col-sm-5"><input type="text" class="form-control mask_decimal" name="total" id="total" readonly></div>
                                </div></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancel</button>
                    <button type="submit" class="btn red btn-outline" form="form_batal">Process</button>
                </div>
            </div>
        </div>
    </div>

    <div id="row_akad" class="modal fade draggable-modal" role="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="padding:15px 30px; background-color: #32C5D2; color: white; text-align: center; font-size: 30px;">
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> -->
                    <h4 class="modal-title" style="font-size: 30px;">Akad Jual Beli</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                    <div class="col-md-6">
                        <div class="row static-info">
                            <div class="col-md-4 col-sm-4 name">No. Booking</div>
                            <div class="col-md-8 col-sm-8 value" id="nopesanan">-</div>
                            <div class="col-md-12 col-sm-12 margin-top-10">
                                <address  style="margin-bottom: 0"></address>
                            </div>
                        </div>    
                    </div>
                    <div class="col-md-6"  style="margin-bottom: 1px">
                        <div class="row static-info">
                            <div class="col-md-4 col-sm-5 name">Tanggal</div>
                            <div class="col-md-8 col-sm-7 value" id="tgltransaksi">-</div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-4 col-sm-5 name">Kavling</div>
                            <div class="col-md-8 col-sm-7 value" id="kavling">-</div>
                        </div>
                        <div class="row static-info">    
                            <div class="col-md-4 col-sm-5 name">Plafon KPR</div>
                            <div class="col-md-5 col-sm-7 mask_decimal value" id="plafonkprinfo">-</div>
                        </div>
                        <div class="row static-info">
                            <div class="col-md-4 col-sm-5 name">Harga Total</div>
                            <div class="col-md-5 mask_decimal value" id="totaltransaksi">0</div>
                        </div>
                    </div>
                    </div> <!-- end of row -->
                    <hr style="margin-top: 0; padding: 0; border: none; border-bottom: 1px solid #1BBC9B;">
                    <input type="hidden" name="plafonkpr" id="plafonkpr" disabled>
                    
                    <!-- <form action="" method="post" rules="form" id="form_akad" class="form-horizontal"> -->
                    <form action="" method="post" role="form" id="form_akad" class="form-horizontal">
                        <div class="form-body">
                            <input type="hidden" name="noid" id="noid">
                            <input type="hidden" name="nokavling" id="nokavling">
                            <!-- <input type="hidden" name="retensikpr" id="retensikpr">
                            <input type="hidden" name="realisasikpr" id="realisasikpr"> -->
                            <div class="form-group">
                                <input type="hidden" name="tglakad" id="tglakad">
                                <label class="col-md-2 col-sm-2  control-label" for="dptglakad">Tgl. Akad</label>
                                <div class="col-md-4 col-sm-3"> 
                                    <div class="input-group date date-picker" id = "dptglakad">
                                        <input class="form-control" type="text"value="" name="tglakadkredit" id="tglakadkredit" data-date-start-date="+0d" disabled required/>
                                        <span class="input-group-btn">
                                            <button class="btn default" type="button">
                                                <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="blok_akadkpr">
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="retensikpr">Nilai Retensi
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-3">
                                        <!-- <input type="text" class="form-control mask_decimal change-total" name="retensikpr" id="retensikpr" readonly> -->
                                        <input type="text" class="form-control text-right bold change-total mask_decimal"  name="retensikpr" id="retensikpr" placeholder="0.00" readonly >
                                    </div>
                                    <label class="col-md-2 col-sm-2 control-label" for="accbankretensi">Acc Bank</label>
                                    <div class="col-md-5 col-sm-5">
                                        <select class="selectpicker form-control required" id="accbankretensi" name="accbankretensi" data-size=8 data-style="btn-default" required>
                                            <option value="" data-value="" data-content="Select from list..."></option>
                                            <?php echo $optionbank ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="realisasikpr">Pencairan KPR
                                        <span class="required"> * </span>
                                    </label>
                                    <div class="col-md-3">
                                        <!-- <input type="text" class="form-control mask_decimal change-total" name="realisasikpr" id="realisasikpr"  readonly> -->
                                        <input type="text" class="form-control text-right bold change-total mask_decimal"  name="realisasikpr" id="realisasikpr" placeholder="0.00" readonly>
                                    </div>
                                    <label class="col-md-2 col-sm-2 control-label" for="accbankkpr">Acc Bank</label>
                                    <div class="col-md-5 col-sm-5">
                                        <select class="selectpicker form-control required" id="accbankkpr" name="accbankkpr" data-size=8 data-style="btn-default" required>
                                            <option value="" data-value="" data-content="Select from list..."></option>
                                            <?php echo $optionbank ?>
                                        </select>
                                    </div>
                                </div>
                            </div> <!-- end of blok_akadkpr -->
                        </div>
                    </form>
                    <!-- <div class="margin-top-20"></div> -->
                    
                    <div class="form_rincian blok_akadkpr">
                        <hr style="margin-top: 0; padding: 0; border: none; border-bottom: 1px solid #1BBC9B;">
                        <label class="col-md-2 control-label" for="cbbankrincian">Rincian Retensi</label>
                        <div class="col-md-6 col-sm-5">
                            <select class="selectpicker form-control required" id="cbbankrincian" name="cbbankrincian" data-size=8 data-style="btn-default" required>
                                <option value="" data-value="" data-content="Select from list..."></option>
                                <?php echo $optionbankretensi ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <!-- <input type="text" class="form-control mask_decimal" name="nilaiKPR" id="nilaiKPR"> -->
                            <input type="text" class="form-control mask_decimal" name="nilaikprdetail" id="nilaikprdetail">
                        </div>
                        <button type="button" class="add btn btn-icon-only green"><i class="fa fa-arrow-down fa-2x"></i></button>
                        <div class="table-container table-responsive">
                            <table class="display table table-striped table-bordered" cellspacing="0" cellpadding="3" width="100%" id="table_rincianakad">
                                <thead>
                                    <tr role="row" class="heading">
                                        <th width="5%">CUT</th>
                                        <th width="5%">#</th>
                                        <th width="30%">Account</th>
                                        <th width="40%">Description</th>
                                        <th width="20%">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <tr><td>1</td><td>1-001510</td><td>Bank BNI</td><td>1.000.012</td></tr>
                                    <tr><td>1</td><td>1-001310</td><td>Bank Mandiri</td><td>800.500</td></tr>
                                    <tr><td>1</td><td>1-001520</td><td>Bank BCA</td><td>1.250.000</td></tr> -->
                                </tbody>
                                <tfoot>
                                    <tr role="row" class="footer">
                                        <th colspan ="4" class="dt-head-right">TOTAL</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div> <!-- end of form rincian -->
                </div> <!-- end of modal-body -->
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-outline" form="form_akad">Process</button>
                </div>
            </div>
        </div>
    </div>

    
    
</body>
