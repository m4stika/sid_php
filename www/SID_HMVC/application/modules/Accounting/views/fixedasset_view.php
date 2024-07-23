<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/form-input-mask.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/fixedasset.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/modal-reposition.js" type="text/javascript"></script>              

<div class="margin-top-10" id="row_fixedasset">
	<div class="portlet light">
		<!-- <div class="portlet-title tabbable-line"> -->
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-cubes font-yellow"></i>
				<span class="caption-subject font-dark sbold">Fixed Asset</span>
				<em class="hidden-xs small"> | Browse </em>
			</div>
			<?php $this->load->view('Template/export_tools');?>                                    
			<!-- <div class="actions btn-set">
				<button type="button" class="btn btn-secondary-outline back" style="display: none"><i class="fa fa-arrow-left"></i>Back</button>
				<button type="button" class="btn btn-secondary-outline reset" ><i class="fa fa-reply"></i>Reset</button>
				<button type="button" disabled class="btn btn-success save"><i class="fa fa-save"></i>Assign</button>
				<button type="button" class="btn btn-warning print" value="0"><i class="fa fa-print"></i>Print</button>
			</div> -->
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
				<table class="table table-striped table-bordered table-hover" id="table_fixedasset">
					<thead>
						<tr role="row" class="heading">
							<th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th><th></th>
						</tr>
						
					</thead>
					<tbody></tbody>
				</table>
				<!-- <div id="resize_handle">Drag to resize</div> -->
			</div>
		</div> <!-- end of portlet-body -->
	</div> <!-- end of portlet light -->

	<!-- <div id="row_penyusutan" style="display: none;">
		<div class="table-container table-responsive"> -->
			<table class="table detail" id="table_penyusutan">
				<thead>
					<tr role="row" class="flat">
						<th></th><th></th><th></th><th></th><th></th>
					</tr>
				</thead>
				<tbody></tbody>
				<tfoot>
					<tr role="row" class="footer">
						<th colspan ="3" class="dt-head-right"></th>
						<th></th>
						<th></th>
					</tr>
				</tfoot>
			</table>
		<!-- </div>
	</div>  --><!-- end of jurnal-view -->

	<div id="row_aktivaform" class="modal fade draggable-modal" role="modal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg">
            <div class="modal-content">`
                <div class="modal-body">
                	<div class="portlet light bordered">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-cubes font-yellow"></i>
								<span class="caption-subject sbold">Fixed Asset | </span>
								<span class="caption-helper"> | New </span>
							</div>
							<div class="actions">
								<label class="bold" id="noid">-1</label>
							</div>
						</div>
						<div class="portlet-body">
							<form action="" method = "post" id="aktivaform" role="form" class="form-horizontal">
							<!--  onSubmit="{event => event.preventDefault()}">  -->
							<!-- onsubmit="return false;"> -->
							<div class="form-body">	
								<div class="form-group form-md-input no-gutter">
									<label class="col-md-3 control-label" for="namaaktiva">Nama Aktiva</label>
									<div class="col-md-9">
										<input type="text" name="namaaktiva" id="namaaktiva" class="form-control">
									</div>
								</div>
								<div class="form-group form-md-input no-gutter">
									<label class="col-md-3 control-label" for="bulanperolehan">BL-TH Perolehan</label>
									<div class="col-md-4">
										<select class="form-control selectpicker bulan" data-size=6 data-style="btn-success" name="bulanperolehan">
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control selectpicker tahun" data-size=6 data-style="btn-danger" name="tahunperolehan">
										</select>
									</div>
								</div>
								<div class="form-group form-md-input no-gutter">
									<label class="col-md-3 clearfix control-label" for="harga">Harga Perolehan</label>
									<div class="col-md-3"> 
										<input type="text" name="harga" id="harga" class="form-control  mask_decimal"> 
										<label class="pull-right control-label" for="harga">harga</label>
									</div>
									<div class="col-md-3"> 
										<input type="text" name="qty" id="qty" class="form-control  text-right touchspin"> 
										<label class="pull-right control-label" for="qty">qty</label> 
									</div>
									<div class="col-md-3"> 
										<input type="text" name="totalharga" id="totalharga" class="form-control bold  mask_decimal" readonly> 
										<label class="pull-right bold control-label" for="totalharga">Total</label> 
									</div>
								</div>
								<div class="form-group form-md-input no-gutter">
									<label class="col-md-3 control-label" for="usiaekonomis">Usia Ekonomis</label>
									<div class="col-md-3">
										<input type="text" name="usiaekonomis" id="usiaekonomis" value="1" class="form-control touchspin">
									</div>
									<label class="col-md-1 caption" for="usiaekonomis">Bulan</label>
								</div>
								<div class="form-group form-md-input no-gutter">
									<label class="col-md-3 control-label" for="harga">Penyusutan</label>
									<div class="col-md-3"> 
										<input type="text" name="penyusutanbulan_I" id="penyusutanbulan_I" class="form-control mask_decimal1" readonly> 
										<label class="pull-right control-label" for="penyusutanbulan_I">Bulan 1</label>
									</div>
									<div class="col-md-3"> 
										<input type="text" name="penyusutanbulan_II" id="penyusutanbulan_II" class="form-control mask_decimal1" readonly>  
										<label class="pull-right control-label" for="penyusutanbulan_II">Bulan 2, dst</label> 
									</div>									
								</div>
								<div class="form-group form-md-input no-gutter">
									<label class="col-md-3 control-label" for="bulansusut">Mulai disusutkann</label>
									<div class="col-md-4">
										<select class="form-control selectpicker bulan" data-size=6 data-style="btn-default" name="bulansusut">
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control selectpicker tahun" data-size=6 data-style="btn-default" name="tahunsusut">
										</select>
									</div>
								</div>
								<div class="form-group form-md-input no-gutter">
									<label class="col-md-3 control-label" for="akumpenyusutan">Akum. Penyusutan</label>
									<div class="col-md-3">
										<input type="text" name="akumpenyusutan" id="akumpenyusutan" class="form-control mask_decimal" readonly>
									</div>
								</div>
								<div class="form-group form-md-input no-gutter">
									<label class="col-md-3 control-label" for="nilaibuku">Nilai Buku</label>
									<div class="col-md-3">
										<input type="text" name="nilaibuku" id="nilaibuku" class="form-control mask_decimal" readonly>
									</div>
								</div>
								<hr style="border: none; border-bottom: 1px solid #1BBC9B;">
								<div class="form-group form-md-input no-gutter">
									<label class="col-md-3 control-label" for="accaktiva">Link Account Aktiva</label>
									<div class="col-md-3">
										<input type="text" name="accaktiva" id="accaktiva" class="form-control" readonly>
									</div>
									<div class="col-md-6">
										<div class="input-group">
											<input type="text" name="accaktivadesc" id="accaktivadesc" class="form-control" readonly>
											<span class="input-group-btn">
	                                            <button type="button" class="btn btn-icon-only green modal-account"><i class="fa fa-search"></i></button>
	                                        </span>
										</div>
									</div>
								</div>
								<div class="form-group form-md-input no-gutter">
									<label class="col-md-3 control-label" for="accakumulasi">Link Akumulasi Peny.</label>
									<div class="col-md-3">
										<input type="text" name="accakumulasi" id="accakumulasi" class="form-control" readonly>
									</div>
									<div class="col-md-6">
										<div class="input-group">
											<input type="text" name="accakumulasidesc" id="accakumulasidesc" class="form-control" readonly>
											<span class="input-group-btn">
	                                            <button type="button" class="btn btn-icon-only green modal-account"><i class="fa fa-search"></i></button>
	                                        </span>
										</div>
									</div>
								</div>
								<div class="form-group form-md-input no-gutter">
									<label class="col-md-3 control-label" for="akunbiaya">Link Biaya Peny.</label>
									<div class="col-md-3">
										<input type="text" name="akunbiaya" id="akunbiaya" class="form-control" readonly>
									</div>
									<div class="col-md-6">
										<div class="input-group">
											<input type="text" name="akunbiayadesc" id="akunbiayadesc" class="form-control" readonly>
											<span class="input-group-btn">
	                                            <button type="button" class="btn btn-icon-only green modal-account"><i class="fa fa-search"></i></button>
	                                        </span>
										</div>
									</div>
								</div>
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
	</div> <!-- end of row_aktivaform -->

	<div id="row_linkaccount" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Select Account</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
							<label class="col-md-3 control-label" for="linkaccount">Account</label>
							<div class="col-md-9">
								<select class="form-control selectpicker" data-live-search="true" data-size=10 data-style="btn-default" id="linkaccount">
								<?php echo $linkaccount; ?>
								</select>
							</div>
						</div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn dark btn-outline ok">Get This</button>  
                </div>
            </div>
        </div>
    </div>
</div> <!-- end of row_fixedasset -->	

