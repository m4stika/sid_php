<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/form-input-mask.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jstree/dist/jstree.min.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>assets/global/plugins/jstree/dist/themes/default/style.min.css" rel="stylesheet" type="text/css" />

<!-- <script src="<?php echo base_url(); ?>assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script> -->

<!-- <div class="col-md-12"> -->
<!-- BEGIN VALIDATION STATES-->
<div class="portlet light"> <!-- portlet-fit bordered"> -->
    <div class="portlet-title">
        <div class="caption">
            <i class="icon-equalizer font-white-sunglo"></i>
            <span class="caption-subject font-white-sunglo bold uppercase">Type Rumah</span>
            <span class="caption-helper font-blue-chambray">Edit Form</span>
        </div>                      
        <div class="actions btn-set">
            <button type="button" class="btn btn-secondary-outline back"><i class="fa fa-arrow-left"></i>Back</button>
            <button type="button" class="btn btn-secondary-outline reset" ><i class="fa fa-reply"></i>Reset</button>
            <button type="submit" class="btn btn-success" form="form_typerumah"><i class="fa fa-check"></i>Save</button>
            <button type="button" class="btn btn-warning"><i class="fa fa-check"></i>Print</button>                    
        </div>
    </div>
    <div class="portlet-body">
        <div id="info"></div>
        <form action="" method="post" class="form-horizontal" rules="form" id="form_typerumah">
            <div class="form-body"><div class="row">
                <div class="col-md-4"><div class="portlet box blue-hoki">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-cogs"></i>Data Umum Type Rumah</div>
                        <div class="tools">
                            <span id="noid_span">Noid</span>
                        </div>
                        <input type="hidden" name="noid" id="noid" class="form-control" readonly>
                    </div>
                    <div class="portlet-body">
                        <div class="form-group">                     
                            <label class="col-md-3 col-sm-3 col-xs-3 text-primary bold control-label" for="typerumah">Type Rumah</label>
                            <div class="col-md-9 col-sm-9 col-xs-9">
                                <input type="text" name="typerumah" id="typerumah" class="form-control input-lg">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div>  
                        <div class="form-group">                     
                            <label class="col-md-3 col-sm-3 col-xs-3 control-label" for="keterangan">Keterangan</label>
                            <div class="col-md-9 col-sm-9 col-xs-9">
                                <input type="text" name="keterangan" id="keterangan" class="form-control">
                                <div class="form-control-focus"> </div>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-md-3 col-sm-3 col-xs-3 control-label" for="luastanah">Luas Tanah</label>
                            <div class="col-md-4 col-sm-4 col-xs-4"><input type="text" name="luastanah" id="luastanah" class="form-control mask_number"></div>
                        </div> 
                        <div class="form-group">
                            <label class="col-md-3 col-sm-3 col-xs-3 control-label" for="luasbangunan">Luas Bangunan</label>
                            <div class="col-md-4 col-sm-4 col-xs-4"><input type="text" name="luasbangunan" id="luasbangunan" class="form-control mask_number"></div>
                        </div> 
                    </div>
                </div> <!-- end of col-md -->
                </div> <!-- end of panel-->

                
                <div class="col-md-8"><div class="portlet box blue-hoki">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-cogs"></i>Data Harga Type Rumah</div>
                    </div>
                    <div class="portlet-body">
                        <div class="row"><div class="col-md-6"><div class="form-group">                     
                            <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="hargajual">Harga Jual</label>
                            <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="hargajual" id="hargajual" class="form-control mask_decimal"></div>
                        </div>
                        <div class="form-group">                     
                            <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="hpp">Estimasi HPP</label>
                            <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="hpp" id="hpp" class="form-control mask_decimal"></div>
                        </div>
                        <div class="form-group">                     
                            <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="plafonkpr">Plafon KPR</label>
                            <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="plafonkpr" id="plafonkpr" class="form-control mask_decimal"></div>
                        </div>
                        <div class="form-group">                     
                            <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="bookingfee">Booking Fee</label>
                            <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="bookingfee" id="bookingfee" class="form-control mask_decimal"></div>
                        </div>
                        <div class="form-group">                     
                            <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="uangmuka">Uang Muka</label>
                            <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="uangmuka" id="uangmuka" class="form-control mask_decimal"></div>
                        </div></div>
                        <div class="col-md-6"><div class="form-group">                     
                            <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="hargasudut">Hrg. Posisi Sudut</label>
                            <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="hargasudut" id="hargasudut" class="form-control mask_decimal"></div>
                        </div>
                        <div class="form-group">                     
                            <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="hargahadapjalan">Hrg. Hadap Jalan</label>
                            <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="hargahadapjalan" id="hargahadapjalan" class="form-control mask_decimal"></div>
                        </div>
                        <div class="form-group">                     
                            <label class="col-md-4 col-sm-4 col-xs-4 control-label" for="hargafasum">Hrg. Fasum(os)</label>
                            <div class="col-md-8 col-sm-8 col-xs-8"><input type="text" name="hargafasum" id="hargafasum" class="form-control mask_decimal"></div>
                        </div></div></div>
                    </div> <!-- end of panel body -->
                </div> <!-- end of panel -->
                </div> <!-- end of col-md -->
                </div> <!-- end of row -->

                <div class="row">
                <div class="col-md-offset-1 col-md-9"><div class="portlet box blue-hoki">
                    <div class="portlet-title">
                        <div class="caption"><i class="fa fa-cogs"></i>Data Link Account</div>
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_titipan" data-toggle="tab">Account Titipan</a></li>
                            <li><a href="#tab_pendapatan" data-toggle="tab">Account Pendapatan</a></li>
                            <li><a href="#tab_hpp" data-toggle="tab">Account HPP</a></li>
                        </ul>
                    </div>
                    <div class="portlet-body" id="panel-link-account">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_titipan">
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="acctitipanbf">Titipan Booking Fee</label>
                                        <input type="hidden" name="acctitipanbfid" id="acctitipanbfid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="acctitipanbf" id="acctitipanbf" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="acctitipanbfket" id="acctitipanbfket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group" >                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="acctitipanum">Titipan Uang Muka</label>
                                        <input type="hidden" name="acctitipanumid" id="acctitipanumid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="acctitipanum" id="acctitipanum" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="acctitipanumket" id="acctitipanumket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="acctitipanklt">Titipan Kelebihan Tanah</label>
                                        <input type="hidden" name="acctitipankltid" id="acctitipankltid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="acctitipanklt" id="acctitipanklt" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="acctitipankltket" id="acctitipankltket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="acctitipansudut">Titipan Posisi Sudut</label>
                                        <input type="hidden" name="acctitipansudutid" id="acctitipansudutid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="acctitipansudut" id="acctitipansudut" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="acctitipansudutket" id="acctitipansudutket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="acctitipanhadapjalan">Titipan Hadap Jalan</label>
                                        <input type="hidden" name="acctitipanhadapjalanid" id="acctitipanhadapjalanid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="acctitipanhadapjalan" id="acctitipanhadapjalan" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="acctitipanhadapjalanket" id="acctitipanhadapjalanket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="acctitipanfasum">Titipan Fasum/Fasos</label>
                                        <input type="hidden" name="acctitipanfasumid" id="acctitipanfasumid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="acctitipanfasum" id="acctitipanfasum" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="acctitipanfasumket" id="acctitipanfasumket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="acctitipanredesign">Titipan Redesign Bangunan</label>
                                        <input type="hidden" name="acctitipanredesignid" id="acctitipanredesignid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="acctitipanredesign" id="acctitipanredesign" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="acctitipanredesignket" id="acctitipanredesignket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="acctitipantambahkwalitas">Titipan Tambah Kwalitas</label>
                                        <input type="hidden" name="acctitipantambahkwalitasid" id="acctitipantambahkwalitasid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="acctitipantambahkwalitas" id="acctitipantambahkwalitas" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="acctitipantambahkwalitasket" id="acctitipantambahkwalitasket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="acctitipanpekerjaantambah">Titipan Tambah Kontruksi</label>
                                        <input type="hidden" name="acctitipanpekerjaantambahid" id="acctitipanpekerjaantambahid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="acctitipanpekerjaantambah" id="acctitipanpekerjaantambah" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="acctitipanpekerjaantambahket" id="acctitipanpekerjaantambahket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="acctitipanhrgjual">Titipan Harga Jual</label>
                                        <input type="hidden" name="acctitipanhrgjualid" id="acctitipanhrgjualid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="acctitipanhrgjual" id="acctitipanhrgjual" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="acctitipanhrgjualket" id="acctitipanhrgjualket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="acctitipanpiutang">Piutang Konsumen</label>
                                        <input type="hidden" name="acctitipanpiutangid" id="acctitipanpiutangid"> 
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="acctitipanpiutang" id="acctitipanpiutang" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="acctitipanpiutangket" id="acctitipanpiutangket" class="form-control drop-item" disabled></div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_pendapatan">
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="accpenerimaankpr">Penerimaan KPR</label>
                                        <input type="hidden" name="accpenerimaankprid" id="accpenerimaankprid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="accpenerimaankpr" id="accpenerimaankpr" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="accpenerimaankprket" id="accpenerimaankprket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="accpenerimaanbf">Booking Fee</label>
                                        <input type="hidden" name="accpenerimaanbfid" id="accpenerimaanbfid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="accpenerimaanbf" id="accpenerimaanbf" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="accpenerimaanbfket" id="accpenerimaanbfket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="accpenerimaanum">Penerimaan Uang Muka</label>
                                        <input type="hidden" name="accpenerimaanumid" id="accpenerimaanumid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="accpenerimaanum" id="accpenerimaanum" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="accpenerimaanumket" id="accpenerimaanumket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="accpenerimaanklt">Penerimaan KLT</label>
                                        <input type="hidden" name="accpenerimaankltid" id="accpenerimaankltid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="accpenerimaanklt" id="accpenerimaanklt" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="accpenerimaankltket" id="accpenerimaankltket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="accpenerimaansudut">Penerimaan Posisi Sudut</label>
                                        <input type="hidden" name="accpenerimaansudutid" id="accpenerimaansudutid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="accpenerimaansudut" id="accpenerimaansudut" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="accpenerimaansudutket" id="accpenerimaansudutket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="accpenerimaanhadapjalan">Penerimaan Hadap Jalan</label>
                                        <input type="hidden" name="accpenerimaanhadapjalanid" id="accpenerimaanhadapjalanid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="accpenerimaanhadapjalan" id="accpenerimaanhadapjalan" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="accpenerimaanhadapjalanket" id="accpenerimaanhadapjalanket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="accpenerimaanfasum">Penerimaan Fasum/Fasos</label>
                                        <input type="hidden" name="accpenerimaanfasumid" id="accpenerimaanfasumid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="accpenerimaanfasum" id="accpenerimaanfasum" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="accpenerimaanfasumket" id="accpenerimaanfasumket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="accpenerimaanredesign">Penerimaan Redesign Bangunan</label>
                                        <input type="hidden" name="accpenerimaanredesignid" id="accpenerimaanredesignid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="accpenerimaanredesign" id="accpenerimaanredesign" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="accpenerimaanredesignket" id="accpenerimaanredesignket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="accpenerimaantambahkwalitas">Penerimaan Tambah Kwalitas</label>
                                        <input type="hidden" name="accpenerimaantambahkwalitasid" id="accpenerimaantambahkwalitasid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="accpenerimaantambahkwalitas" id="accpenerimaantambahkwalitas" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="accpenerimaantambahkwalitasket" id="accpenerimaantambahkwalitasket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="accpenerimaanpekerjaantambah">Penerimaan Tambah Kontruksi</label>
                                        <input type="hidden" name="accpenerimaanpekerjaantambahid" id="accpenerimaanpekerjaantambahid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="accpenerimaanpekerjaantambah" id="accpenerimaanpekerjaantambah" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="accpenerimaanpekerjaantambahket" id="accpenerimaanpekerjaantambahket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="accpenerimaanhrgjual">Penerimaan Harga Jual</label>
                                        <input type="hidden" name="accpenerimaanhrgjualid" id="accpenerimaanhrgjualid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="accpenerimaanhrgjual" id="accpenerimaanhrgjual" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="accpenerimaanhrgjualket" id="accpenerimaanhrgjualket" class="form-control drop-item" disabled></div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_hpp">
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="acchpp">HPP</label>
                                        <input type="hidden" name="acchppid" id="acchppid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="acchpp" id="acchpp" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="acchppket" id="acchppket" class="form-control drop-item" disabled></div>
                                    </div>
                                    <div class="form-group">                     
                                        <label class="col-md-3 col-sm-4 col-xs-4 control-label" for="accpersediaan">Persediaan</label>
                                        <input type="hidden" name="accpersediaanid" id="accpersediaanid">
                                        <div class="col-sm-3 col-xs-2"><input type="text" name="accpersediaan" id="accpersediaan" class="form-control drop-item" readonly></div>
                                        <div class="col-md-6 col-sm-5 col-xs-5"><input type="text" name="accpersediaanket" id="accpersediaanket" class="form-control drop-item" disabled></div>
                                    </div>
                                </div>
                            </div> <!-- end of tab content -->
                        <!-- </div> --> <!-- end of tab -->
                    </div> <!-- end of panel body -->
                </div> <!-- end of panel -->
                </div> <!-- end of col-md -->
                </div>

            </div> <!-- End form body -->
            <!-- <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                        <button type="submit" class="btn green" name="submitbtn" >Submit</button>
                        <button type="button" class="btn default back" >Cancel</button>
                    </div>
                </div>
            </div> --> <!-- end of form action -->
        </form>
            <!-- </div> --> <!-- end of col-md -->
        <!-- </div>  --> <!-- end row -->   
    </div> <!-- end of portlet-body --> 
</div>  <!-- end of portlet -->