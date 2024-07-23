<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script>
<!-- <script src="<?php echo base_url(); ?>assets/global/plugins/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script> -->
<script src="<?php echo base_url(); ?>assets/pages/scripts/journal_extract.js" type="text/javascript"></script>


<div class="margin-top-10" id= "row_extract">
    <div class="info"></div>
    <div class="portlet light">
        <!-- <div class="portlet-title tabbable-line"> -->
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-book-open font-yellow-crusta sbold icon-lg"></i>
                <span class="caption-subject sbold">Accounting | </span>
                <span class="caption-helper"> Extract </span>
            </div>
            <div class="actions btn-set">
                <button type="button" class="btn btn-secondary-outline reset" ><i class="fa fa-refresh"></i>re-Load</button>
                <button type="button" class="btn btn-success save"><i class="fa fa-save"></i>Save</button>
                <button type="button" class="btn btn-warning print" value="0"><i class="fa fa-print"></i>Print</button>
            </div>
        </div>
        <div class="info"></div>
        <div class="portlet-body">
            <div class="m-heading-1 border-green m-bordered">
                <div class="row">  
                    <div class="form-group col-md-12">
                        <label class="col-md-2 col-sm-4 control-label" for="source">Extract Source</label>
                        <div class="col-md-3 col-sm-4">
                            <select class="form-control selectpicker" data-style="btn-default" name="source" id="source">
                                <option value="0">select...</option>
                                <option value="1" disabled>Opening Ballance</option>
                                <option value="2" disabled>General Journal</option>
                                <option value="3">Akad Jual-Beli</option>
                                <option value="4" disabled>Inventory</option>
                                <option value="5">Kas-Bank</option>
                                <option value="6">Fixed Asset</option>
                                <option value="7">Pembatalan Konsumen</option>
                                <!-- <option value="8">Tunai Keras (Bertahap)</option> -->
                            </select>
                        </div>
                        <div class="col-md-4 col-sm-4 pull-right">
                            <h4 class="pull-right">Periods : <label class="label-danger font-white"><?php echo $parameter['bulanbuku'].' - '.$parameter['tahunbuku'] ?></label> </h4>

                        </div>
                    </div>
                    <div class="form-group  col-md-12 bulantahun" style="display: none;">
                        <label class="col-md-2 col-sm-4 control-label" for="bulansusut">Periode</label>
                        <div class="col-md-4 col-sm-5">
                            <select class="form-control selectpicker" data-size=6 data-style="btn-default" name="bulan" id="bulan">
                                
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-3">
                            <select class="form-control selectpicker" data-size=6 data-style="btn-default" name="tahun" id="tahun">
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-12 periode" style="display: none;">
                        <!-- <input type="hidden" name="tglextract" id="tglextract" >
                        <input type="hidden" name="tglextractto" id="tglextractto" > -->
                        <label class="col-md-2 col-sm-4 control-label" for="periode">Periode</label>
                        <div class="col-md-3 col-sm-4"> 
                            <div class="input-group date date-picker" id = "dpperiode">
                                <input class="form-control" type="text" value="" name="periode" id="periode" data-date-start-date="+0d" readonly/>
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>

                            </div>
                        </div>
                        <div class="col-md-3 col-sm-4"> 
                            <div class="input-group date date-picker" id = "dpperiode1">
                                <input class="form-control" type="text" value="" name="periode1" id="periode1" data-date-start-date="+0d" readonly/>
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row">
                <div class="col-md-8 col-sm-12">
                        <button type="button" class="btn btn-success load pull-right"><i class="fa fa-refresh"></i>re-Load</button>
                </div>
                </div> -->
            </div> 
            <div class="table-container">
                <table class="table table-striped table-hover" id="table_extract">
                    <thead>
                        <tr role="row" class="heading">
                            <th>
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                    <span></span>
                                </label>
                            </th>
                            <th></th>
                            <th></th><th></th><th></th><th></th><th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr role="row" class="footer">
                            <th colspan ="5" class="dt-head-right"><p> Total Page</p><p> Grand Total</p></th>
                            <th class="text-right"></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div> <!-- end of portlet-light -->

        <table class="table detail" id="table_jurnaldetail" style="display: none;">
            <thead>
                <tr role="row" class="flat">
                    <th></th><th></th><th></th><th></th><th></th><th></th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr role="row" class="footer">
                    <th colspan ="4" class="dt-head-right">TOTAL</th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
</div> <!-- end row