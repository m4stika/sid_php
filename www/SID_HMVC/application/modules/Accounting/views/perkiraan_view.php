<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-treetable/jquery.treetable.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>assets/global/plugins/jquery-treetable/css/jquery.treetable.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/global/plugins/jquery-treetable/css/jquery.treetable.theme.default.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>assets/global/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/pages/scripts/my-toastr.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/perkiraan.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/perkiraan_browse.js" type="text/javascript"></script>

<div class="row-perkiraan margin-top-10">
	<div class="portlet light">
		<!-- <div class="portlet-title tabbable-line"> -->
		<div class="portlet-title">
			<div class="caption">
				<i class="icon-book-open font-yellow-crusta sbold icon-lg"></i>
				<span class="caption-subject sbold">Perkiraan</span>
				<em class="hidden-xs small" id="pemesantitle"> | Browse </em>
			</div>
			<div class="actions btn-set">
				<button type="button" class="btn btn-secondary-outline back" style="display: none"><i class="fa fa-arrow-left"></i>Back</button>
				<button type="button" class="btn btn-secondary-outline reset" ><i class="fa fa-reply"></i>Reset</button>
				<button type="button" disabled class="btn btn-success save"><i class="fa fa-save"></i>Extract</button>
				<button type="button" class="btn btn-warning print" value="0"><i class="fa fa-print"></i>Print</button>
			</div>
		</div>
		<div class="portlet-body">
			<div class="table-container">
				<div class="alert alert-block" style="display: none">
					<button type="button" class="close"></button>
					<h4 class="alert-heading"></h4>
					<p></p>
				</div>
				<div class="table-toolbar">
		            <button type="button" value="0" class="new btn btn-icon-only green" disabled><i class="fa fa-plus fa-2x"></i></button>
		            <button type="button" value="1" class="edit btn btn-icon-only blue" disabled><i class="fa fa-edit fa-2x"></i></button>
		            <button type="button" value="2" class="copy btn btn-icon-only purple-plum" disabled><i class="fa fa-copy fa-2x"></i></button>
		            <button type="button" class="delete btn btn-icon-only red-mint" disabled><i class="fa fa-trash-o fa-2x"></i></button>
		            <button type="button" class="reload btn btn-icon-only green"><i class="fa fa-refresh fa-2x"></i></button>
		       </div>
				<table id="table_listperkiraan"> <!-- class="table table-bordered table-striped"> -->
				    <!-- <caption>
				      <a href="#" onclick="jQuery('#example-basic').treetable('expandAll');  return false;">Expand all</a>
				      <a href="#" onclick="jQuery('#example-basic').treetable('collapseAll'); return false;">Collapse all</a>
				    </caption> -->
				    <thead>
				      <tr>
				        <th>Account</th>
				        <th>Description</th>
				        <th>Group</th>
				        <th>Class</th>
				        <th class="right">Opening</th>
				        <th class="right">Debet</th>
				        <th class="right">Credit</th>
				        <th class="right">Balance Due</th>
				      </tr>
				    </thead>
				    <tbody></tbody>
				</table>
			</div> <!-- end of table-container -->
		</div> <!-- end of portlet-body -->
	</div> <!-- end of portlet -->
</div>

<div id="row-perkiraanform" class="modal fade draggable-modal" role="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- <div class="modal-header" style="padding:15px 30px; background-color: #32C5D2; color: white; text-align: center; font-size: 30px;">
                    <h4 class="modal-title" style="font-size: 30px;">Akad Jual Beli</h4>
                </div> -->
                <div class="modal-body">
                	<div class="portlet light bordered">
                		<div class="portlet-title">
                			<div class="caption">
                				<i class="icon-book-open font-yellow-crusta sbold icon-lg"></i>
                                <span class="caption-subject bold"> Perkiraan |</span>
                                <span class="caption-helper">New</span>
                			</div>
                			<div class="tools">
                				<span class="bold" id="current-balance"> Current Balance </span>
                			</div>
                		</div>
                		<div class="portlet-body form">
                			<form action="#" class="form-horizontal" id="form-perkiraan">
                				<div class="form-body">
                					<div class="form-group">
                						<label class="col-md-3 control-label" for="parentacc">Parent Account</label>
                						<div class="col-md-9" id="parentacc">
                						<!-- <input type="text-align" class="form-control" name="parentacc" id="parentacc" disabled> --> </div>
                					</div>
                					<div class="form-group">
                						<label class="col-md-3 control-label" for="groupacc">Group Account</label>
                						<div class="col-md-6">
	                						<select class="selectpicker form-control required" id="groupacc" name="groupacc" data-size=8 data-style="btn-default" required>
	                                            <option value="" data-value="" data-content="Select from list..."></option>
	                                            <?php echo $listGroup ?>
	                                        </select>
                						</div>
                						<div class="col-md-3">
                						<label class="control-label left bold" id="balancesheetacc">Ballance Sheet</label>
                						</div>
                					</div>
                					<div class="form-group">
                						<label class="col-md-3 control-label" for="classacc">Class Account</label>
                						<div class="col-md-6">
	                						<select class="selectpicker form-control" name="classacc" id="classacc" data-size=8 data-style="btn-default" required readonly>
	                                            <option value="0" data-value="0" data-content="HEADER"></option>
	                                            <option value="1" data-value="1" data-content="Detail"></option>
	                                            <option value="2" data-value="2" data-content="Detail Kas-Bank"></option>
	                                        </select>
                						</div>
                					</div>
                					<div class="form-group">
                						<label class="col-md-3 control-label" for="accountno">Account #
                							<span class="required"> * </span>
                						</label>
                						<div class="col-md-4"><input type="text-align" class="form-control" name="accountno" readonly> </div>
                						<div class="input-group">
		                                    <div class="icheck-inline">
		                						<label>
		                                            <input type="checkbox" name="autonumber" id="autonumber" value="1" checked class="icheck" data-radio="icheckbox_flat-green"> Autonumber
		                                        </label>
		                                    </div>
			                            </div>
                					</div>
                					<div class="form-group">
                						<label class="col-md-3 control-label" for="description">Description
                							<span class="required"> * </span>
                						</label>
                						<div class="col-md-9"><input type="text-align" class="form-control" name="description"> </div>
                					</div>
                					<div class="form-group">
			                            <label class="col-md-3 control-label" for="penerimaan">Debit(Credit)</label>
			                            <div class="col-md-9">
			                                <div class="input-group">
			                                    <div class="icheck-inline">
			                                        <label>
			                                            <input type="radio" name="debitacc" id="debit" value="1" checked class="icheck" data-radio="iradio_flat-green"> Debit </label>
			                                        <label>
			                                            <input type="radio" name="debitacc" id="credit" value="0" class="icheck" data-radio="iradio_flat-green"> (Credit) </label>
			                                    </div>
			                                </div>
			                            </div>
			                        </div>
                				</div>
                				<div class="form-actions fluid">
                					<button type="button" class="test btn dark btn-outline">Test</button>
                					<button type="button" data-dismiss="modal" class="cancel btn dark btn-outline">Cancel</button>
                    				<button type="submit" class="btn btn-success btn-outline">Process</button>  
                    				<!-- value="validate" form="form-perkiraan" -->
                				</div>
                			</form>
                		</div> <!-- end of portlet-body -->
                	</div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancel</button>
                    <button type="submit" class="btn btn-success btn-outline" form="">Process</button>
                </div> -->
            </div>
        </div>
</div> <!-- end of row_akad -->