        <script src="<?php echo base_url(); ?>assets/global/plugins/datatables/dataTables.pageResize.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/pages/scripts/form-input-mask.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/pages/scripts/my-toastr.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/layouts/layout/css/custom.css" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Vast+Shadow" rel="stylesheet">
        

    <!-- END HEAD -->
    <script type="text/javascript">
        var nokavlingOption = <?php echo json_encode($options); ?>;
        (function(original) {
            parseInt = function() {
                return original.apply(window, arguments) || 0;
            };
        })(parseInt);
    </script>
    
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
                                <a href="#">Pemesanan</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <!-- <span><?php //if($content == 'cash') {echo "Cash";} else {echo "Bank";} ?></span> -->
                                <span><?php if($content == 'pemesanan') {echo "New";} else {echo "";} ?></span>
                            </li>
                        </ul>
                        <?php $this->load->view('Template/page_toolbar') ?>
                    </div>

                    <div id="row_content">
                        <?php 
                            if($pagecontent){
                                $this->load->view($pagecontent);
                            } 
                        ?>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
    </body>
