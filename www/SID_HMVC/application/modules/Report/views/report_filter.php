<!-- <script src="<?php echo base_url(); ?>assets/global/plugins/datatables/dataTables.pageResize.min.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/components-bootstrap-select.min.js" type="text/javascript"></script> -->

<!--<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/form-input-mask.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/grid_dropdown.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/karyawan.js" type="text/javascript"></script> -->

<link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/components-date-time-pickers.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>assets/pages/css/report.css" rel="stylesheet" type="text/css" />
<!-- <link href="<?php echo base_url(); ?>assets/pages/css/print.css" rel="stylesheet" type="text/css" /> -->
<script src="<?php echo base_url(); ?>assets/global/plugins/jstree/dist/jstree.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/handle-treereport.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/pages/scripts/report_scrollbar.js" type="text/javascript"></script>


<!-- END HEAD -->
<body>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->

		<!-- BEGIN THEME PANEL -->
        <?php //$this->load->view('Template/theme_panel');?>
        <!-- END THEME PANEL -->

        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="#">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <a href="#">Report</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Report</span>
                </li>
            </ul>
            <?php //$this->load->view('Template/page_toolbar') ?>
        </div>

        <!-- <div id="wrapper_report"> -->
            <div class="report-wrapper">
                <div class="report-body">
                    <!-- <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list"> -->
                    <div class="report-body-wrapper">
                        <div class="report-body-search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Type a searching here..." id="searchitem">
                                <div class="input-group-btn">
                                    <button type="button" class="btn green">
                                        <i class="icon-magnifier"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="report-body-content">
                            <div id="tree_report" class="margin-top-10 tree-demo">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet box grey-mint filter-option">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-print"></i>
                        <span class="caption-subject bg-font-grey-mint">Filter Option</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="clearfix" id="filter-body">
                        <div class="form-group  col-md-12 " id="filter_source" style="display: none;">
                            <label class="col-md-4 col-sm-4 control-label" for="source">Extract Source</label>
                            <div class="col-md-8 col-sm-8">
                                <select class="form-control selectpicker" data-style="btn-default" name="source" id="source">
                                    <option value="0">select...</option>
                                    <option value="1" disabled>Opening Ballance</option>
                                    <option value="2" disabled>General Journal</option>
                                    <option value="3">Akad Jual-Beli</option>
                                    <option value="4" disabled>Inventory</option>
                                    <option value="5">Kas-Bank</option>
                                    <option value="6">Fixed Asset</option>
                                    <option value="7">Pembatalan Konsumen</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-12" id="filter_item">
                            <label class="col-md-4 col-sm-4 control-label" for="filteritem">Item</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="filteritem" value="">
                                <i id="noid">-</i>
                            </div>
                                <!-- <div class="col-md-7"></div>
                                <div class="col-md-2 value" id="noid">-</div>
                                <div class="col-md-3 value" id="remark">-</div> -->

                        </div>
                        <div class="form-group bulantahun  col-md-12 " id="filter_blth">
                            <label class="col-md-4 col-sm-4 control-label" for="bulan">Periode</label>
                            <div class="col-md-4 col-sm-4">
                                <select class="form-control selectpicker" data-size=6 data-style="btn-default" name="bulan" id="bulan">

                                </select>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <select class="form-control selectpicker" data-size=6 data-style="btn-default" name="tahun" id="tahun">
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-12 periode" id="filter_periode">
                            <input type="hidden" id="tanggal" >
                            <input type="hidden" id="tanggalto" >
                            <label class="col-md-4 col-sm-4 control-label" for="periode">Periode</label>
                            <div class="col-md-4 col-sm-4">
                                <div class="input-group date date-picker" id = "dpperiode">
                                    <input class="form-control" type="text" value="" name="periode" id="periode" data-date-start-date="+0d" readonly/>
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>

                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
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
                        <div class="form-group  col-md-12 " id="filter_groupby">
                            <label class="col-md-4 col-sm-4 control-label" for="groupby">Group By</label>
                            <div class="col-md-6 col-sm-6">
                                <select class="form-control selectpicker" data-style="btn-default" name="groupby" id="groupby">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="portlet-footer">
                    <!-- <div class="btn-group btn-group-solid pull-right margin-top-10 margin-bottom-10 margin-right-10"> -->
                    <!-- <div class="clearfix pull-right margin-top-10 margin-bottom-10 margin-right-10"> -->
                    <!-- <div class="clearfix margin-top-10 margin-bottom-10 margin-right-10"> -->
                    <button type="button" class="btn blue" onClick="print_d()">
                        <i class="fa fa-lg fa-print"></i> Print</button>
                    <button type="button" class="btn green-dark" onClick="print_xls()">
                        <i class="fa fa-lg fa-file-excel-o"></i> Excel</button>
                    <button type="button" class="btn red" onClick="print_pdf()">
                        <i class="fa fa-lg fa-file-pdf-o"></i> PDF</button>
                    <script>
                        var aData;
                        function print_d(){
                            var sparam = {
                                filtertanggal: aData.filtertanggal,
                                filteritem: aData.filterentry,
                                filterblth: aData.filterblth,
                                filtergroupentry: aData.groupentry,
                                //filterlinkid: aData
                            };

                            if (aData.filtertanggal != 0) {
                                sparam.periode =  $('#tanggal').val();
                                sparam.periode1 = $('#tanggalto').val();
                            }
                            if (aData.filterentry != 0) {
                                sparam.item = $('#filteritem').val();
                                sparam.linkid = aData.linkid;
                            }
                            if (aData.filterblth != 0) {
                                sparam.bulan = $('#bulan').val();
                                sparam.bulanname = $('#bulan :selected').text();
                                sparam.tahun = $('#tahun').val();
                            }
                            if (aData.filtergroupby != 0) {
                                sparam.groupby = $('#groupby').val();
                                sparam.groupdesc = $('#groupby :selected').text();
                            }
                            open('POST', aData.filename+'_prn', sparam, '_blank');
                            //window.open(aData.filename,"_blank");
                            //document.location.href="report_view";
                        }

                        function print_xls() {
                            var sparam = {
                                filtertanggal: aData.filtertanggal,
                                filteritem: aData.filterentry,
                                filterblth: aData.filterblth,
                                filtergroupentry: aData.groupentry,
                                //filterlinkid: aData
                            };

                            if (aData.filtertanggal != 0) {
                                sparam.periode =  $('#tanggal').val();
                                sparam.periode1 = $('#tanggalto').val();
                            }
                            if (aData.filterentry != 0) {
                                sparam.item = $('#filteritem').val();
                                sparam.linkid = aData.linkid;
                            }
                            if (aData.filterblth != 0) {
                                sparam.bulan = $('#bulan').val();
                                sparam.bulanname = $('#bulan :selected').text();
                                sparam.tahun = $('#tahun').val();
                            }
                            if (aData.filtergroupby != 0) {
                                sparam.groupby = $('#groupby').val();
                                sparam.groupdesc = $('#groupby :selected').text();
                            }

                            //window.open("Reportpdf/"+aData.filename+sparam,"_blank");

                            //open('POST', 'Reportpdf/'+aData.filename, {request: {item:"mastika", cols:[2, 3, 34]}}, '_blank');
                            //open('POST', 'Reportpdf/'+aData.filename, sparam, '_blank');
                            //var filename =  aData.filename.substr(0, aData.filename.length-4);
                            //var filename =  aData.filename+'_xls';
                            //console.log(filename);
                            open('POST', aData.filename+'_xls', sparam, '_blank');
                        }

                        function print_pdf() {
                            var sparam = {
                                filtertanggal: aData.filtertanggal,
                                filteritem: aData.filterentry,
                                filterblth: aData.filterblth,
                                filtergroupentry: aData.groupentry,
                                //filterlinkid: aData
                            };

                            if (aData.filtertanggal != 0) {
                                sparam.periode =  $('#tanggal').val();
                                sparam.periode1 = $('#tanggalto').val();
                            }
                            if (aData.filterentry != 0) {
                                sparam.item = $('#filteritem').val();
                                sparam.linkid = aData.linkid;
                            }
                            if (aData.filterblth != 0) {
                                sparam.bulan = $('#bulan').val();
                                sparam.bulanname = $('#bulan :selected').text();
                                sparam.tahun = $('#tahun').val();
                            }
                            if (aData.filtergroupby != 0) {
                                sparam.groupby = $('#groupby').val();
                                sparam.groupdesc = $('#groupby :selected').text();
                            }

                            //window.open("Reportpdf/"+aData.filename+sparam,"_blank");

                            //open('POST', 'Reportpdf/'+aData.filename, {request: {item:"mastika", cols:[2, 3, 34]}}, '_blank');
                            //open('POST', 'Reportpdf/'+aData.filename, sparam, '_blank');
                            open('POST', aData.filename, sparam, '_blank');
                        }

                        jQuery(document).ready(function() {
                            var filteroption = $('.filter-option');

                            /********************* Start bulan-tahun combobox ***************/
                            var arGroupby = ["Jenis Penerimaan","Tanggal"];
                            var arGroupPolabayar = ["select..","KPR","Tunai Keras","Tunai Bertahap"];
                            var arGroupkasbank = ["select..","Penerimaan","Pengeluaran"];
                            var arGroupGL = ["select..","Opening Ballance","General Journal","Akad Jual-Beli","Inventory","Kas-Bank","Fixed Asset","Pembatalan Konsumen"];
                            var arGroupStatusBooking = ['select..','Open','Lock','Akad Kredit','Closed','Batal'];
                            //var arGroupLR = ["Level 2","Level 3","Level 4","Level 5"];
                            var arGroupLR = ["Level 5","Level 4","Level 3","Level 2"];
                            var arbulan = ["Januari","Februari","Maret",'April',"Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
                            var tgl = new Date();
                            var tahun = tgl.getFullYear();
                            var bulan = tgl.getMonth();
                            var option = '';
                            var i;
                            for (i = 0; i < arbulan.length; i++) {
                                option += "<option value='"+(i+1)+"'>"+arbulan[i]+"</option>";
                            }
                            filteroption.find('#bulan').html(option).val(bulan+1);

                            option = '';
                            for (i = 20 - 1; i >= 0; i--) {
                                option += "<option value='"+(tahun-i)+"' data-value="+(tahun-i)+" >"+(tahun-i)+"</option>";
                            }

                            for (i = 1; i < 10; i++) {
                                option += "<option value='"+(tahun+i)+"' data-value="+(tahun+i)+">"+(tahun+i)+"</option>";
                            }
                            filteroption.find('#tahun').html(option).val(tahun);
                            filteroption.find('#tahun').selectpicker('refresh');
                            filteroption.find('[id="dpperiode"]').datepicker('update',tgl);
                            filteroption.find('[id="tanggal"]').val(filteroption.find('#dpperiode').datepicker('getFormattedDate','yyyy-mm-dd'));
                            filteroption.find('[id="dpperiode1"]').datepicker('update',tgl);
                            filteroption.find('[id="tanggalto"]').val(filteroption.find('#dpperiode1').datepicker('getFormattedDate','yyyy-mm-dd'));


                            arbulan = undefined; tgl = undefined; tahun = undefined;
                            /********************* end bulan-tahun combobox ***************/
                            // Periode From Onchange
                            filteroption.on('changeDate','#dpperiode', function(ev){
                                 filteroption.find('#tanggal').val($(this).datepicker('getFormattedDate','yyyy-mm-dd'));
                            });
                            // Periode To Onchange
                            filteroption.on('changeDate','#dpperiode1', function(ev){
                                 filteroption.find('#tanggalto').val($(this).datepicker('getFormattedDate','yyyy-mm-dd'));
                            });

                            // Report On Selected Item
                            $('#tree_report').on("select_node.jstree", function (e, data) {
                                aData = data.node.data;
                                //console.log("Data : ", aData);
                                //aData = $('#tree_report').jstree(true).get_selected(true)[0].data;
                                //aData = $('#tree_report').jstree("get_selected",true)[0].data;
                                if (aData.showfilter == 0) {
                                    $('#filter-body').hide();
                                }
                                else {
                                    $('#filter-body').show();
                                    aData.filterentry == 0 ? $('#filter_item').hide() : $('#filter_item').show();
                                    aData.filterblth == 0 ? $('#filter_blth').hide() : $('#filter_blth').show();
                                    aData.filtertanggal == 0 ? $('#filter_periode').hide() : $('#filter_periode').show();
                                    aData.filtergroupby == 0 ? $('#filter_groupby').hide() : $('#filter_groupby').show();
                                }

                                var groupselected = 0;
                                if (aData.filtergroupby == 1) {
                                    var option = '';
                                    var i = 0;

                                    //rekapitulasi umur piutang
                                    if (aData.noid == 26) {
                                        //add Combo Groupby
                                        for (i = 0; i < arGroupPolabayar.length; i++) {
                                            option += "<option value='"+(i-1)+"'>"+arGroupPolabayar[i]+"</option>";
                                        }
                                    } else if (aData.noid == 33 || aData.noid == 43) { //Kavling
                                        for (i = 0; i < arGroupStatusBooking.length; i++) {
                                            option += "<option value='"+(i-1)+"'>"+arGroupStatusBooking[i]+"</option>";
                                        }
                                        groupselected = -1;
                                    // } else if (aData.noid == 19 || aData.noid == 21 || aData.noid == 28) { //Kas bank
                                    } else if (aData.noid == 2 || aData.noid == 3 || aData.noid == 4 || aData.noid == 14) { //Kas bank
                                        for (i = 0; i < arGroupkasbank.length; i++) {
                                            option += "<option value='"+(i-1)+"'>"+arGroupkasbank[i]+"</option>";
                                        }
                                    } else if (aData.reportmodul == 3) {//GL
                                        if (aData.noid == 10 || aData.noid == 14 || aData.noid == 15) {
                                            for (i = 0; i < arGroupLR.length; i++) {
                                                option += "<option value='"+(arGroupLR.length+(2-i))+"'>"+arGroupLR[i]+"</option>";
                                            }
                                        } else {
                                            for (i = 0; i < arGroupGL.length; i++) {
                                                option += "<option value='"+(i-1)+"'>"+arGroupGL[i]+"</option>";
                                            }
                                        }
                                    } else {
                                        for (i = 0; i < arGroupby.length; i++) {
                                            option += "<option value='"+(i)+"'>"+arGroupby[i]+"</option>";
                                        }
                                    }
                                    filteroption.find('#groupby').html(option).val(groupselected);
                                    filteroption.find('#groupby').selectpicker('refresh');
                                }

                                filteroption.find('#filteritem').val('');
                                filteroption.find('#noid').text('-');
                                filteroption.find('#groupby').val(groupselected);

                                //console.log("Data : ", aData);
                            });

                            // Arguments :
                            //  verb : 'GET'|'POST'
                            //  target : an optional opening target (a name, or "_blank"), defaults to "_self"
                            open = function(verb, url, data, target) {
                              var form = document.createElement("form");
                              form.action = url;
                              form.method = verb;
                              form.target = target || "_self";
                              if (data) {
                                for (var key in data) {
                                  var input = document.createElement("textarea");
                                  input.name = key;
                                  input.value = typeof data[key] === "object" ? JSON.stringify(data[key]) : data[key];
                                  form.appendChild(input);
                                }
                              }
                              form.style.display = 'none';
                              document.body.appendChild(form);
                              form.submit();
                            };

                            // ==================================================//
                            // ================== DRAG & DROP =================== //
                            // ==================================================//
                            filteroption.find('#filteritem').droppable({ //Accept from Search List
                                drop: function( event, ui ) {
                                    //var element = $(event.target); //$(event.toElement); // equivalent to $(ui.helper);
                                    var data = $(ui.draggable).data('value');
                                    // console.log(data, aData);
                                    if (data.flag == aData.groupentry) {
                                        $(this).val(data.description);
                                        filteroption.find('#noid').text('['+data.noid+'] =>'+data.info )
                                        aData.linkid = data.noid;
                                    }
                                    //console.log('Parameter : ',aData);
                                    //$(this).val(data.flag == aData.groupentry ? data.description : '');
                                }
                            });

                        });
                    </script>
                </div> <!-- end of portlet-footer -->
            </div> <!-- end of portlet -->
        </div> <!-- END CONTENT -->
</div> <!-- END CONTENT WRAPPER-->

</body>
