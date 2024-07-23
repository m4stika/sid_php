<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/form-input-mask.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>assets/global/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/global/plugins/jstree/dist/jstree.min.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>assets/global/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/pages/scripts/kasbank_jurnal.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/handle-treeaccount.js" type="text/javascript"></script>

 <script type="text/javascript">
        jQuery(document).ready(function() {
      	    var content = "<?php Print($content); ?>";
    		(content == 'cash') ? $('#selectrekidbank').selectpicker('hide') : $('#selectrekid').selectpicker('hide');
		});
 </script>

<div class="row_kasbank margin-top-10">
	<div class="portlet light">
		<!-- <div class="portlet-title tabbable-line"> -->
		<div class="portlet-title">
			<div class="caption">
				<i class="fa fa-money font-dark"></i>
				<!-- <span class="caption-subject font-dark sbold"><?php //if($content == 'cashin') {echo "Cash";} else {echo "Bank";} ?></span> -->
				<span class="caption-subject font-dark sbold"><?php echo $content ?></span>
				<em class="hidden-xs small" id="pemesantitle"> | IN (OUT) </em>
			</div>
			<div class="actions btn-set">
				<button type="button" class="btn btn-secondary-outline back" style="display: none"><i class="fa fa-arrow-left"></i>Back</button>
				<button type="button" class="btn btn-secondary-outline reset" ><i class="fa fa-reply"></i>Reset</button>
				<button type="submit" disabled class="btn btn-success save" form="form_jurnalkb"><i class="fa fa-save"></i>Save</button>
				<button type="button" class="btn btn-warning print" value="0"><i class="fa fa-print"></i>Print</button>
			</div>
		</div>
		<div class="portlet-body">
	        <div class="tabbable-line">
	        <ul class="nav nav-tabs nav-tabs-lg">
	            <li class="active" id="detil">
	                <a href="#tab_transaksi" data-toggle="tab"> Transaksi </a>
	            </li>
	            <li id="history">
	                <a href="#tab_history" data-toggle="tab"> History </a>
	            </li>
	        </ul>
	        <div class="tab-content">
	        	<div class="tab-pane active" id="tab_transaksi">
	        		<form action="" method="post" role="form" id="form_jurnalkb" class="form-horizontal">
	        			<div class="form-body">
	        			<div class="row">
	        			<!-- <div class="col-md-3">
                        	<div class="portlet box blue-hoki" id="portlet_account">
	                            <div class="portlet-title">
	                                <div class="caption"><i class="fa fa-cogs"></i>List Perkiraan</div>
	                                <div class="tools">
	                                    <a href="javascript:;" class="reload"> </a>
	                                </div>
	                            </div>
	                            <div class="portlet-body portlet-empty">
	                                <div class="scroll" style="height:500px; overflow-y: scroll;">
	                                <div class="row"><div class="col-md-12"><input class="pull-right" type="text" id="searchitem" placeholder="search"></div></div>
	                                <div id="tree_acc" class="tree-demo"> </div>
	                                </div>
	                            </div>
	                        </div>
	        			</div> -->
	        			<div class="col-md-9">
	        				<input type="hidden" name="crud" id="crud" value="new" class="form-control">
	                        <input type="hidden" name="noid" id="noid" value="-1" class="form-control">
	                        <input type="hidden" name="statusKB" id="statusKB" value=<?php if($content == 'cash') {echo "Cash";} else {echo "Bank";} ?> class="form-control">

	        				<div class="form-group">
	                            <label class="col-md-2 control-label">Status</label>
	                            <div class="col-md-10">
	                                <div class="input-group">
	                                    <div class="icheck-inline">
	                                        <label>
	                                            <input type="radio" name="kasbanktype" id="penerimaan" value="0" checked class="icheck" data-radio="iradio_flat-green"> Penerimaan (IN) </label>
	                                        <label>
	                                            <input type="radio" name="kasbanktype" id="Pengeluaran" value="1" class="icheck" data-radio="iradio_flat-green"> Pengeluaran (Out) </label>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>

	        				<div class="form-group">
                                <label class="col-md-2 control-label text-primary bold uppercase">Kas/Bank:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-3">
                                    <select class="form-control selectpicker" data-size=10 data-style="btn-default" name="rekidkas" id="selectrekid">
                                        <?php echo $kaslist; ?>
                                    </select>
                                    <select class="form-control selectpicker" data-size=10 data-style="btn-default" name="rekidbank" id="selectrekidbank">
                                        <?php echo $banklist; ?>
                                    </select>
                                </div>
        						<input type="hidden" name="tgltransaksi" id="tgltransaksi">
								<label class="col-md-2 control-label" for="tgljurnal">Tgl. Transaksi
									<span class="required"> * </span>
								</label>
		                        <div class="col-md-3"> 
		                            <div class="input-group date date-picker" id = "dptgljurnal">
		                                <input class="form-control" type="text"value="" name="tgljurnal" id="tgljurnal" data-date-start-date="+0d" readonly/>
		                                <span class="input-group-btn">
		                                    <button class="btn default" type="button">
		                                        <i class="fa fa-calendar"></i>
		                                    </button>
		                                </span>
		                            </div>
		                        </div>
		                    </div>
	        				<div class="form-group">
		        				<label class="col-md-2 control-label" for="nobukti">No. Bukti
									<span class="required"> * </span>
		        				</label>
		        				<div class="col-md-3"><input class="form-control" type="text" name="nobukti" id="nobukti"></div>
		        				<label class="col-md-2 control-label" for="nomorcek">No. Cek/BG<span class="required"> * </span></label>
		        				<div class="col-md-3"><input class="form-control" type="text" name="nomorcek" id="nomorcek"></div>
	        				</div>
	        				<div class="form-group">
                                <label class="col-md-2 control-label">di terima dari:</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="terimadari" id="terimadari">
                                </div>
                            </div>
	        				<div class="form-group">
                                <label class="col-md-2 control-label">Uraian:
                                    <span class="required"> * </span>
                                </label>
                                <div class="col-md-10">
                                    <textarea rows="4" class="form-control" name="uraian"></textarea>
                                </div>
                            </div>

                            <!-- <div class="form-group">
                                
                            </div> -->

                            <!-- <div class="row">
                            <div class="col-md-3">
                            	<div class="portlet box blue-hoki" id="portlet_account">
		                            <div class="portlet-title">
		                                <div class="caption"><i class="fa fa-cogs"></i>List Perkiraan</div>
		                                <div class="tools">
		                                    <a href="javascript:;" class="reload"> </a>
		                                </div>
		                            </div>
		                            <div class="portlet-body portlet-empty">
		                                <div class="scroll" style="height:400px; overflow-y: scroll;">
		                                <div class="row"><div class="col-md-12"><input class="pull-right" type="text" id="searchitem" placeholder="search"></div></div>
		                                <div id="tree_acc" class="tree-demo"> </div>
		                                </div>
		                            </div>
		                        </div>
                            </div> -->
                            <div id="droppable2" class="ui-widget-header">
							  <p>Drop here</p>
							</div>
                            <div class="col-md-12">
                            	<input class="form-control" type="hidden" name="totaltransaksi" id="totaltransaksi">
                            	<div class="table-container table-responsive">
				        			<table class="table table-striped table-hover table-condensed" id="table_entrykb">
				        				<thead>
				        					<tr role="row" class="heading">
				        						<th width="5%">Action</th>
				        						<th width="5%">#ID</th>
				        						<th width="10%">No. Perkiraan</th>
				        						<th width="30%">Nama Perkiraan</th>
				        						<th width="30%">Uraian</th>
				        						<th width="20%">Nilai</th>
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
				        		</div>
				        	</div>
				        	</div> <!-- end of col-md-9 -->
				        </div>	<!-- end of row -->
	        			</div> <!-- end of form-body -->
	        		</form>
	        	</div> <!-- end of tab_transaksi -->
	        	<div class="tab-pane" id="tab_history">
	        		<div class="table-container" id="resize_wrapper">
	        			<div class="info"></div>
	        			<div class="table-toolbar">
                                <button type="button" class="new btn btn-icon-only green"><i class="fa fa-plus fa-2x"></i></button>
                                <button type="button" class="edit btn btn-icon-only blue" disabled><i class="fa fa-edit fa-2x"></i></button>
                                <button type="button" class="copy btn btn-icon-only purple-plum" disabled><i class="fa fa-copy fa-2x"></i></button>
                                <button type="button" class="delete btn btn-icon-only red-mint" disabled><i class="fa fa-trash-o fa-2x"></i></button>
                                <button type="button" class="export btn btn-icon-only green-dark"><i class="fa fa-file-excel-o fa-2x" aria-hidden="true"></i></button>
                        </div>
	        			<table class="table table-striped table-bordered table-hover" id="table_history_jurnalKB">
	        				<thead>
	        					<!-- <tr role="row" class="heading">
	        						<th width="5%">#</th>
	        						<th width="5%">ID</th>
	        						<th width="10%">Status</th>
	        						<th width="10%">Tanggal</th>
	        						<th width="10%">rekid</th>
	        						<th width="25%">Account</th>
	        						<th width="10%">Total</th>
	        						<th width="35%">Uraian</th>
	        					</tr> -->
	        					<tr role="row" class="heading">
	        						<th>#</th>
	        						<th width="5%">ID</th>
	        						<th>Status</th>
	        						<th  width="10%">Tanggal</th>
	        						<th>No. Kasbank</th>
	        						<th width="20%">Account</th>
	        						<th>Total</th>
	        						<th width="30%">Uraian</th>
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
                                        <!-- <div class="input-group date date-picker margin-bottom-5" data-date-format="dd/mm/yyyy" id="tglhistoryfrom">
                                            <input type="text" class="form-control form-filter input-sm" readonly placeholder="From">
                                            <span class="input-group-btn">
                                                <button class="btn btn-sm default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div> 
                                        <input type="hidden" name="tgltransaksito" id="tgltransaksi1" class="form-control form-filter input-sm">
                                        <div class="input-group date date-picker" data-date-format="dd/mm/yyyy" id="tglhistoryto">
                                            <input type="text" class="form-control form-filter input-sm" readonly placeholder="To">
                                            <span class="input-group-btn">
                                                <button class="btn btn-sm default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div> -->
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
									                                                            
                                    <td><button class="btn btn-sm green btn-outline filter-submit margin-bottom"><i class="fa fa-search"></i> Search</button></td>
									<td><button class="btn btn-sm red btn-outline filter-cancel"><i class="fa fa-times"></i> Reset</button></td>
									
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
</div> <!-- end of row_cashin -->