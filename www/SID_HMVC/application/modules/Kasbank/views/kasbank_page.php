        <script src="<?php echo base_url(); ?>assets/global/plugins/datatables/dataTables.pageResize.min.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
        <script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/pages/scripts/my-toastr.js" type="text/javascript"></script>
        

    <!-- END HEAD -->
    <script type="text/javascript">
         (function(original) {
            parseInt = function() {
                return original.apply(window, arguments) || 0;
            };
        })(parseInt);
    </script>

   <!--  <style type="text/css">
        
        #resize_wrapper {
            position: relative;
            height: 520px;
            padding: 0.5em 0.5em 1.5em 0.5em;
            border: 1px solid #aaa;
            border-radius: 0.5em;
            background-color: #f9f9f9;
        }

        #resize_handle {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1.5em;
            border-bottom-right-radius: 0.5em;
            border-bottom-left-radius: 0.5em;
            text-align: center;
            font-size: 0.8em;
            line-height: 1.5em;
            background-color: #f4645f;
            color:#FFF;
            cursor: pointer;
        }

        table.dataTable th,
        table.dataTable td {
            white-space: nowrap;
        }

        div.dataTables_length {
            display: none;
        }
    </style> -->
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
                                <a href="#">Kas & Bank</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span><?php echo ucfirst($content); //if($content == 'cash') {echo "Cash";} else {echo "Bank";} ?></span>
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
