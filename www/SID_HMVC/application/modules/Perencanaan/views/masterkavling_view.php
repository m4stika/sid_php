<script src="<?php echo base_url(); ?>assets/pages/scripts/grid_dropdown.js" type="text/javascript"> </script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/masterkavling.js" type="text/javascript"></script>              
<script src="<?php echo base_url(); ?>assets/pages/scripts/modal-reposition.js" type="text/javascript"></script>
<!-- END HEAD -->
        <!-- BEGIN CONTAINER -->
			
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    
					<!-- BEGIN THEME PANEL -->
                    <?php //$this->load->view('Template/theme_panel'); // include("theme_panel.php"); ?>

                    <!-- END THEME PANEL -->
					
                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="<?php echo base_url(); ?>">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <a href="#">Perencanaan</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Master Kavling</span>
                            </li>
                        </ul>
                        <?php $this->load->view('Template/page_toolbar') ?>
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h3 class="page-title"> Perencanaan 
                        <small>Master Kavling</small>
                    </h3>
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
					<div class="m-heading-1 border-green m-bordered">
                        <h3>Uraian Master Kavling</h3>                        
                        <p> </p>
                    </div>                    
					
					<div class="row" id="row_browsekavling"><div class="col-md-12">
                        <!-- Begin: life time stats 
                        <div class="portlet light portlet-fit portlet-datatable bordered"> -->
						
						<div class="portlet box green"> 
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="icon-settings font-white"></i>
                                    <span class="caption-subject font-white">Browse Master Kavling</span>
                                </div>
                                <?php $this->load->view('Template/export_tools');?>
                            </div>
                            <div class="portlet-body">
                               <!-- <div class="table-container"> -->
							   <div class="table-container">
									<div class="table-toolbar">
                                        <button type="button" class="new btn btn-icon-only green"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></button>
                                        <button type="button" class="edit btn btn-icon-only blue" disabled><i class="fa fa-edit fa-2x"></i></button>
                                        <button type="button" class="copy btn btn-icon-only purple-plum" disabled><i class="fa fa-copy fa-2x" aria-hidden="true"></i></button>
                                        <button type="button" class="delete btn btn-icon-only red-mint" disabled><i class="fa fa-trash-o fa-2x"></i></button>
                                        <button type="button" class="export btn btn-icon-only green-dark"><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i></button>
                                   </div>
                                   
                                    <table class="table table-striped table-bordered table-hover" id="table_masterkavling">
                                        <thead>
                                            <tr role="row" class="heading">
												<th rowspan=2 width="5%" class="rowspan-center"> #&nbsp;Actions </th>
												<th colspan=5 width="60%" class="text-center"> Data Umum </th>
												<th colspan=3 width="20%" class="text-center"> Luas Bangunan </th>
												<th colspan=3 width="20%" class="text-center"> Posisi Bangunan </th>
                                                <th rowspan=2 width="15%" class="rowspan-center"> Status </th>
												<!-- <th rowspan=2 width="15%" class="rowspan-center"> Status </th> -->
											</tr>
											<tr role="row" class="heading">
                                                <th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
												<!-- <th> Actions </th> -->
                                                <!-- <th> NoID </th>
                                                <th> Blok </th>
                                                <th> No&nbsp;Kavling </th>
                                                <th width="30%"> Keterangan </th>
												<th> Type&nbsp;Rumah </th>
												<th> LT </th>
                                                <th> LB </th>
												<th> KLT </th>
												<th> Sudut </th>
												<th> Hadap&nbsp;Jln </th>
												<th> Fasum </th> -->
                                                <!-- <th width="8%"> st </th> -->
                                                <!-- <th> Status </th> -->
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
								</div>
                               <!-- </div> -->
                            </div> <!-- end of portlet body -->
                        </div> <!-- end of portlet -->
                    </div> <!-- end of col-md -->
                    </div> <!-- end of row_browsekavling -->

                    <div class="row" id="row_kavlingform" style="display: none;">
                    	<?php $this->load->view('Perencanaan/kavling_form') ?>
                    </div> 
					
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
			
			<div class="row" id="form_delete" style="display: none;">
			<!--<div id="delete" class="modal modal-message modal-danger fade" style="display: none;" aria-hidden="true"> -->
				<div class="col-md-12">
					<div class="portlet box red">
						<div class="portlet-title">
							<div class="caption">Anda Yakin Mau Menghapus Data ?</div>
						</div>
						
						<div class="portlet-body">
						<form id="form_delete_body" role="form" class="form-horizontal">
    						<div class="form-body">	
    							<div class="form-group form-md-line-input">
    								<label class="col-md-4 control-label" for="noid">No. ID</label>								
    								<div class="col-md-4"> <p class="form-control-static" id="noid"></p> </div>
    							</div>
    							<div class="form-group form-md-line-input">
    								<label class="col-md-4 control-label" for="blok">Blok</label>
    								<div class="col-md-4"> <p class="form-control-static" id="blok"></p> </div>
    							</div>
    							<div class="form-group form-md-line-input">
    								<label class="col-md-4 control-label" for="nokavling">No. Kavling</label>
    								<div class="col-md-4"> <p class="form-control-static" id="nokavling"></p> </div>
    							</div>
    							<div class="form-group form-md-line-input">
    								<label class="col-md-4 control-label" for="typerumah">Type Rumah</label>
    								<div class="col-md-4"> <p class="form-control-static" id="typerumah"></p> </div>
    							</div>
    							<div class="form-group form-md-line-input">
    								<label class="col-md-4 control-label" for="status">Status</label>
    								<div class="col-md-4" id="status"> </div>
    							</div>
    						</div>
						</form>
						</div>
					</div>
				</div>
			</div>			
					