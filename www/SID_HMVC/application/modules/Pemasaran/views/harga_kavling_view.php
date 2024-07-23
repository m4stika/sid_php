    <head>
        <script src="<?php echo base_url(); ?>assets/pages/scripts/table-hargakavling-ajax.js" type="text/javascript"></script>        
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
                                <span>Harga Kavling</span>
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
                        <small>Harga Kavling</small>
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
                                        <span class="caption-subject font-white">Browse Harga Kavling</span>
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
													<th width="20%" colspan=5 class="text-center"> Data Kavling </th>
													<th width="40%" colspan=8 class="text-center"> Harga Standard </th>
													<th width="20%" colspan=4 class="text-center"> Harga Tambahan </th>
													<th width="8%" rowspan=2  class="rowspan-center"> TOTAL HARGA </th>
													<th width="10%" rowspan=2 class="rowspan-center text-center"> Action </th>
												</tr>

												<tr role="row" class="heading">
                                                   <!-- <th width="2%">
                                                        <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                                            <input type="checkbox" class="group-checkable" data-set="#sample_2 .checkboxes" />
                                                            <span></span>
                                                        </label> 
                                                    </th> -->      													
													<th > Noid </th>
                                                    <th > blok </th>
                                                    <th > No&nbsp;Kav. </th>
                                                    <th > Type </th>
													<th > Status </th>													
													<th > Harga&nbsp;Jual </th>
                                                    <th > Diskon </th>
													<th > Alasan&nbsp;Disc </th>
													<th > Booking&nbsp;Fee </th>
													<th > Plafon&nbsp;KPR </th>
													<th > KLT&nbsp;(M&sup2)</th>
													<th > Hrg&nbsp;KLT&nbsp;/M&sup2</th>
                                                    <th > Tot.&nbsp;Hrg&nbsp;KLT&nbsp;(M&sup2)</th>
													<th > Hrg&nbsp;Sudut </th>
													<th > Alasan&nbsp;Disc </th>
                                                    <th > Hrg&nbsp;Hadap&nbsp;Jln </th>
                                                    <th > Hrg&nbsp;Fasum </th>
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
    </body>
