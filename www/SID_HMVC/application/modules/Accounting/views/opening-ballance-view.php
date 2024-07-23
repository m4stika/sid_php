<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-mask-plugin/jquery.mask.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/openingbalance.js" type="text/javascript"></script>

 <script type="text/javascript">
        jQuery(document).ready(function() {
      	    //var content = "<?php //Print($content); ?>";
    		//(content == 'cash') ? $('#selectrekidbank').selectpicker('hide') : $('#selectrekid').selectpicker('hide');
        });
 </script>


<div class="margin-top-10" id= "row_openingbalance">
    <div class="info"></div>
    <div class="portlet light">
        <!-- <div class="portlet-title tabbable-line"> -->
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-book-open font-yellow-crusta sbold icon-lg"></i>
                <span class="caption-subject sbold">Opening Ballance | </span>
                <span class="caption-helper"> view </span>
            </div>
            <div class="actions btn-set">
                <button type="button" class="btn btn-secondary-outline back" style="display: none"><i class="fa fa-arrow-left"></i>Back</button>
                <button type="button" class="btn btn-secondary-outline reset" ><i class="fa fa-reply"></i>Reset</button>
                <button type="button" class="btn btn-success save1"><i class="fa fa-save"></i>Save</button>
                <button type="button" class="btn btn-warning print" value="0"><i class="fa fa-print"></i>Print</button>
            </div>
        </div>
        <div class="portlet-body">
            <div class="m-heading-1 border-green m-bordered">
                <h3 class="text-center">Enter the ballance your accounts (ballance sheet only)</h3>
                <p class="font-red-thunderbird text-center"> [remember!! enter all ballances as positive number, unless the ballance really was negative] </p>
                <p> </p>
            </div> 
            <div class="table-container table-responsive">
                <table class="table table-striped table-hover table-condensed" id="table_openingbalance">
                    <thead>
                        <tr role="row" class="heading">
                            <th width="5%">Action</th>
                            <th width="5%">#ID</th>
                            <th width="20%">Acc #</th>
                            <th width="35%">Description</th>
                            <th>Debit</th>
                            <th>Credit</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr role="row" class="footer">
                            <th colspan ="4" class="dt-head-right">TOTAL</th>
                            <th class="text-right"></th>
                            <th class="text-right"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <blockquote class="blockquote-reverse margin-top-20">
                <p class="">Amount left to be allocated <span class="sbold font-red-thunderbird" id="amountalocated"> Rp. 150.000 </span></p>
                <footer>this will be opening ballance of <strong>Ikhtisar Laba Rugi</strong> account </footer>
            </blockquote>
        </div>
    </div> <!-- end of portlet-light -->
</div> <!-- end row -->