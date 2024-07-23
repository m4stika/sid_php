<head>
    <script src="<?php echo base_url(); ?>assets/pages/scripts/grid_dropdown.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/pages/scripts/masterdoc.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/pages/scripts/modal-reposition.js" type="text/javascript"></script>
</head>
<body>
        <!-- BEGIN CONTAINER -->
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->

                    <!-- BEGIN PAGE BAR -->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="#">Home</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <a href="#">Perencanaan</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Master Dokumen dan Progress</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE BAR -->
                    <!-- BEGIN PAGE TITLE-->
                    <h3 class="page-title"> Pemasaran
                        <small>Master Dokumen dan Progress</small>
                    </h3>
                    <!-- END PAGE TITLE-->
                    <!-- END PAGE HEADER-->

                   <!--  <div class="m-heading-1 border-green m-bordered">
                        <h3>Uraian</h3>                     
                        <p> </p>
                        <p> </p>
                    </div>    -->

					<div class="row" id="wrapper">
                        <div class="col-md-7 col-sm-12" id="row_masterdoc">
							<div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-white"></i>
                                        <span class="caption-subject font-white">Master Dokumen</span>
                                    </div>
                                    <?php $this->load->view('Template/export_tools');?>
                                </div>
                                <div class="portlet-body">
								   <div class="table-container">
										<div class="table-toolbar">
                                            <button type="button" value="0" class="new btn btn-icon-only green"><i class="fa fa-plus fa-2x"></i></button>
                                            <button type="button" value="1" class="edit btn btn-icon-only blue" disabled><i class="fa fa-edit fa-2x"></i></button>
                                            <button type="button" value="2" class="copy btn btn-icon-only purple-plum" disabled><i class="fa fa-copy fa-2x"></i></button>
                                            <button type="button" class="delete btn btn-icon-only red-mint" disabled><i class="fa fa-trash-o fa-2x"></i></button>
                                            <button type="button" class="reload btn btn-icon-only green"><i class="fa fa-refresh fa-2x"></i></button>
                                       </div>
                                    
                                        <table class="table table-striped table-bordered table-hover" id="datatable_doc">
                                            <thead>
                                                <tr role="row" class="heading">
                                                    <th width="5%" rowspan=2 class="rowspan-center"> Action </th>
                                                    <th width="40%" colspan=2 class="text-center"> Data Dokumen </th>
                                                    <th width="40%" colspan=4 class="text-center"> Peruntukan </th>
                                                </tr>
                                                <tr role="row" class="heading">
                                                    <th></th><th></th><th></th><th></th><th></th><th></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
									</div> <!-- table-container -->
                                </div> <!-- portlet-body -->
                            </div> <!-- portlet box green -->
                        </div>

                        <div class="col-md-5 col-sm-12" id="row_masterprogress">
                            <div class="portlet box green-jungle">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-white"></i>
                                        <span class="caption-subject font-white">Master Progress</span>
                                    </div>
                                    <?php $this->load->view('Template/export_tools');?>
                                </div>
                                <div class="portlet-body">
                                   <div class="table-container">
                                        <div class="table-toolbar">
                                            <button type="button" value="0" class="new btn btn-icon-only green"><i class="fa fa-plus fa-2x"></i></button>
                                            <button type="button" value="1" class="edit btn btn-icon-only blue" disabled><i class="fa fa-edit fa-2x"></i></button>
                                            <button type="button" value="2" class="copy btn btn-icon-only purple-plum" disabled><i class="fa fa-copy fa-2x"></i></button>
                                            <button type="button" class="delete btn btn-icon-only red-mint" disabled><i class="fa fa-trash-o fa-2x"></i></button>
                                            <button type="button" class="reload btn btn-icon-only green"><i class="fa fa-refresh fa-2x"></i></button>
                                       </div>
                                        <table class="table table-striped table-bordered table-hover" id="datatable_progress">
                                            <thead>
                                                <tr role="row" class="heading">
                                                    <th></th><th></th><th></th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div> <!-- table-container -->
                                </div> <!-- portlet-body -->
                            </div> <!-- portlet box green -->
                        </div> <!-- end of col-md-6 -->


                    </div> <!-- end of row -->

                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->

			<div class="row" id="form_delete" style="display: none;">
            <!--<div id="delete" class="modal modal-message modal-danger fade" style="display: none;" aria-hidden="true"> -->
                <div class="col-md-12">
                    <!-- BEGIN VALIDATION STATES-->
                    <div class="portlet box red">
                        <div class="portlet-title">
                            <div class="caption">Anda Yakin Mau Menghapus Data ?</div>
                        </div>

                        <div class="portlet-body">
                        <form id="form_delete_body" role="form" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label" for="noid">No. ID</label>
                                <div class="col-md-9"> <p class="form-control-static" id="noid"></p> </div>
                            </div>
                            <div class="form-group form-md-line-input">
                                <label class="col-md-3 control-label" for="namadoc">Nama</label>
                                <div class="col-md-9"> <p class="form-control-static" id="namadoc"></p> </div>
                            </div>
                        </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>

			<div class="row"  id="form_edit"  style="display: none;">
				<div class="col-md-12">
				<!-- BEGIN VALIDATION STATES-->
				    <div class="portlet box green">
    					<div class="portlet-title">
    						<div class="caption">
    							<i class="icon-equalizer font-white-sunglo"></i>
    							<span class="caption-subject font-white-sunglo bold uppercase">Master Dokumen | </span>
    							<span class="caption-helper font-white">Edit Form</span>
    						</div>
    					</div>
    					<div class="portlet-body">
    						<!-- BEGIN FORM-->
    						<form action="" method = "post" id="form_edit_body" role="form" class="form-horizontal">
    							<div class="form-body">
    								<div class="alert alert-danger display-hide"></div>
    								<div class="form-group form-md-line-input has-error">
    									<label class="col-md-3 control-label" for="noid">No. ID</label>
    									<div class="col-md-2">
    										<input type="text" name="noid" id="noid" readonly class="form-control">
    										<div class="form-control-focus"> </div>
    										<span class="help-block">No ID Dokumen</span>                                            
    									</div>
    								</div>

    								<div class="form-group form-md-line-input">
    									<label class="col-md-3 control-label" for="namadokumen">Nama Dokumen</label>
    									<div class="col-md-9">
    										<input type="text" name="namadokumen" id="namadokumen" class="form-control">
    										<div class="form-control-focus"> </div>
    										<span class="help-block">masukkan nama dokumen</span>
    									</div>
    								</div>


                                    <div class="form-group form-md-checkboxes">
                                        <label class="col-md-3 control-label" for="form_control_1">Peruntukan</label>
                                        <div class="col-md-9">
                                            <div class="md-checkbox-list">
                                                <div class="md-checkbox">
                                                    <input type="checkbox" name="check_list[]" value="1" id="umum" class="md-check">
                                                    <label for="umum">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Umum
                                                    </label>
                                                </div>

                                                <div class="md-checkbox">
                                                    <input type="checkbox" name="check_list[]" value="2" id="pegawai" class="md-check">
                                                    <label for="pegawai">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Pegawai </label>
                                                </div>
                                                <div class="md-checkbox">
                                                    <input type="checkbox" name="check_list[]" value="3" id="profesional" class="md-check">
                                                    <label for="profesional">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Profesional </label>
                                                </div>
                                                <div class="md-checkbox">
                                                    <input type="checkbox" name="check_list[]" value="4" id="wiraswasta" class="md-check">
                                                    <label for="wiraswasta">
                                                        <span></span>
                                                        <span class="check"></span>
                                                        <span class="box"></span> Wiraswasta </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>

    							<div class="form-actions">
    								<div class="row">
    									<div class="col-md-offset-3 col-md-9">
    										<button type="submit" class="btn green" name="status" id="submitbtn" >Submit</button>
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
		    </div>

            <div class="row"  id="form_edit_Progres"  style="display: none;">
                <div class="col-md-12">
                <!-- BEGIN VALIDATION STATES-->
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-equalizer font-white-sunglo"></i>
                                <span class="caption-subject font-white-sunglo bold uppercase">Master Progress | </span>
                                <span class="caption-helper font-white">Edit Form</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <!-- BEGIN FORM-->
                            <form action="" method = "post" id="form_edit_Progres_body" role="form" class="form-horizontal">
                                <div class="form-body">
                                    <div class="alert alert-danger display-hide"></div>
                                    <div class="form-group form-md-line-input has-error">
                                        <label class="col-md-4 control-label" for="noid">No. ID</label>
                                        <div class="col-md-2">
                                            <input type="text" name="noid" id="noid" readonly class="form-control">
                                            <div class="form-control-focus"> </div>
                                            <span class="help-block">masukkan No ID</span>
                                        </div>
                                    </div>

                                    <div class="form-group form-md-line-input">
                                        <label class="col-md-4 control-label" for="namaprogres">Keterangan Progress</label>
                                        <div class="col-md-8">
                                            <input type="text" name="namaprogres" id="namaprogres" class="form-control">
                                            <div class="form-control-focus"> </div>
                                            <span class="help-block">masukkan Keterangan Progress</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button type="submit" class="btn green" name="status" id="submitbtn" >Submit</button>
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
            </div>
</body>