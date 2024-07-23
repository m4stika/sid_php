<!-- <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script> -->
<!-- <script src="<?php echo base_url(); ?>assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script> -->
<script src="<?php echo base_url(); ?>assets/pages/scripts/penyusutan.js" type="text/javascript"></script>

 <script type="text/javascript">
        jQuery(document).ready(function() {
      	    //var content = "<?php //Print($content); ?>";
    		//(content == 'cash') ? $('#selectrekidbank').selectpicker('hide') : $('#selectrekid').selectpicker('hide');
        });
 </script>


<div class="margin-top-10" id= "row_penyusutan">
    <div class="info"></div>
    <div class="portlet light">
        <!-- <div class="portlet-title tabbable-line"> -->
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-book-open font-yellow-crusta sbold icon-lg"></i>
                <span class="caption-subject sbold">Penyusutan | </span>
                <span class="caption-helper"> view </span>
            </div>
            <div class="actions btn-set">
                <button type="button" class="btn btn-secondary-outline reset" ><i class="fa fa-reply"></i>Reset</button>
                <button type="button" class="btn btn-success save1"><i class="fa fa-save"></i>Save</button>
                <button type="button" class="btn btn-warning print" value="0"><i class="fa fa-print"></i>Print</button>
            </div>
        </div>
        <div class="info"></div>
        <div class="portlet-body">
            <div class="m-heading-1 border-green m-bordered">
                <h3 class="text-center">Proses Penyusutan Aktiva Tetap</h3>
                <p class="font-red-thunderbird text-center"> [Perhatian!! Proses ini hanya di lakukan 1x dalah bulan-tahun pembukuan] </p>
                <p> </p>
            </div> 
            <div class="table-container table-responsive">
                <table class="table table-striped table-hover table-condensed" id="table_penyusutan">
                    <thead>
                        <tr role="row" class="heading">
                            <th></th><th></th><th></th><th></th><th></th><th></th><th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr role="row" class="footer">
                            <th colspan ="4" class="dt-head-right">TOTAL</th>
                            <th class="text-right"></th>
                            <th class="text-right"></th>
                            <th class="text-right"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div> <!-- end of portlet-light -->
</div> <!-- end row -->