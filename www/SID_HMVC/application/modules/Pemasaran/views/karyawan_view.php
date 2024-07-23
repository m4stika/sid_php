<script src="<?php echo base_url(); ?>assets/global/plugins/datatables/dataTables.pageResize.min.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/form-input-mask.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/grid_dropdown.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/karyawan.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/modal-reposition.js" type="text/javascript"></script>

<!-- END HEAD -->
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
                    <a href="#">Pemasaran</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <!-- <span><?php //if($content == 'accounting') {echo "New";} else {echo "";} ?></span> -->
                    <span><?php echo $content; ?></span>
                </li>
            </ul>
            <?php $this->load->view('Template/page_toolbar') ?>
        </div>

        <div id="row_content">
        <div class="margin-top-10" id="wrapper_karyawan">
            <div class="portlet light">
                <!-- <div class="portlet-title tabbable-line"> -->
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-users font-green"></i>
                        <span class="caption-subject font-dark sbold">Karyawan</span>
                        <em class="hidden-xs small"> | Browse </em>
                    </div>
                    <?php $this->load->view('Template/export_tools');?>                                         
                </div>
                <div class="portlet-body">
                    <div class="table-container">
                        <div class="info"></div>
                        <div class="table-toolbar">
                                <button type="button" class="new btn btn-icon-only green"><i class="fa fa-plus fa-2x"></i></button>
                                <button type="button" class="edit btn btn-icon-only blue" disabled><i class="fa fa-edit fa-2x"></i></button>
                                <button type="button" class="copy btn btn-icon-only purple-plum" disabled><i class="fa fa-copy fa-2x"></i></button>
                                <button type="button" class="delete btn btn-icon-only red-mint" disabled><i class="fa fa-trash-o fa-2x"></i></button>
                                <button type="button" class="export btn btn-icon-only green-dark"><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i></button>
                        </div>
                        <div class="table-actions-wrapper">
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="table_karyawan">
                            <thead>
                                <tr role="row" class="heading">
                                    <th></th><th></th><th></th><th></th><th></th><th></th><th></th>
                                </tr>
                                
                            </thead>
                            <tbody></tbody>
                        </table>
                        <!-- <div id="resize_handle">Drag to resize</div> -->
                    </div>
                </div> <!-- end of portlet-body -->
            </div> <!-- end of portlet light -->

            <div id="wrapper_form" class="modal fade draggable-modal" role="modal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">`
                        <div class="modal-body">
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-cubes font-yellow"></i>
                                        <span class="caption-subject sbold">Karyawan | </span>
                                        <span class="caption-helper"> | New </span>
                                    </div>
                                    <div class="actions">
                                        <label class="bold" id="noid">-1</label>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <form action="" method = "post" id="karyawanform" role="form" class="form-horizontal">
                                    <!--  onSubmit="{event => event.preventDefault()}">  -->
                                    <!-- onsubmit="return false;"> -->
                                    <div class="form-body"> 
                                        <div class="form-group form-md-input no-gutter">
                                            <label class="col-md-3 control-label" for="jabatan">Group</label>
                                            <div class="col-md-9">
                                                <select class="form-control selectpicker" data-size=6 data-style="btn-default" name="jabatan" id="jabatan">
                                                    <option value="1">Pimpinan</option>
                                                    <option value="2">Accounting</option>
                                                    <option value="3">Kasir</option>
                                                    <option value="4">Marketing</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group form-md-input no-gutter">
                                            <label class="col-md-3 control-label" for="nama">Nama</label>
                                            <div class="col-md-9">
                                                <input type="text" name="nama" id="nama" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group form-md-input no-gutter">
                                            <label class="col-md-3 control-label" for="alamat">Alamat</label>
                                            <div class="col-md-9">
                                                <input type="text" name="alamat" id="alamat" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group form-md-input no-gutter">
                                            <label class="col-md-3 control-label" for="notelp">No. Telp</label>
                                            <div class="col-md-4">
                                                <input type="text" name="notelp" id="notelp" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group form-md-input no-gutter">
                                            <label class="col-md-3 control-label" for="nohp">No. HP</label>
                                            <div class="col-md-4">
                                                <input type="text" name="nohp" id="nohp" class="form-control">
                                            </div>
                                        </div>
                                        <input type="hidden" name="flag" id="flag" class="form-control">
                                        <input type="hidden" name="noid" id="noid" class="form-control">
                                        <!-- <hr style="border: none; border-bottom: 1px solid #1BBC9B;"> -->
                                    </div> <!-- end of form-body -->
                                    <div class="margin-top-20"></div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-offset-9 col-md-3">
                                                <button type="submit" class="col-md-5 btn btn-outline green">Save</button>
                                                <div class="col-md-2"></div>
                                                <button type="button" class="col-md-5 btn btn-outline dark" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                    </form> <!-- end of form -->
                                </div> <!-- end of portlet-body -->
                            </div> <!-- end of portlet -->
                        </div> <!-- end of modal-body -->
                    </div> <!-- end of modal-conten -->
                </div> <!-- end of modal -->
            </div> <!-- end of wrapper_form -->
        </div> <!-- end of wrapper_karyawan --> 
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
</body>
