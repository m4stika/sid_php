<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/kasbank_assign.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/modal-reposition.js" type="text/javascript"></script>              

<div class="row_assign margin-top-10">
	<div class="portlet light">
		<!-- <div class="portlet-title tabbable-line"> -->
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-money font-dark"></i>
				<span class="caption-subject font-dark sbold">Jurnal</span>
				<em class="hidden-xs small" id="pemesantitle"> | Assign </em>
			</div>
			<div class="actions btn-set">
				<button type="button" class="btn btn-secondary-outline back" style="display: none"><i class="fa fa-arrow-left"></i>Back</button>
				<button type="button" class="btn btn-secondary-outline reset" ><i class="fa fa-reply"></i>Reset</button>
				<button type="button" disabled class="btn btn-success save"><i class="fa fa-save"></i>Assign</button>
				<button type="button" class="btn btn-warning print" value="0"><i class="fa fa-print"></i>Print</button>
			</div>
		</div>
		<div class="portlet-body">
	        <div class="table-container">
				<!-- <div class="info"></div> -->
				<!-- <div class="table-toolbar">
	                    <button type="button" class="new btn btn-icon-only green"><i class="fa fa-plus fa-2x"></i></button>
	                    <button type="button" class="edit btn btn-icon-only blue" disabled><i class="fa fa-edit fa-2x"></i></button>
	                    <button type="button" class="copy btn btn-icon-only purple-plum" disabled><i class="fa fa-copy fa-2x"></i></button>
	                    <button type="button" class="delete btn btn-icon-only red-mint" disabled><i class="fa fa-trash-o fa-2x"></i></button>
	                    <button type="button" class="export btn btn-icon-only green-dark"><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i></button>
	            </div> -->
	            <div class="table-actions-wrapper">
                    <span class="bold"> </span>
                   <!--  <select class="table-group-action-input form-control input-inline input-small input-sm">
                        <option value="">Select...</option>
                        <option value="Cancel">Cancel</option>
                        <option value="Cancel">Hold</option>
                        <option value="Cancel">On Hold</option>
                        <option value="Close">Close</option>
                    </select> -->
                    <!-- <button class="btn btn-sm green table-group-action-submit">
                        <i class="fa fa-check"></i> Assign</button> -->
                </div>
				<table class="table table-striped table-bordered table-hover table-checkable" id="table_jurnalassign">
					<thead>
						<tr role="row" class="heading">
							<th>
								<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                    <span></span>
                                </label>
							</th>
							<th width="8%">ID</th>
							<th>Status</th>
							<th>Tanggal</th>
							<th>No. Kasbank</th>
							<th width="30%">Account</th>
							<th>Total</th>
							<th width="5%">View</th>
						</tr>
						<tr role="row" class="filter">                                                    
	                        <td></td>
	                        <td><input type="text" class="form-control form-filter input-sm" name="noid"> </td>
	                        <td>
	                            <select name="statusverifikasi1" class="form-control form-filter input-sm">
	                                <option value="">status verifikasi</option>
	                                <option value="1">Open</option>
	                                <option value="2">Kasir</option>
	                                <option value="3">Keuangan</option>
	                                <option value="4">Pimpinan</option>
	                                <option value="5">Closed</option>
	                            </select>
	                        </td>
	                        <td>
	                            <input type="hidden" name="tgltransaksi" id="tgltransaksi" class="form-control form-filter input-sm">
	                            <input type="hidden" name="tgltransaksito" id="tgltransaksi1" class="form-control form-filter input-sm">
	                            <input type="text" class="form-control form-filter input-sm date date-picker" placeholder="From" data-date-format="dd/mm/yyyy" id="tglhistoryfrom">
	                            <input type="text" class="form-control form-filter input-sm date date-picker" placeholder="To" data-date-format="dd/mm/yyyy" id="tglhistoryto">
	                        </td>

	                        <td>
	                            <select name="kasbanktype1" class="form-control form-filter input-sm">
	                                <option value="">Select...</option>
	                                <option value="1">Cash-IN</option>
	                                <option value="2">Cash-OUT</option>
	                                <option value="3">Bank-IN</option>
	                                <option value="4">Bank-OUT</option>
	                            </select>
	                        </td>	

							<td>
		                        <select name="accountno" class="form-control form-filter input-sm">
		                                <option value="">Select...</option>
		                                <?php echo $acckasbank; ?>
		                        </select>
	                        </td>
	                        <td></td>
	                        <td>
                                <div class="margin-bottom-5">
                                    <button class="btn btn-sm green btn-outline filter-submit margin-bottom">
                                        <i class="fa fa-search"></i> Search</button>
                                </div>
                                <button class="btn btn-sm red btn-outline filter-cancel">
                                    <i class="fa fa-times"></i> Reset</button>
                            </td>
							                                                            
	                        <!-- <td><button class="btn btn-sm green btn-outline filter-submit margin-bottom"><i class="fa fa-search"></i> Search</button></td>
							<td><button class="btn btn-sm red btn-outline filter-cancel"><i class="fa fa-times"></i> Reset</button></td> -->
	                    </tr>
					</thead>
					<tbody></tbody>
				</table>
				<!-- <div id="resize_handle">Drag to resize</div> -->
			</div>
		</div> <!-- end of portlet-body -->
	</div> <!-- end of portlet light -->
	<div id="jurnal_view" style="display: none;">
		<div class="portlet box green">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-money"></i>
					<span class="caption-subject sbold">Jurnal</span>
					<em class="hidden-xs small" id="pemesantitle"> | View </em>
				</div>
			</div>
			<div class="portlet-body">
				<input type="hidden" name="noid" id="noid">
				<input type="hidden" name="crud" id="crud">
				<div class="row static-info">
					<div class="col-md-2 name">Status</div>
					<div class="col-md-4 value" id="kasbanktype">Kas(IN)</div>
					<div class="col-md-2 name">Tanggal</div>
					<div class="col-md-4 value" id="tgltransaksi">-</div>
				</div>
				<div class="row static-info">
					<div class="col-md-2 name">Nama Bank</div>
					<div class="col-md-10 value" id="accountno">-</div>
				</div>
				<div class="row static-info">
					<div class="col-md-2 name">No. Bukti</div>
					<div class="col-md-4 value" id="nobukti">-</div>
					<div class="col-md-2 name">No. Cek/BG</div>
					<div class="col-md-4 value" id="nomorcek">-</div>
				</div>
				<div class="row static-info">
					<div class="col-md-2 name">Uraian</div>
					<div class="col-md-6 value" id="uraian"  style="whitespace:wrap">-</div>
				</div>
				<!-- <div class="row"> <div class="col-md-12"> -->
				<div class="table-container table-responsive">
        			<table class="table table-striped table-hover table-condensed" id="table_jurnalKB">
        				<thead>
        					<tr role="row" class="heading">
        						<th width="5%">action</th>
        						<th width="5%">#ID</th>
        						<th width="10%">No. Perkiraan</th>
        						<th width="20%">Nama Perkiraan</th>
        						<th width="45%">Uraian</th>
        						<th width="15%">Nilai</th>
        					</tr>
        					
        				</thead>
        				<tbody></tbody>
        				<tfoot>
        					<tr role="row" class="footer">
        						<th colspan ="5" class="dt-head-right">TOTAL</th>
        						<th></th>
        					</tr>
        				</tfoot>
        			</table>
        		<!-- </div></div> -->
        		</div>
				<!-- <hr>
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-check"></i>Close</button> -->
			</div>
			<!-- <div class="portlet-footer">
				
			</div> -->
		</div> <!-- end of portlet -->
	</div> <!-- end of jurnal-view -->
</div> <!-- end of row_cashin -->

