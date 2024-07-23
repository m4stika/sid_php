<script src="<?php echo base_url(); ?>assets/pages/scripts/grid_dropdown.js" type="text/javascript"> </script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/typerumah.js" type="text/javascript"> </script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/modal-reposition.js" type="text/javascript"></script>

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
                    <a href="<?php echo base_url(); ?>">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">Perencanaan</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Type Rumah</span>
                </li>
            </ul>
            <?php $this->load->view('Template/page_toolbar') ?>

        </div>
        <!-- END PAGE BAR -->

        <!-- BEGIN PAGE TITLE-->
        <div id="browse_typerumah">
            <h3 class="page-title"> Perencanaan 
                <small>Type Rumah</small>
            </h3>
            <div class="info"></div>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
			<!-- <div class="m-heading-1 border-green m-bordered">
                <h3>Uraian Type Rumah</h3>						
                <p> </p>
                <p> </p>
            </div>   -->                  
			
			<div class="row"><div class="col-md-12">
                <div class="portlet box green"> 
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-settings font-white"></i>
                            <span class="caption-subject font-white">Browse Type Rumah</span>
                        </div>
                        <?php $this->load->view('Template/export_tools');?>                                    
                    </div>
                    <div class="portlet-body">
					   <div class="table-container">
							<div class="table-toolbar">
                                <button type="button" class="new btn btn-icon-only green"><i class="fa fa-plus fa-2x"></i></button>
                                <button type="button" class="edit btn btn-icon-only blue" disabled><i class="fa fa-edit fa-2x"></i></button>
                                <button type="button" class="copy btn btn-icon-only purple-plum" disabled><i class="fa fa-copy fa-2x"></i></button>
                                <button type="button" class="delete btn btn-icon-only red-mint" disabled><i class="fa fa-trash-o fa-2x"></i></button>
                                <button type="button" class="export btn btn-icon-only green-dark"><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i></button>
                           </div>
                            <table class="table table-striped table-bordered table-hover" id="table_typerumah">
                                <thead>
                                    <tr role="row" class="heading">
                                        <th width="10%"> #&nbsp;Actions </th>
                                        <th width="5%"> NoID </th>
                                        <th width="30%"> Type&nbsp;Rumah </th>
                                        <th width="35%"> Keterangan </th>
										<th width="10%"> Luas&nbsp;Bangunan </th>
										<th width="10%"> Luas&nbsp;Tanah </th>
                                    </tr>
                                    <tr role="row" class="filter">                                                    
										<td></td>
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm" name="noid"> </td>
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm" name="typerumah"></td>
                                        <td>
                                            <input type="text" class="form-control form-filter input-sm" name="keterangan"> </td>
                                        <td>
                                            <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                                <i class="fa fa-search"></i> Search</button>
                                        </td>    
										<td><button class="btn btn-sm red btn-outline filter-cancel"><i class="fa fa-times"></i> Reset</button></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
						</div> <!-- end of table container -->
                    </div> <!-- end of portlet-body -->
                </div> <!-- end of portlet -->
            </div></div> <!-- end of row -->
		</div> <!-- end of Browsetyperumah -->

        <div class="row"  id="row_typerumah"  style="display: none;">
            <?php 
                $this->load->view('Perencanaan/typerumah_form')
            ?>
        </div> <!-- end of row Typerumah -->
        
    </div>
    <!-- END page-content -->
</div>
<!-- END page-content-wrapper -->
			