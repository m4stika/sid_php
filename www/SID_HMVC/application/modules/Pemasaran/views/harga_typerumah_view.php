    <head>
        <script src="<?php echo base_url(); ?>assets/pages/scripts/table-hargatyperumah-edit-ajax.js" type="text/javascript"></script>        
	</head>						
    <!-- END HEAD -->

    <body>
                    
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    
					<!-- BEGIN THEME PANEL -->                    
                    <?php $this->load->view('Template/theme_panel');?>
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
                                <span>Harga Type Rumah</span>
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
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h3 class="page-title"> Pemasaran 
                        <small>Harga Type Rumah</small>
                    </h3>
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->
					<div class="m-heading-1 border-green m-bordered">
                        <h3>Uraian</h3>						
                        <p> </p>
                        <p> </p>
                    </div>                    
					
					<div class="row">
                        <div class="col-md-12">
                            <!-- Begin: life time stats 
                            <div class="portlet light portlet-fit portlet-datatable bordered"> -->
							
							<div class="portlet box green"> 
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-white"></i>
                                        <span class="caption-subject font-white">Browse Harga Type Rumah</span>
                                    </div>
                                    <?php $this->load->view('Template/export_tools');?>
                                </div>
                                <div class="portlet-body">
                                   <!-- <div class="table-container"> -->
								   <div class="table-container">
										<div class="table-actions-wrapper">
                                            <span> </span>
                                            <!--
											<select class="table-group-action-input form-control input-inline input-small input-sm">
                                                <option value="">Select...</option>
                                                <option value="Cancel">Cancel</option>
                                                <option value="Cancel">Hold</option>
                                                <option value="Cancel">On Hold</option>
                                                <option value="Close">Close</option>
                                            </select> -->
											<div data-toggle="tooltip" data-container="body" data-placement="left" data-original-title="tambah data baru">
                                            <button class="btn btn-sm green table-group-action-submit">
                                                <i class="fa fa-plus"></i> New Item</button>
											</div>
                                        </div>
										
                                        <table class="table table-striped table-bordered table-hover" id="sample_editable_1">										
                                            <thead>
										  
											  <tr role="row" class="heading">
													<th width="2%" rowspan=2 class="rowspan-center"> # </th>
													<th width="20%" colspan=4 class="text-center"> Type Rumah </th>
													<th width="40%" colspan=5 class="text-center"> Harga Dasar </th>
													<th width="20%" colspan=3 class="text-center"> Posisi Bangunan </th>
													<th width="8%" rowspan=2  class="rowspan-center"> Total </th>
													<th width="10%" rowspan=2 class="rowspan-center text-center"> Action </th>
												</tr>

												<tr role="row" class="heading">
                                                   <!-- <th width="2%">
                                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                            <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" />
                                                            <span></span>
                                                        </label> 
                                                    </th> -->      													
													<th > NoID </th>
                                                    <th > Type&nbsp;Rumah </th>
                                                    <th > LB </th>
													<th > LT </th>
													<th > HPP </th>
													<th > Harga&nbsp;Jual </th>
													<th > Booking&nbsp;Fee </th>
													<th > UM </th>
													<th > Plafon&nbsp;KPR </th>
													<th > Sudut </th>
													<th > Jalan </th>
													<th > Fasos(um) </th>
													
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
                                                <?php// echo $dataTable ?>
                                            </tbody>
                                        </table>
									</div>
                                   <!-- </div> -->
                                </div>
                            </div>
                            <!-- End: life time stats -->
                        </div>
                    </div>
					
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
			
			<div class="modal fade" id="delete" tabindex="-1" role="basic" aria-hidden="true"> 
			<!--<div id="delete" class="modal modal-message modal-danger fade" style="display: none;" aria-hidden="true"> -->
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Delete this entry</h4>
						</div>
						<div class="modal-body"> 
							<div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn dark btn-outline" data-dismiss="modal">No</button>
							<button type="button" class="btn red" id="delete_yes"> Yes </button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			
			<div class="row"  id="form_sample_1"  style="display: none;">
				<div class="col-md-12">
				<!-- BEGIN VALIDATION STATES-->
				<div class="portlet box green">
					<div class="portlet-title">
						<div class="caption">
							<i class="icon-equalizer font-white-sunglo"></i>
							<span class="caption-subject font-white-sunglo bold uppercase">Type Rumah</span>
							<span class="caption-helper font-white-sunglo">Edit Form</span>
						</div>						
					</div>
					<div class="portlet-body">
						<!-- BEGIN FORM-->
						<form action="" method = "post" id="edittyperumahform" role="form" class="form-horizontal">
							<div class="form-body">																	
								<div class="alert alert-danger display-hide"></div>
								<div class="form-group form-md-line-input has-error">										
									<label class="col-md-3 control-label" for="noid">No. ID</label>
									<div class="col-md-9">
										<input type="text" name="noid" id="noid" readonly class="form-control">
										<div class="form-control-focus"> </div>
										<span class="help-block">No ID Type Rumah</span>											
									</div>
								</div>

								<div class="form-group form-md-line-input">									
									<label class="col-md-3" for="typerumah">Type Rumah</label>
									<div class="col-md-9">
										<input type="text" name="typerumah" id="typerumah" class="form-control">
										<div class="form-control-focus"> </div>
										<span class="help-block">masukkan type rumah</span>										
									</div>
								</div>
								<div class="form-group form-md-line-input">
									<label class="col-md-3" for="keterangan">Keterangan</label>
									<div class="col-md-9">
										<input type="text" name="keterangan" id="keterangan" class="form-control">
										<div class="form-control-focus"> </div>
										<span class="help-block"> contoh: Type rumah blok xx</span>									
									</div>
								</div>								
								<div class="form-group form-md-line-input">
									<label class="col-md-3" for="luasbangunan">Luas bangunan</label>
									<div class="col-md-9">
										<input type="text" name="luasbangunan" id="luasbangunan" class="form-control">
										<div class="form-control-focus"> </div>
										<span class="help-block"> msukkan luas bangunan</span>
									</div>
								</div>
								<div class="form-group form-md-line-input">
									<label class="col-md-3" for="luastanah">Luas Tanah</label>
									<div class="col-md-9">
										<input type="text" name="luastanah" id="luastanah" class="form-control">
										<div class="form-control-focus"> </div>
										<span class="help-block"> msukkan luas tanah</span>									
									</div>
								</div>	
							</div>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-3 col-md-9">
										<button type="submit" class="btn green" name="submitbtn" id="submitbtn" >Submit</button>
										<button type="button" class="btn default" data-dismiss="modal">Cancel</button>
									</div>
								</div>
							</div>
						</form>
						<!-- END FORM-->
					</div>
				</div>
				<!-- END VALIDATION STATES-->
			</div>
    </body>
