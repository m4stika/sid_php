<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/kasbank_extract.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/modal-reposition.js" type="text/javascript"></script>              

<div class="row_extract margin-top-10">
	<div class="portlet light">
		<!-- <div class="portlet-title tabbable-line"> -->
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-money font-dark"></i>
				<span class="caption-subject font-dark sbold">Jurnal</span>
				<em class="hidden-xs small" id="pemesantitle"> | Extract </em>
			</div>
			<div class="actions btn-set">
				<button type="button" class="btn btn-secondary-outline back" style="display: none"><i class="fa fa-arrow-left"></i>Back</button>
				<button type="button" class="btn btn-secondary-outline reset" ><i class="fa fa-reply"></i>Reset</button>
				<button type="button" disabled class="btn btn-success save"><i class="fa fa-save"></i>Extract</button>
				<button type="button" class="btn btn-warning print" value="0"><i class="fa fa-print"></i>Print</button>
			</div>
		</div>
		<div class="portlet-body">
	        <!-- <input type="text" name="actionflag" id="actionflag" value="1"> -->
	        <div class="info"></div>
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
				<table class="table table-striped table-bordered table-hover table-checkable" id="table_extract">
					<thead>
						<tr role="row" class="heading">
							<th></th>
							<th width="8%">ID</th>
							<th>Type</th>
							<th>Tanggal</th>
							<th>No. Jurnal</th>
							<th width="30%">Account</th>
							<th>Total</th>
						</tr>
						<tr role="row" class="filter">                                                    
	                        <td></td>
	                        <td><input type="text" class="form-control form-filter input-sm" name="noid"> </td>
	                        <td>
	                            <select name="extracttype" id="extracttype" class="form-control form-filter input-sm">
	                                <option value="0">Select..</option>
	                                <option value="1">Peneriman Pembayaran</option>
	                                <option value="2">Batal Bayar</option>
	                                <option value="3">Akad Jual Beli</option>
	                                <option value="4">Pembatalan Kontrak</option>
	                                <!-- <option value="5">Insentif</option> -->
	                            </select>
	                        </td>
	                        <td>
	                            <input type="hidden" name="tglextract" id="tglextract" class="form-control form-filter input-sm">
	                            <input type="hidden" name="tglextractto" id="tglextractto" class="form-control form-filter input-sm">
	                            <input type="text" class="form-control form-filter input-sm date date-picker" placeholder="From" data-date-format="dd/mm/yyyy" id="dttglextractfrom">
	                            <input type="text" class="form-control form-filter input-sm date date-picker" placeholder="To" data-date-format="dd/mm/yyyy" id="dttglextractto">
	                        </td>

	                        <td>
	                            
	                        </td>	

							<td>
		                        <select name="accountno" class="form-control form-filter input-sm">
		                                <option value="">Select...</option>
		                                <?php echo $acckasbank; ?>
		                        </select>
	                        </td>
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
		<div class="table-container table-responsive">
			<table class="table detail" id="table_jurnaldetil">
				<thead>
					<tr role="row" class="flat">
						<!-- <th width="5%">action</th> -->
						<th width="5%">#</th>
						<th width="10%">No. Perkiraan</th>
						<th width="20%">Nama Perkiraan</th>
						<th width="30%">Uraian</th>
						<th width="20%">Nilai</th>
					</tr>
					
				</thead>
				<tbody></tbody>
				<tfoot>
					<tr role="row" class="footer">
						<th colspan ="4" class="dt-head-right"></th>
						<th></th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div> <!-- end of jurnal-view -->
</div> <!-- end of row_cashin -->

