<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/form-input-mask.js" type="text/javascript"></script>
<!-- <script src="<?php echo base_url(); ?>assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script> -->

<script type="text/javascript">
         (function(original) {
            parseInt = function() {
                return original.apply(window, arguments) || 0;
            };
        })(parseInt);
</script>

<!-- <div class="col-md-12"> -->
	<!-- BEGIN VALIDATION STATES-->
	<div class="portlet portlet light portlet-fit">
		<div class="portlet-title">
			<div class="caption">
				<i class="icon-equalizer font-green"></i>
				<span class="caption-subject font-green bold uppercase">Master Kavling</span>
				<span class="caption-helper font-blue-chambray">Edit Form</span>
			</div>						
		</div>
		<div class="portlet-body">
			<!-- BEGIN FORM-->
			<form action="" method = "post" id="kavlingform" role="form" class="form-horizontal">
				<div class="form-body">																									
				<div class="row">
				<div class="col-md-6">
					<div class="portlet box blue-hoki">
						<div class="portlet-title"><div class="caption"><span>Data Type Rumah</span></div>
							<div class="actions"><label class="bold" id="label_idtyperumah">-1</label></div>
						</div>
						<div class="portlet-body">
							<div class="form-group">
								<label class="col-md-4 control-label" for="selecttyperumah">Type Rumah</label>
								<div class="col-md-8">
									<input type="hidden" name="idtyperumah" id="idtyperumah" class="form-control">
		                            <input type="hidden" name="status" id="status" class="form-control">                                             
									<select class="form-control selectpicker" data-size=10 data-style="btn-danger" id="selecttyperumah">
		                                <?php echo $options ?>
									</select>
								</div>
							</div>
							<div class="form-group form-md-input">
								<div class="col-md-6">
									<label for="luastanah">Luas Tanah (M&sup2)</label>
									<input type="text" name="luastanah" id="luastanah" disabled class="form-control mask_number">
								</div>
								<div class="col-md-6">
									<label for="luasbangunan">Luas bangunan (M&sup2)</label>									
									<input type="text" name="luasbangunan" id="luasbangunan" disabled class="form-control mask_number">		
								</div>
							</div>
							<div class="form-group form-md-input">
								<div class="col-md-6">
									<label class="control-label" for="hargajual">Harga Jual</label>
                                	<input type="text" name="hargajual" id="hargajual" class="form-control mask_decimal" disabled>
								</div>
								<div class="col-md-6">
									<label class="control-label" for="hargasudut">Hrg. Posisi Sudut</label>
                                	<input type="text" name="hargasudut" id="hargasudut" class="form-control mask_decimal" disabled>
								</div>
							</div>
							<div class="form-group form-md-input">
								<div class="col-md-6">
									<label class="control-label" for="hpp">Estimasi HPP</label>
                                	<input type="text" name="hpp" id="hpp" class="form-control mask_decimal" disabled>
								</div>
								<div class="col-md-6">
									<label class="control-label" for="hargahadapjalan">Hrg. Hadap Jalan</label>
                                	<input type="text" name="hargahadapjalan" id="hargahadapjalan" class="form-control mask_decimal" disabled>
								</div>
							</div>
							<div class="form-group form-md-input">
								<div class="col-md-6">
									<label class="control-label" for="plafonkpr">Plafon KPR</label>
                                	<input type="text" name="plafonkpr" id="plafonkpr" class="form-control mask_decimal" disabled>
								</div>
								<div class="col-md-6">
									<label class="control-label" for="hargafasum">Hrg. Fasum(os)</label>
                                	<input type="text" name="hargafasum" id="hargafasum" class="form-control mask_decimal" disabled>
								</div>
							</div>
							<div class="form-group form-md-input">
								<div class="col-md-6">
									<label class="control-label" for="bookingfee">Booking Fee</label>
                                	<input type="text" name="bookingfee" id="bookingfee" class="form-control mask_decimal" disabled>
								</div><div class="col-md-offset-6"></div>
							</div>
							<div class="form-group form-md-input">
								<div class="col-md-6">
									<label class="control-label" for="uangmuka">Uang Muka</label>
                                	<input type="text" name="uangmuka" id="uangmuka" class="form-control mask_decimal" disabled>
								</div>
							</div>
						</div> <!-- end of portlet-body -->
					</div> <!-- end of portlet -->
				</div> <!-- end of col-md- -->

				<div class="col-md-6">
					<div class="portlet box blue-hoki">
						<div class="portlet-title"><div class="caption"><span>Data Kavling</span></div></div>
						<div class="portlet-body">
							<div class="form-group">
								<label class="col-md-offset-5 col-md-4 control-label" for="noid">No. ID</label>
								<div class="col-md-3">
									<input type="text" name="noid" id="noid" readonly class="form-control">
								</div>
							</div>
														
							<div class="form-group form-md-line-input">
								<div class="col-md-6">										
									<label for="blok">Blok</label>
									<input type="text" name="blok" id="blok" class="form-control">	
									<div class="form-control-focus"> </div>
									<span class="help-block">masukkan blok kavling</span>										
								</div>									
								
								<div class="col-md-6">										
									<label for="blok">No. Kavling</label>
									<input type="text" name="nokavling" id="nokavling" class="form-control">
									<div class="form-control-focus"> </div>
									<span class="help-block">masukkan nomor kavling</span>										
								</div>	
								
							</div>
							<div class="form-group form-md-line-input">
								<div class="col-md-4">
									<label for="kelebihantanah">KLT (M&sup2)</label>
									<input type="text" name="kelebihantanah" id="kelebihantanah" class="form-control mask_number change-total">
									<div class="form-control-focus"> </div>
									<span class="help-block"> masukkan Kelebihan tanah</span>									
								</div>
								<div class="col-md-4">
									<label for="hargakltm2">Harga (M&sup2)</label>
									<input type="text" name="hargakltm2" id="hargakltm2" class="form-control mask_decimal change-total">
									<div class="form-control-focus"> </div>
									<span class="help-block"> Harga Kelebihan tanah per meter (M&sup2)</span>									
								</div>
								<div class="col-md-4">
									<label for="hargaklt">TOTAL</label>
									<input type="text" name="hargaklt" id="hargaklt" class="form-control mask_decimal" disabled>
								</div>
							</div>
							<!-- <label class="col-md-3 control-label" for="sudut">Posisi Bangunan</label> -->
							<div class="form-group form-md-checkboxes">
								<label class="col-md-3 control-label" for="sudut">Posisi Bangunan</label>
								<div class="col-md-9">
									<div class="md-checkbox-list">
										<div class="md-checkbox">
											<input type="checkbox" name="check_list[]" value="1" id="sudut" class="md-check change-total">
											<label for="sudut">
												<span></span>
												<span class="check"></span>
												<span class="box"></span> Posisi Sudut </label>
										</div>
										<div class="md-checkbox">
											<input type="checkbox" name="check_list[]" value="2" id="hadapjalan" class="md-check change-total">
											<label for="hadapjalan">
												<span></span>
												<span class="check"></span>
												<span class="box"></span> Menghadap Jalan Utama </label>
										</div>
										<div class="md-checkbox">
											<input type="checkbox" name="check_list[]" value="3" id="fasum" class="md-check change-total">
											<label for="fasum">
												<span></span>
												<span class="check"></span>
												<span class="box"></span> Dekat Fasum/Fasos </label>
										</div>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-offset-4 col-md-3 control-label" for="totalharga">Total harga</label>
								<div class="col-md-5"><input type="text" name="totalharga" id="totalharga" class="form-control mask_decimal" disabled></div>
							</div>
							<div class="form-group">
								<label class="col-md-offset-4 col-md-3 control-label" for="diskon">Discount</label>
								<div class="col-md-5"><input type="text" name="diskon" id="diskon" class="form-control mask_decimal change-total"></div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label" for="alasandiskon">Alasan Discount</label>
								<div class="col-md-9"><input type="text" name="alasandiskon" id="alasandiskon" class="form-control"></div>
							</div>
							
						</div> <!-- end of portlet-body -->
					</div> <!-- end of portlet -->
				</div> <!-- end of col-md- -->
				</div> <!-- end of row -->
				</div> <!-- end of form-body -->
				<div class="form-actions">
					<div class="row">
						<div class="col-md-offset-9 col-md-3">
							<!-- <div class=""> -->
							<button type="submit" class="col-md-5 btn btn-outline green" name="submitbtn" id="submitbtn" >Save</button>
							<div class="col-md-2"></div>
							<button type="button" class="col-md-5 btn btn-outline dark" data-dismiss="modal">Close</button>
							<!-- </div> -->
						</div>
					</div>
				</div>
			</form>
		</div> <!-- end of portlet-body -->
	</div> <!-- end of portlet -->
<!-- </div> --> <!-- end of col-md -->	