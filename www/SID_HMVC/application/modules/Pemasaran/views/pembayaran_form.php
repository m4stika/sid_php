<!-- <div id="row_pembayaran" style="display: none;"> -->
<div id="row_pembayaran"> 
<!-- <h3 class="page-title">Form Pembayaran</h3> -->
<?php 
	$noid = (isset($dataparent['id'])) ?  $dataparent['id'] : '';
	$induk = (isset($dataparent['induk'])) ?  $dataparent['induk'] : ''; 
?>
<div class="portlet light portlet-fit bordered">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-money font-dark"></i>
			<!-- <span class="caption-subject font-dark sbold uppercase">Penerimaan Pembayaran -->
			<span class="caption-subject font-dark sbold">Kwitansi</span>
			<em class="hidden-xs small" id="pemesantitle"> | <?php echo $noid; ?> </em>
		</div>
		<div class="actions btn-set">
			<button type="button" class="btn btn-secondary-outline back hidden"><i class="fa fa-arrow-left"></i>Back</button>
			<button type="button" class="btn btn-secondary-outline reset" disabled><i class="fa fa-reply"></i>Reset</button>
			<button type="submit" class="btn btn-success save" form="form_pembayaran" disabled><i class="fa fa-save"></i>Save</button>
			<button type="button" class="btn btn-warning print" value="0"><i class="fa fa-print"></i>Print</button>
				
			<!-- <div class="btn-group btn-group-devided" data-toggle="buttons">
                <label class="btn btn-transparent green btn-outline btn-circle btn-sm active">
                    <input type="radio" name="options" class="toggle" id="option1">Back</label>
                <label class="btn btn-transparent blue btn-outline btn-circle btn-sm">
                    <input type="radio" name="options" class="toggle" id="option2">Save</label>
            </div> -->
		</div>
	</div>
	<div class="portlet-body">
		<div class="info"></div>
		<div class="tabbable-line">
			<ul class="nav nav-tabs nav-tabs-lg">
	            <li class="active" id="detil">
	                <a href="#tab_detil" data-toggle="tab"> Details </a>
	            </li>
	            <li id="history">
	                <a href="#tab_history" data-toggle="tab"> History </a>
	            </li>
	        </ul>
	        <div class="tab-content">
	        	<div class="tab-pane active" id="tab_detil">
	        		<div class="row">
	        			<div class="col-md-6 col-sm-12">
		        			
		        			<label class="col-md-3 control-label" for="cbpemesan">Konsumen</label>
							<div class="col-md-9">
									<select class="form-control selectpicker" data-size=8 data-style="btn-default" id="cbpemesan">
		                                <?php echo $optionpembayaran ?>
									</select>
							</div>
	        			</div>
	        		</div>
	        		<div class="clearfix margin-bottom-10"></div>
	        		<div class="row">
	        			<div class="col-md-6 col-sm-12">
	        				<div class="portlet green-meadow box">
	        					<div class="portlet-title">
		        					<div class="caption">
	                                    <i class="fa fa-cogs"></i>Details Konsumen</div>
	                                <div class="actions">
	                                    <a href="javascript:;" class="btn btn-default btn-sm">
	                                        <i class="fa fa-pencil"></i> Edit </a>
	                                </div>
	                            </div>
	        					<div class="portlet-body">
	        						<div class="row static-info">
	        							<div class="col-md-5 name">Nama</div>
	        							<div class="col-md-7 value" id="namapemesan">-</div>
	        						</div>
	        						<div class="row static-info">
	        							<div class="col-md-5 name">Alamat</div>
	        							<div class="col-md-7 value" id="alamatpemesan">-</div>
	        						</div>
	        						<div class="row static-info">
	        							<div class="col-md-5 name">Telpone/HP</div>
	        							<div class="col-md-7 value" id="telprumahpemesan">-</div>
	        						</div>
	        						<!-- <div class="clearfix margin-bottom-20"></div> -->
	        						<hr style="border: none; border-bottom: 1px solid #1BBC9B;">
	        						<div class="row static-info">
	        							<div class="col-md-5 name">Nama Pasangan</div>
	        							<div class="col-md-7 value" id="namapasangan">-</div>
	        						</div>
	        						<div class="row static-info">
	        							<div class="col-md-5 name">Alamat</div>
	        							<div class="col-md-7 value" id="alamatpasangan">-</div>
	        						</div>
	        						<div class="row static-info">
	        							<div class="col-md-5 name">Telpone/HP</div>
	        							<div class="col-md-7 value" id="telprumahpasangan">-</div>
	        						</div>
	        					</div>
	        				</div>
	        			</div> <!-- end of portlet Detils konsumen -->
	        			<div class="col-md-6 col-sm-12">
	        				<div class="portlet yellow-crusta box">
	        					<div class="portlet-title">
		        					<div class="caption">
	                                    <i class="fa fa-cogs"></i>Details Kavling</div>
	                                <div class="actions">
	                                    <a href="javascript:;" class="btn btn-default btn-sm">
	                                        <i class="fa fa-pencil"></i> Edit </a>
	                                </div>
	                            </div>
	        					<div class="portlet-body">
	        						<!-- <div class="row"><div class="col-md-8 col-sm-12"> -->
		        						<div class="row static-info">
		        							<div class="col-md-5 col-sm-5 name">Kavling</div>
		        							<div class="col-md-7 col-sm-7 value" id="kavling">-</div>
		        						</div>
		        						<!-- <div class="row static-info">
		        							<div class="col-md-5 col-sm-5 name">Luas Tanah</div>
		        							<div class="col-md-7 col-sm-7 value" id="luastanah">0</div>
		        						</div>
		        						<div class="row static-info">
		        							<div class="col-md-5 col-sm-5 name">Luas Bangunan</div>
		        							<div class="col-md-7 col-sm-7 value" id="luasbangunan">0</div>
		        						</div> -->
		        						<div class="row static-info">
		        							<div class="col-md-5 col-sm-5 name">Total Harga</div>
		        							<div class="col-md-3 col-sm-7 mask_decimal value" contenteditable="true" id="hargajual">0</div>
		        						</div>
		        						<div class="row static-info">
		        							<div class="col-md-5 col-sm-5 name">Diskon</div>
		        							<div class="col-md-3 col-sm-7 mask_decimal value" contenteditable="true" id="diskon">0</div>
		        						</div>
		        						<div class="row static-info">
		        							<div class="col-md-5 col-sm-5 name">Booking Fee</div>
		        							<div class="col-md-3 col-sm-7 mask_decimal value" contenteditable="true" id="hrgbookingfee">0</div>
		        						</div>
		        						<div class="row static-info">
		        							<div class="col-md-5 col-sm-5 name">Uang Muka</div>
		        							<div class="col-md-3 col-sm-7 mask_decimal value" contenteditable="true" id="hrguangmuka">0</div>
		        						</div>
		        						<div class="row static-info">
		        							<div class="col-md-5 col-sm-5 name">Plafon KPR</div>
		        							<div class="col-md-3 col-sm-7 mask_decimal value" contenteditable="true" id="hrgplafonkpr">0</div>
		        						</div>
		        						<!-- <div class="clearfix margin-bottom-20"></div> -->
		        						<div class="row static-info">
		        							<div class="col-md-5 col-sm-5 name">Pola Pembayaran</div>
		        							<div class="col-md-7 col-sm-7 value"><span class="label label-primary"  id="polabayar"></span></div>
		        						</div>
	        						<!-- </div></div> -->
	        					</div>
	        				</div>
	        			</div> <!-- end of portlet Detils konsumen -->
	        		</div>
	        		<form action="" method="post" class="form-horizontal" rules="form" id="form_pembayaran">
	        		<div class="form-body">
		        		<div class="well">
		        		<div class="row">
		        			<div class="col-md-5 col-sm-12">
	        					<div class="col-md-2 col-sm-0"></div>
	        					<div class="col-md-10 col-sm-12">
	        					<div class="form-group">
	        						<input type="hidden" name="tglpembayaran" id="tglpembayaran">
									<label class="col-md-4 col-sm-4  control-label" for="tglbayar">Tgl. bayar</label>
			                        <div class="col-md-8 col-sm-8"> 
			                            <div class="input-group date date-picker" id = "dptglbayar">
			                                <input class="form-control" type="text"value="" name="tglbayar" id="tglbayar" data-date-start-date="+0d" readonly/>
			                                <span class="input-group-btn">
			                                    <button class="btn default" type="button">
			                                        <i class="fa fa-calendar"></i>
			                                    </button>
			                                </span>
			                            </div>
			                        </div>
			                    </div>
			                    <div class="form-group">
									<label class="col-md-4 col-sm-4 control-label" for="nobukti">No. Bukti</label>
									<div class="col-md-8 col-sm-8"><input class="form-control" type="nobukti" name="nobukti"></div>
								</div>
								</div>
		        			</div>
		        			
		        			<div class="col-md-7 col-sm-12">
		        				<div class="form-group">
										<label class="col-md-4 col-sm-4 control-label" for="keterangan">Keterangan</label>
										<div class="col-md-8 col-sm-8"><input class="form-control" type="keterangan" name="keterangan"></div>
									</div>
									<div class="form-group">
					        			<label class="col-md-4 col-sm-4 control-label" for="cbbank">Bank Penerima</label>
										<div class="col-md-8 col-sm-8">
											<select class="selectpicker form-control" id="cbbank" name="cbbank" data-size=8 data-style="btn-default">
												<?php echo $optionbank ?>
											</select>
										</div>
			        				</div>
		        			</div> <!-- blank -->
		        			</div>
		        		</div> <!-- end of row -->
	        			<div class="row" id="rincianpembayaran">
		        			<div class="col-md-12"><div class="portlet box grey-cascade">
								<div class="portlet-title"><div class="caption"><i class="fa fa-money"></i>Rincian Pembayaran</div></div>
								<div class="portlet-body">
									<div col-md-12>
										<label class="col-md-offset-2 col-md-3 col-sm-5 hidden-xs control-label" for="bookingfeeoff">Tunggakan</label>
										<label class="col-md-2 col-sm-2 hidden-xs control-label" for="bookingfeebyr">Terbayar</label>
										<label class="col-md-2 col-sm-2 hidden-xs control-label" for="bookingfeeonp">On Proses</label>
										<label class="col-md-3 col-sm-3 hidden-xs control-label bold" for="bookingfee">Pembayaran</label>
									</div>
									<div class="form-group no-gutter blokbookingfee"><div class="col-md-12">
										<label class="col-sm-3 control-label" for="bookingfeeoff">Booking Fee</label>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="bookingfeeoff" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="bookingfeebyr" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="bookingfeeonp" disabled></div>
										<div class="col-sm-3"><input type="text" class="form-control mask_decimal change-total" name="bookingfee" id="bookingfee"></div>
									</div></div>
									<div class="form-group no-gutter blokuangmuka"><div class="col-md-12">
										<label class="col-sm-3 control-label" for="uangmukaoff">Uang Muka</label>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="uangmukaoff" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="uangmukabyr" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="uangmukaonp" disabled></div>
										<div class="col-sm-3"><input type="text" class="form-control mask_decimal change-total" name="uangmuka" id="uangmuka"></div>
									</div></div>
									<div class="blokkpr">
									<div class="form-group no-gutter blokklt"><div class="col-md-12">
										<label class="col-sm-3 control-label" for="kelebihantanahoff">Kelebihan Tanah</label>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargakltoff" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargakltbyr" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargakltonp" disabled></div>
										<div class="col-sm-3"><input type="text" class="form-control mask_decimal change-total" name="hargaklt" id="hargaklt"></div>
									</div></div>
									<div class="form-group no-gutter bloksudut"><div class="col-md-12">
										<label class="col-sm-3 control-label" for="hargasudutoff">Posisi Sudut</label>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargasudutoff" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargasudutbyr" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargasudutonp" disabled></div>
										<div class="col-sm-3"><input type="text" class="form-control mask_decimal change-total" name="hargasudut" id="hargasudut"></div>
									</div></div>
									<div class="form-group no-gutter blokhadapjalan"><div class="col-md-12">
										<label class="col-sm-3 control-label" for="hargahadapjalanoff">Hadap Jalan</label>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargahadapjalanoff" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargahadapjalanbyr" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargahadapjalanonp" disabled></div>
										<div class="col-sm-3"><input type="text" class="form-control mask_decimal change-total" name="hargahadapjalan" id="hargahadapjalan"></div>
									</div></div>
									<div class="form-group no-gutter blokfasum"><div class="col-md-12">
										<label class="col-sm-3 control-label" for="hargafasumoff">Hadap Taman</label>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargafasumoff" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargafasumbyr" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargafasumonp" disabled></div>
										<div class="col-sm-3"><input type="text" class="form-control mask_decimal change-total" name="hargafasum" id="hargafasum"></div>
									</div></div>
									<div class="form-group no-gutter blokredesign"><div class="col-md-12">
										<label class="col-sm-3 control-label" for="hargaredesignoff">Redesign Bangunan</label>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargaredesignoff" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargaredesignbyr" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargaredesignonp" disabled></div>
										<div class="col-sm-3"><input type="text" class="form-control mask_decimal change-total" name="hargaredesign" id="hargaredesign"></div>
									</div></div>
									<div class="form-group no-gutter bloktambahkw"><div class="col-md-12">
										<label class="col-sm-3 control-label" for="hargatambahkwoff">Penambahan Kwalitas</label>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargatambahkwoff" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargatambahkwbyr" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargatambahkwonp" disabled></div>
										<div class="col-sm-3"><input type="text" class="form-control mask_decimal change-total" name="hargatambahkwalitas" id="hargatambahkwalitas"></div>
									</div></div>
									<div class="form-group no-gutter bloktambahkontruksi"><div class="col-md-12">
										<label class="col-sm-3 control-label" for="hargakerjatambahoff">Penambahan Kontruksi</label>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargakerjatambahoff" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargakerjatambahbyr" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="hargakerjatambahonp" disabled></div>
										<div class="col-sm-3"><input type="text" class="form-control mask_decimal change-total" name="hargapekerjaantambah" id="hargapekerjaantambah"></div>
									</div></div>
									</div> <!-- end of blok kpr -->
									<div class="form-group no-gutter bloktunai"><div class="col-md-12">
										<label class="col-sm-3 control-label" for="totalangsuranoff">Harga Tunai</label>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="totalangsuranoff" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="totalangsuranbyr" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="totalangsuranonp" disabled></div>
										<div class="col-sm-3"><input type="text" class="form-control mask_decimal change-total" name="totalangsuran" id="totalangsuran"></div>
									</div></div>
									<div class="clearfix margin-bottom-10"> </div>
									<div class="col-md-offset-3 col-md-9"><hr style="border: none; border-bottom: 1px solid #1BBC9B;"></div>

									<div class="form-group no-gutter"><div class="col-md-12">
										<div class="col-sm-3 control-label"><span class="label label-info" for="totaloff">TOTAL</span></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="totaloff" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="totalbyr" disabled></div>
										<div class="col-sm-2 hidden-xs"><input type="text" class="form-control mask_decimal" id="totalonp" disabled></div>
										<div class="col-sm-3"><input type="text" class="form-control mask_decimal" name="total" id="total" readonly></div>
									</div></div>
								</div>
							</div></div>
		        		</div> <!-- end of row -->
		        		<div id="induk" class="hidden"><?php echo $induk; ?></div>
		        		<input type="text" name="idpemesanan" id="idpemesanan" value=<?php echo $noid; ?>>
		        		<input type="text" name="accbank" id="accbank">
		        		<input type="hidden" name="idtyperumah" id="idtyperumah">
		        		<input type="hidden" name="angke" id="angke">
		        		<input type="hidden" id="polapembayaran" value="-1">
		        		<input type="hidden" id="noid">
	        		</div> <!-- end of form-body -->
	        		<div class="form-actions">
                    <!-- <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn green" name="submitbtn" >Submit</button>
                            <button type="button" class="btn default" id="cancel">Cancel</button>
                        </div>
                    </div> -->
                	</div> <!-- end of form action -->
	        		</form> <!-- end of form -->
	        	</div> <!-- end of tab-pane detil -->
	        	<div class="tab-pane" id="tab_history">
	        		<div class="table-container">
	        			<div class="table-toolbar">
                                <!-- <button type="button" class="new btn btn-icon-only green"><i class="fa fa-plus fa-2x"></i></button>
                                <button type="button" class="edit btn btn-icon-only blue" disabled><i class="fa fa-edit fa-2x"></i></button>
                                <button type="button" class="copy btn btn-icon-only purple-plum" disabled><i class="fa fa-copy fa-2x"></i></button> -->
                                <!-- <button type="button" class="delete btn btn-icon-only red-mint" disabled><i class="fa fa-trash-o"></i></button> -->
                                <!-- <button type="button" class="export btn btn-icon-only green-dark"><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i></button> -->
                                <!-- <a data-toggle="modal" href="" class="delete btn btn-sm red"><i class="fa fa-trash-o"></i> Pembatalan</a> -->
                                <button type="button" data-toggle="modal" class="batal btn btn-danger btn-sm" disabled>Pembatalan</button>
                        </div>
	        			<table class="table table-striped table-bordered table-hover" id="table_history_pembayaran">
	        				<thead>
	        					<tr role="row" class="heading">
	        						<th width="5%">#</th>
	        						<th width="5%">ID</th>
	        						<th width="10%">Tanggal</th>
	        						<th width="30%">Keterangan</th>
	        						<th width="30%">Bank Penerima</th>
	        						<th width="10%">Total</th>
	        						<th width="10%">Status</th>
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
	        	</div> <!-- end of tab-pane history -->
	        </div> <!-- end of tab-content -->
        </div> <!-- end of tabbable-line -->
	</div> <!-- end of portlet-body -->
</div> <!-- end of portlet -->
</div>
<div id="row_batal" class="modal fade draggable-modal" role="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding:20px 30px; background-color: #D05454; color: white; text-align: center; font-size: 30px;">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> -->
                <h4 class="modal-title" style="font-size: 30px;">Pembatalan Kwitansi</h4>
            </div>
            <div class="modal-body">
    			<div class="row static-info">
					<div class="col-md-2 col-sm-5 name">No. Kwitansi</div>
					<div class="col-md-4 col-sm-7 value" id="nokwitansi">-</div>
					<div class="col-md-2 col-sm-5 name">tglkwitansi</div>
					<div class="col-md-4 col-sm-7 value" id="tglkwitansi">-</div>
				</div>
				<div class="row static-info">
					<div class="col-md-2 col-sm-5 name">No. Pesanan</div>
					<div class="col-md-4 col-sm-7 value" id="nopesanan">-</div>
					<div class="col-md-2 col-sm-5 name">Nama</div>
					<div class="col-md-4 col-sm-7 value" id="namapemesan">-</div>
				</div>
				<div class="row static-info">
					<div class="col-md-2 col-sm-5 name">Block/Kavling</div>
					<div class="col-md-4 col-sm-7 value" id="kavling">-</div>
					<div class="col-md-2 col-sm-5 name">Type Rumah</div>
					<div class="col-md-4 col-sm-7 value" id="typerumah">-</div>
				</div>
				<div class="row static-info">
					<div class="col-md-offset-6 col-md-2">Total Transaksi</div>
					<div class="col-md-2 mask_decimal value" id="totaltransaksi">0</div>
				</div>

				<div class="table-container table-responsive">
        			<table class="display" cellspacing="0" cellpadding="3" width="100%" id="table_rinciankwitansi">
        				<thead>
        					<tr role="row" class="heading">
        						<th width="5%">#</th>
        						<th width="35%">Jenis Penerimaan</th>
        						<th width="40%">Keterangan</th>
        						<th width="20%">Total</th>
        					</tr>
        				</thead>
        				<tbody></tbody>
        				<tfoot>
        					<tr role="row" class="footer">
        						<th colspan ="3" class="dt-head-right">TOTAL</th>
        						<th></th>
        					</tr>
        				</tfoot>
        			</table>
        		</div>
        		<div class="margin-bottom-20"></div>
    			<form action="" method="post" class="form-horizontal" rules="form" id="form_batal">
        			<div class="form-body">
						<input type="hidden" name="noid" id="noid">
						<input type="hidden" name="idpemesanan" id="idpemesanan">
						<input type="hidden" name="kodeupdated" id="kodeupdated">
						<input type="hidden" name="totalbayar" id="totalbayar">
						<input type="hidden" name="statusbatal" id="statusbatal">
						<input type="hidden" name="statustransaksi" id="statustransaksi">

						<div class="form-group">
    						<input type="hidden" name="tglbatal" id="tglbatal">
							<label class="col-md-2 col-sm-2  control-label" for="tglpembatalan">Tgl. bayar</label>
	                        <div class="col-md-3 col-sm-3"> 
	                            <div class="input-group date date-picker" id = "dptglpembatalan">
	                                <input class="form-control required" type="text"value="" name="tglpembatalan" id="tglpembatalan" data-date-start-date="+0d" readonly required/>
	                                <span class="input-group-btn">
	                                    <button class="btn default" type="button">
	                                        <i class="fa fa-calendar"></i>
	                                    </button>
	                                </span>
	                            </div>
	                        </div>
	                        <label class="col-md-2 col-sm-2 control-label" for="cbbankout">Bank Pengeluaran</label>
							<div class="col-md-5 col-sm-5">
								<select class="selectpicker form-control required" id="cbbankout" name="cbbankout" data-size=8 data-style="btn-default" required>
									<option value="" data-value="" data-content="Select from list..."></option>
									<?php echo $optionbank ?>
								</select>
							</div>
	                    </div>
	                    <div class="form-group">
                            <label class="col-md-2 control-label">No. Bukti:
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-4">
                                <input type="text" name="nobukti" class="form-control">
                            </div>
                            <label class="col-md-2 control-label">No. Cek:</label>
                            <div class="col-md-4">
                                <input type="text" name="nomorcek" class="form-control">
                            </div>
                        </div>
	                    <div class="form-group">
                            <label class="col-md-2 control-label">Alasan Batal:
                                <span class="required"> * </span>
                            </label>
                            <div class="col-md-10">
                                <textarea rows="4" class="form-control" name="alasanbatal" required></textarea>
                            </div>
                        </div>
	        		</div>
	        	</form>
            </div>
            <div class="modal-footer">
            	<button type="button" data-dismiss="modal" class="btn dark btn-outline">Cancel</button>
				<button type="submit" class="btn red btn-outline" form="form_batal">Process</button>
            </div>
        </div>
    </div>
</div>


