<!-- <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/form-input-mask.js" type="text/javascript"></script> -->
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<!-- <script src="<?php echo base_url(); ?>assets/pages/scripts/journal.js" type="text/javascript"></script> -->
<script src="<?php echo base_url(); ?>assets/pages/scripts/journal-view.js" type="text/javascript"></script>
<!-- <script src="http://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js" type="text/javascript"></script> -->

 <script type="text/javascript">
        jQuery(document).ready(function() {
      	    var content = "<?php Print($content); ?>";
    		(content == 'cash') ? $('#selectrekidbank').selectpicker('hide') : $('#selectrekid').selectpicker('hide');
		});
		var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };
     
 </script>

<div class="margin-top-10" id= "row_journal">
	<div class="info"></div>
	<div class="portlet light">
		<!-- <div class="portlet-title tabbable-line"> -->
		<div class="portlet-title">
			<div class="caption">
				<i class="icon-book-open font-yellow-crusta sbold icon-lg"></i>
				<span class="caption-subject sbold">General Journal | </span>
				<span class="caption-helper"> New </span>
			</div>
			<div class="actions btn-set">
				<button type="button" class="btn btn-secondary-outline back" style="display: none"><i class="fa fa-arrow-left"></i>Back</button>
				<button type="button" class="btn btn-secondary-outline reset" ><i class="fa fa-reply"></i>Reset</button>
				<button type="button" disabled class="btn btn-success save"><i class="fa fa-save"></i>Save</button>
				<button type="button" class="btn btn-warning print" value="0"><i class="fa fa-print"></i>Print</button>
			</div>
		</div>
		<div class="portlet-body">
	        <div class="tabbable-line">
	        <ul class="nav nav-tabs nav-tabs-lg">
	            <li class="active" id="detil">
	                <a href="#tab_transaksi" data-toggle="tab"> Detail </a>
	            </li>
	            <li id="history">
	                <a href="#tab_history" data-toggle="tab"> History </a>
	            </li>
	        </ul>
	        <div class="tab-content">
	        	<div class="tab-pane active" id="tab_transaksi">
	        		<form action="" method="post" role="form" id="journal-form" class="form-horizontal">
	        			<div class="form-body">
	        			<div class="row"> 
	        			<div class="col-md-10">
	        				<div class="form-group">
	                            <label class="col-md-2 control-label" for="journalno">Journal #
	                            	<span class="required"> * </span>
	                            </label>
	                            <div class="col-md-3"><span class='label bg-yellow-gold bg-font-yellow-gold' id="groupdescription"></span>
	                            <input class="form-control" type="text" name="journalno" id="journalno">
	                            </div>
	                            </label>
	                            <div class="pull-right">Actual Book
	                            	<span class="label label-success label-lg" id="blth">10-2017</span>
	                            </div>
	                        </div>

	        				<div class="form-group">
        						<input type="hidden" name="journaldate" id="journaldate" >
								<label class="col-md-2 control-label" for="tgljurnal">Journal Date
									<span class="required"> * </span>
								</label>
		                        <div class="col-md-3"> 
		                            <div class="input-group date date-picker" id = "dptgljurnal">
		                                <input class="form-control" type="text" value="" name="tgljurnal" id="tgljurnal" data-date-start-date="+0d" readonly/>
		                                <span class="input-group-btn">
		                                    <button class="btn default" type="button">
		                                        <i class="fa fa-calendar"></i>
		                                    </button>
		                                </span>

		                            </div>
		                        </div>
		                    </div>
	        				<div class="form-group">
                                <label class="col-md-2 control-label">Memo:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-10">
                                    <textarea rows="4" class="form-control" name="remark"></textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                            	<input class="form-control" type="hidden" name="totaltransaksi" id="totaltransaksi">
                            	<div class="table-container table-responsive">
				        			<table class="table table-striped table-hover table-condensed" id="table_jurnaldetail">
				        				<thead>
				        					<tr role="row" class="heading">
				        						<th width="5%">Action</th>
				        						<th width="5%">#ID</th>
				        						<th width="10%">Acc #</th>
				        						<th width="25%">Description</th>
				        						<th width="25%">Remark</th>
				        						<th width="15%">Debit</th>
				        						<th width="15%">Credit</th>
				        					</tr>
				        					
				        				</thead>
				        				<tbody></tbody>
				        				<tfoot>
				        					<tr role="row" class="footer">
				        						<th colspan ="5" class="dt-head-right">TOTAL</th>
				        						<th></th>
				        						<th></th>
				        					</tr>
				        				</tfoot>
				        			</table>
				        		</div>
				        	</div>
				        </div></div> <!-- end of row col-md -->
	        			</div> <!-- end of form-body -->
	        		</form>
	        	</div> <!-- end of tab_transaksi -->

	        	<div class="tab-pane" id="tab_history">
	        		<div class="table-container" id="resize_wrapper">
	        			<!-- <div class="info"></div> -->
	        			<div class="table-toolbar">
                                <button type="button" class="new btn btn-icon-only green"><i class="fa fa-plus fa-2x"></i></button>
                                <button type="button" class="edit btn btn-icon-only blue" disabled><i class="fa fa-edit fa-2x"></i></button>
                                <button type="button" class="copy btn btn-icon-only purple-plum" disabled><i class="fa fa-copy fa-2x"></i></button>
                                <button type="button" class="delete btn btn-icon-only red-mint" disabled><i class="fa fa-trash-o fa-2x"></i></button>
                                <button type="button" class="export btn btn-icon-only green-dark"><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i></button>
                        </div>
	        			<table class="table table-striped table-bordered table-hover" id="table_history_jurnal">
	        				<thead>
	        					<tr role="row" class="heading">
	        						<th>#</th>
	        						<th width="5%">ID</th>
	        						<th>Status</th>
	        						<th  width="15%">Journal-date</th>
	        						<th>Journal #</th>
	        						<th width="35%">Remark</th>
	        						<th>Amount</th>
	        						
	        					</tr>
	        					<tr role="row" class="filter">                                                    
                                    <td></td>
                                    <td><input type="text" class="form-control form-filter input-sm" name="journalid"> </td>
                                    <td>
                                        <select name="status" class="form-control form-filter input-sm">
                                            <option value="">status verifikasi</option>
                                            <option value="1">Open</option>
                                            <option value="2">Kasir</option>
                                            <option value="3">Keuangan</option>
                                            <option value="4">Pimpinan</option>
                                            <option value="5">Closed</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" name="GL_tgljournal" id="GL_tgljournal" class="form-control form-filter input-sm">
                                        <input type="hidden" name="GL_tgljournalto" id="GL_tgljournalto" class="form-control form-filter input-sm">
                                        <input type="text" class="form-control form-filter input-sm date date-picker" placeholder="From" data-date-format="dd/mm/yyyy" id="tglhistoryfrom">
                                        <input type="text" class="form-control form-filter input-sm date date-picker" placeholder="To" data-date-format="dd/mm/yyyy" id="tglhistoryto">
                                    </td>

                                    <td>
                                        <select name="GL_journalGroup" class="form-control form-filter input-sm">
                                            <option value="">Select...</option>
                                            <option value="1">Opening Ballance</option>
                                            <option value="2">General Journal</option>
                                            <option value="3">Akad Jual-Beli</option>
                                            <option value="4">Inventory</option>
                                            <option value="5">Kas-Bank</option>
                                            <option value="6">Fixed Asset</option>
                                            <option value="7">Pembatalan</option>
                                            <option value="8">Tunai</option>
                                            <option value="9">Other</option>
                                        </select>
                                    </td>
                                    <td></td>
                                    <td><div><button class="btn btn-sm green btn-outline filter-submit margin-bottom"><i class="fa fa-search"></i> Search</button></div>
                                    	<div class="margin-top-10"><button class="btn btn-sm red btn-outline filter-cancel"><i class="fa fa-times"></i> Reset</button></div>
                                    </td>
									
									
                                </tr>
	        				</thead>
	        				<tbody></tbody>
	        			</table>
	        			<!-- <div id="resize_handle">Drag to resize</div> -->
	        		</div>
	        	</div>
	        </div> <!-- end of Tab-content -->
	        </div> <!-- end of TAB -->
		</div> <!-- end of portlet-body -->
	</div> <!-- end of portlet light -->
</div> <!-- end of row_cashin