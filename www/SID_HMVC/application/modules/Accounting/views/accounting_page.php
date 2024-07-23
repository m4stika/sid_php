<script src="<?php echo base_url(); ?>assets/global/plugins/datatables/dataTables.pageResize.min.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>

<!-- <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/form-input-mask.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script src="<?php echo base_url(); ?>assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script>
 -->

<!-- END HEAD -->
<script type="text/javascript">
     var parameter_system = <?php echo json_encode($parameter); ?>;
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
                        <a href="#">Accounting</a>
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
