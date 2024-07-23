var kasformEditable = function () {

    var handleTable = function () {
        
        function editRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            jqTds[4].innerHTML = '<input type="text" class="form-control" value="' + aData[4] + '">';
            jqTds[5].innerHTML = '<input type="number" class="form-control" value="' + aData[5] + '">';
            // jqTds[4].innerHTML = '<a class="edit" href="">Save</a>';
        }

        function saveRow(oTable, nRow) {
            var jqInputs = $('input', nRow);
            oTable.fnUpdate(jqInputs[0].value, nRow, 4, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 5, false);
            oTable.fnDraw();
        }

        $('body').toggleClass('page-quick-sidebar-open'); 

        var table = $('#table_entrykb');
        $('#noid',$('.row_kasbank')).val(-1);
        //var idkasbank = $('#noid',$('.row_kasbank')).val();

        var nTable = table.DataTable({
            "dom": 't',
           // "dom": "<'row'<'col-md-12'<t>>>", // datatable layout

            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],

            // set the initial value
           "pageLength": 30,
            "ordering": false,

            "language": {
                "lengthMenu": " _MENU_ records"
            },
            "columnDefs": [
                // { "sName": "rekid", "aTargets": [ 0 ] },
                // { "sName": "accountno", "aTargets": [ 1 ] },
                // { "sName": "description", "aTargets": [ 2 ] },
                // { "sName": "uraian", "aTargets": [ 3 ] },
                // { "sName": "jumlahrp", "aTargets": [ 4 ] },
                {
                    "targets": [5],
                    "render": $.fn.dataTable.render.number( '.', ',', 2, '' ),
                    "className": 'dt-right bold',                        
                    "type": "num"
                },
                {
                    "targets": [1,2,3],
                    "className": 'bg-warning'                          
                },
                
               // { "targets": [1], "visible": false,"searchable": false},
            ],
            "columns": [
                { "name": "action"},
                { "name": "rekid"},
                { "name": "accno"},
                { "name": "description"},
                { "name": "remark"},
                { "name": "amount"}
            ],
           
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
     
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
     
                // Total over all pages
                total = api
                    .column( 5 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
     
                // Total over this page
                pageTotal = api
                    .column( 5, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
     
                // Update footer
                $( api.column( 5 ).footer() ).html(
                    'Rp. '+ total.format(2, 3, '.', ',')
                    //pageTotal +' ( $'+ total +' total)'
                );

                $('#form_jurnalkb #totaltransaksi').val(total);
                (total <= 0) ? $('.row_kasbank .save').attr('disabled','disabled') : $('.row_kasbank .save').removeAttr('disabled');
                if (total > 0) $('#totaltransaksi', $('.row_kasbank')).valid();
            },
            //"bProcessing": true,
            //"serverSide": true,
            //"deferRender": true,
            "ajax": {
                    type: "post",      
                    dataType: "json",        
                    //dataSrc: "jurnalDetail",      
                    dataSrc: function ( json ) {
                        //console.log(json['jurnalHeader']);
                        //console.log(json['jurnalDetail']);
                        if (json['jurnalHeader']) handleHeader(json['jurnalHeader'])
                        return json['jurnalDetail'];
                    },
                    url: "get_jurnalKB",
                    data: function (d) {
                        d.noid = $('#noid',$('.row_kasbank')).val(),
                        d.crud = $('#crud',$('.row_kasbank')).val()

                    }, //document.getElementById("selectWarehouse").value ,
                    error: function (xhr, error, thrown) {
                                var htoastr = new myToastr(xhr['responseText'], "<h2>Error</h2> <hr>")
                                htoastr.toastrError()
                            },
                },
            
        });
        var oTable = table.dataTable();

      //  $('.icheck-inline input').iCheck({
      //   radioClass: 'iradio_flat-red'
      // });

        function handleHeader(aData) {
            $('#form_jurnalkb')
                .find('[name="noid"]').val(aData.noid).end()
                .find('[name="nobukti"]').val(aData.nobukti).end()
                .find('[name="nomorcek"]').val(aData.nomorcek).end()
                .find('[name="uraian"]').val(aData.uraian).end()
                .find('[id="penerimaan"]').prop('checked',(aData.kasbanktype == 0 || aData.kasbanktype == 2) ? true : false).end()
                .find('[id="Pengeluaran"]').prop('checked',(aData.kasbanktype == 1 || aData.kasbanktype == 3) ? true : false).end()
                .find('[id="statusKB"]').val((aData.kasbanktype == 0 || aData.kasbanktype == 1) ? "Cash" : "Bank").end()
                .find('[id="dptgljurnal"]').datepicker('update',aData.tgltransaksi).end()
                .find('[id="tgltransaksi"]').val($('#dptgljurnal').datepicker('getFormattedDate','yyyy-mm-dd')).end()
                //.find('[id="tgltransaksi"]').val(aData.tgltransaksi).end()
                $('.icheck-inline input').iCheck('update');
                $('select[name=rekidkas]').selectpicker('val',(aData.kasbanktype == 0 || aData.kasbanktype == 1) ? aData.rekid : -1);
                $('select[name=rekidbank]').selectpicker('val',(aData.kasbanktype == 2 || aData.kasbanktype == 3) ? aData.rekid : -1);
                (aData.kasbanktype == 0 || aData.kasbanktype == 1) ? $('#selectrekid').selectpicker('show') : $('#selectrekid').selectpicker('hide');
                (aData.kasbanktype == 2 || aData.kasbanktype == 3) ? $('#selectrekidbank').selectpicker('show') : $('#selectrekidbank').selectpicker('hide');
                (aData.kasbanktype == 0 || aData.kasbanktype == 1) ? $('.row_kasbank > .portlet > .portlet-title > .caption > span').text('Cash') : $('.row_kasbank > .portlet > .portlet-title > .caption > span').text('Bank');
                (aData.kasbanktype == 0 || aData.kasbanktype == 1) ? $('.page-breadcrumb > li > span').text('Cash') : $('.page-breadcrumb > li > span').text('Bank');
                
        }

        //var tableWrapper = $("#sample_editable_1_wrapper");
        

        var nEditing = null;
        var nNew = false;

        $('#sample_editable_1_new').click(function (e) {
            e.preventDefault();

            if (nNew && nEditing) {
                if (confirm("Previose row not saved. Do you want to save it ?")) {
                    saveRow(oTable, nEditing); // save
                    $(nEditing).find("td:first").html("Untitled");
                    nEditing = null;
                    nNew = false;

                } else {
                    oTable.fnDeleteRow(nEditing); // cancel
                    nEditing = null;
                    nNew = false;
                    
                    return;
                }
            }

            var aiNew = oTable.fnAddData(['', '', '', '', '', '']);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            editRow(oTable, nRow);
            nEditing = nRow;
            nNew = true;
        });

        //Reset Button Click
        $('.reset', $('.row_kasbank')).on('click',function(e){
            e.preventDefault();
            $('#form_jurnalkb').trigger('reset');
            $("#form_jurnalkb").validate().resetForm();
            $('.form-group').removeClass('has-error');
            nTable.clear().draw();
            //nTable.ajax.reload();
            //console.log($('#noid',$('.row_kasbank')).val());
        });

        //Delete Button Click on Table
        table.on('click', '.delete', function (e) {
            e.preventDefault();

            if (confirm("Are you sure to delete this row ?") == false) {
                return;
            }

            var nRow = $(this).parents('tr')[0];
            oTable.fnDeleteRow(nRow);
            //alert("Deleted! Do not forget to do some ajax to sync with backend :)");
        });

        //table.on('click', 'tbody > tr > td:nth-child(3), tbody > tr > td:nth-child(4)', function(e) {
        table.on('click', 'tbody > tr > td:nth-child(n+2)', function(e) {    //Click td Except Column-0
            //:nth-child(n+2) and :nth-last-child(n+2): Not First Col and Last Col
            e.preventDefault();

            nNew = false;
            index = table.DataTable().cell( this ).index().column;

            if (index <= 3) {
                if (nEditing !== null) {
                    saveRow(oTable, nEditing);
                    nEditing = null;
                }
                return false;
            }
            
            /* Get the row as a parent of the link that was clicked on */
            var nRow = $(this).parents('tr')[0];
            if (nEditing == nRow && this.innerHTML !== "Save") return false;

            if (nEditing !== null && nEditing != nRow) {
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                //restoreRow(oTable, nEditing);
                saveRow(oTable, nEditing);
               // addRowHidden(oTable, nEditing);
                editRow(oTable, nRow);
                nEditing = nRow;
            } else if (nEditing == nRow && this.innerHTML == "Save") {
                /* Editing this row and want to save it */
                saveRow(oTable, nEditing);
                nEditing = null;
                alert("Updated! Do not forget to do some ajax to sync with backend :)");
            } else {
                /* No edit in progress - let's start one */
                editRow(oTable, nRow);
                nEditing = nRow;
            }
        });

        // Tanggal Pembayaran Onchange
        $('#form_jurnalkb').on('changeDate','#dptgljurnal', function(ev){
            $('#tgltransaksi',$('#form_jurnalkb')).val($('#dptgljurnal').datepicker('getFormattedDate','yyyy-mm-dd'));
            //console.log($('#tglpembayaran').val());
        });

        

        //tab-pane change
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var activeTab = $(".row_kasbank ul li.active").attr('id');
          //console.log(activeTab);
          (activeTab == 'history') ? $('.row_kasbank .save, .row_kasbank .reset').attr('disabled','disabled') : $('.row_kasbank .save, .row_kasbank .reset').removeAttr('disabled');

        });


        //==============Form Validation================//
        var urls = siteurl+"Kasbank/kasbank/save_jurnal";
        $('#form_jurnalkb').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            ignore: ":hidden",
            ignore:[],
            rules: {                
                selecttyperumah: {
                    required: true
                },
                tgljurnal: {
                    required: true
                },
                nobukti: {
                    required: true
                },
                uraian: {
                    required: true
                },
                totaltransaksi: { 
                    required: true, min: 1
                }
            },
            messages:
            {
                selecttyperumah: {required: "Nama Kas/Bank perlu diisi"},
                tgljurnal:{
                      required: "Tanggal Transaksi harus diisi"
                        },
                totaltransaksi: {min: "tidak ada nilai transaksi, mohon isi rincian jurnal"},
            },
            highlight: function(element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
                $('.row_kasbank .save').attr('disabled','disabled');
            },
            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();                     
            },
            
            submitHandler: function(e){
                if ($('#form_jurnalkb #totaltransaksi').val() <= 0) {
                    //console.log('Tidak ada Nilai Transaksi');
                    return false;    
                }
                
                if (nEditing !== null) saveRow(oTable, nEditing);
                //var dataDetail = oTable.fnGetData();
                var cols = table.fnSettings().aoColumns,
                    rows = table.fnGetData();

                var result = $.map(rows, function(row) {
                    var object = {};
                    for (var i=row.length-1; i>=0; i--)
                        // running backwards will overwrite a double property name with the first occurence
                        object[cols[i].name] = row[i]; // maybe use sName, if set
                    return object;
                });
                var detailstr = JSON.stringify(result);
                //var detailstr1 = JSON.stringify(rows);
                var dataHeader = $('#form_jurnalkb').serialize()+"&detail="+detailstr; //$('#form_jurnalkb').serializeObject();
                //console.log('detailstr', detailstr);
                //console.log('rows', detailstr1);
                //return false;
                //dataDetail = result;

                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: siteurl+"Kasbank/kasbank/save_jurnal", 
                    data: dataHeader, //{data, dataTable: datatable},
                    //data: {dataHeader: dataHeader, dataDetail: detailstr},
                    error: function (xhr, error, thrown) {                                  
                             var htoastr = new myToastr(xhr['responseText'], "<h3>Error Save</h3> <hr>");
                             htoastr.toastrError();
                            },
                    success: function(result) { 
                            //var htoastr = new myToastr("Export has been Complated..", "<h3>SID | Export</h3> <hr>");
                            var htoastr = new myToastr(result, "<h3>SID | Save </h3> <hr>");
                            htoastr.toastrSuccess();
                            $('#table_history_jurnalKB').DataTable().ajax.reload();
                            $('.reset', $('.row_kasbank')).click();
                        }
                });
                detailstr = null;
                dataHeader = null;
                return false;
            }
        });
        //==============End of Form Validation================//


        // ==================================================//
        // ================== DRAG & DROP =================== //
        // ==================================================//
        $( "#table_entrykb" ).droppable({
            // classes: {
            //     "ui-droppable-active": "ui-state-active",
            //     "ui-droppable-hover": "ui-state-hover"
            //   },
            drop: function( event, ui ) {
                var element = $(event.target); //$(event.toElement); // equivalent to $(ui.helper);
                if (element.closest('table').length) {
                    var data = $(ui.draggable).data('value');
                    oTable.fnAddData(["<a class='delete label label-sm label-info' data-value=''>delete</a>",
                                    data.noid, data.accountno, data.description, "", 0
                                    ]);
                }
            }
        });

        $(document)
            .on('dnd_move.vakata', function (e, data) {
                var t = $(data.event.target);
                if (!t.closest('.jstree').length) {
                    if (t.closest('.drop-item').length) {
                        data.helper.find('.jstree-icon').removeClass('jstree-er').addClass('jstree-ok');
                    } else {
                        data.helper.find('.jstree-icon').removeClass('jstree-ok').addClass('jstree-er');
                    }
                } else  data.helper.find('.jstree-icon').removeClass('jstree-ok').addClass('jstree-er'); 
            })
            .on('dnd_stop.vakata', function (e, data) {
                var t = $(data.event.target);
                //var elm = '#'+t.closest('table').attr('id');
                if (!t.closest('.jstree').length) {
                    if (t.closest('table').length) {
                        var data = data.data.origin.get_node(data.element).data;
                        if (data.classacc == 1) {
                            oTable.fnAddData(["<a class='delete label label-sm label-info' data-value=''>delete</a>",
                                data.noid, data.accountno, data.description, "", 0
                                //'<input type="hidden" value="0" name="detailnilai[nilairp_' + rowcount + ']" id="nilairp_' + rowcount + '">',
                                //'<input type="hidden" value="'+data.noid+'" name="detilrekid[rekid_' + rowcount + ']" id="rekid_' + rowcount + '">',
                                ]);
                                
                        }
                    }
                }
            });
        // End of DRAG & DROP =======================
    }

    var handleHistory = function() {
        var table = $('#table_history_jurnalKB');
        //if (table) table.DataTable().destroy();
        
        var grid = new Datatable();
        // if ($.fn.dataTable.isDataTable( '#table_history_jurnalKB' ) ) { }
        if (table) {    
            grid.init({
                src: $('#table_history_jurnalKB'),
                onSuccess: function(grid) {},
                onError: function (grid) {},
                loadingMessage: 'loading...',
                dataTable: {
                    "destroy": true,
                    "dom": "<'row'<'col-md-8 col-sm-12'p><'col-md-4 col-sm-12'f<'table-group-actions pull-right'>>r><'table-responsive't><'row'<'col-md-8 col-sm-12'li><'col-md-4 col-sm-12'<'pull-right'p>>>", // datatable layout
                    //"pageResize": true,  // enable page resize
                    //"processing": true,
                    //"serverSide": true,
                    "language": {
                        //"processing": "<img src='loader.gif'/>
                    },
                    "lengthMenu": [
                        [10, 20, 50, 100, 150, -1],
                        [10, 20, 50, 100, 150, "All"] // change per page values here
                    ],
                    "columnDefs": [
                        {  "targets": [0], "orderable": false, "className": "dt-body-right dt-head-center" },
                        {  "targets": [1], "className": "dt-body-right dt-head-center" },
                        {
                            "targets": [3],
                            "type" : "date",
                            "className": "dt-head-center",
                            "render": function (data) {
                                if (data !== null) {
                                    var date = new Date(data);
                                    var month = date.getMonth() + 1;
                                    var tanggal = date.getDate();
                                    date = ((tanggal > 9) ? tanggal : "0" + tanggal) + "/" + ((month > 9) ? month : "0" + month) + "/" + date.getFullYear();
                                    //date = date.getDate()+"-"+bulan+"-"+date.getFullYear();
                                    return "<div class= date>"+date+"<div>";
                                } else {
                                    return "";
                                }
                            }
                        },
                        {   "targets": [4,5,7],
                            "className": "dt-head-center"
                        },
                        {
                            "targets": [6],
                            "render": $.fn.dataTable.render.number( '.', ',', 0, '' ),
                            "className": 'dt-body-right dt-head-center info bold',
                            "type": "num"
                        },
                        //{ "targets": [4,5,6,7], "visible": false,"searchable": false},
                    ],
                    "pageLength": 10, // default record count per page
                    "ajax": {
                        type: "post",
                        dataType: "json",                 
                        url: "get_ListjurnalKB",
                        //data: {idpemesanan: noidpemesanan},
                        error: function (xhr, error, thrown) {
                                    $('.row_kasbank .info').html(xhr.responseText);
                                    console.log('error');
                                },
                        //success: function() {console.log('sukses ajax')}
                    },
                    //"pagingType": "simple_numbers",
                    "order": []
                }
            })

            
        } else {
            grid.getDataTable().ajax.reload();
        }

        grid.setAjaxParam("customFilter", true);

        // handle filter cancel button click
        table.on('click', '.filter-cancel', function(e) {
            grid.setAjaxParam("customFilter", true);
        });

        // Tanggal from history Filter Onchange
        $('#table_history_jurnalKB').on('changeDate','#tglhistoryfrom', function(ev){
            $('#tgltransaksi',$('#table_history_jurnalKB')).val($('#tglhistoryfrom').datepicker('getFormattedDate','yyyy-mm-dd'));
            //console.log($('#tglpembayaran').val());
        });

        // Tanggal to history Filter Onchange
        $('#table_history_jurnalKB').on('changeDate','#tglhistoryto', function(ev){
            $('#tgltransaksi1',$('#table_history_jurnalKB')).val($('#tglhistoryto').datepicker('getFormattedDate','yyyy-mm-dd'));
            //console.log($('#tglpembayaran').val());
        });

        

        //Edit & copy
        $('.row_kasbank').on('click', '.table-toolbar > .edit, .table-toolbar > .copy', function(e) {
            var aData = grid.getSelectedRows();
            handleEditCopy(e, aData[1]);            
        });
        
        grid.getTable().on('click', '.edit, .copy', function(e) {
            var aData = grid.getData($(this).parents('tr')[0]);
            handleEditCopy(e, aData[1])
        });

        function handleEditCopy(e, noid) {
            if ($(e.target).hasClass('edit')||$(e.target).parent().hasClass('edit')) { 
                $('#form_jurnalkb #crud').val("edit");
            } else {
                $('#form_jurnalkb #crud').val("copy");
            }

            $('#noid',$('.row_kasbank')).val(noid);
            $('#table_entrykb').DataTable().ajax.reload();
            $('#detil a:last').tab('show');
        }

        //Edit & copy
        $('.row_kasbank').on('click', '#tab_history > .table-container > .table-toolbar > .new', function(e) {
            $('.reset', $('.row_kasbank')).click();
            $('#detil a:last').tab('show');
        });

        //Delete
        $('.row_kasbank').on('click', '.table-toolbar > .delete, .table-toolbar > .delete', function(e) {
            var aData = grid.getSelectedRows();
            handleDelete(e, aData);
        });
        grid.getTable().on('click', '.delete', function (e) {
            var aData = grid.getData($(this).parents('tr')[0])
            handleDelete(e, aData);
        });

        function handleDelete(e, aData) {
            e.preventDefault();
            
            bootbox.confirm( {
               // size: 'small',
                closeButton: false,
                title: 'SID - Delete Record',
                message: "yakin mau menghapus data : "+aData[4]+" ? ",
                buttons: {
                    'confirm': {
                        label: 'Delete',
                        className: 'btn-danger'
                    },
                    'cancel': {
                        label: 'Cancel',
                        className: 'btn-primary'
                    }
                },              
                    
                callback: function(result) {
                    if(result) {
                        $.ajax({
                        type: "post",
                        url: "delete_jurnal",
                        data: { noid: aData[1]},
                        dataType: 'JSON',
                        error: function (xhr, error, thrown) {                                  
                                var htoastr = new myToastr(xhr['responseText'], "<h3>Error Delete Record</h3> <hr>");
                                htoastr.toastrError();
                                },
                        success: function(result) { 
                                var htoastr = new myToastr("Record has been deleted..", "<h3>SID | Delete</h3> <hr>");
                                htoastr.toastrSuccess();
                                grid.getDataTable().ajax.reload();
                            }
                        });
                        
                    }else {
                        var htoastr = new myToastr("Deleting record canceled", "<h3>SID | Delete</h3> <hr>");
                        htoastr.toastrInfo();
                    }
                }
            }); 
        }


        // Resize the demo table container with mouse drag
        // var wrapper = $('.table-container');
        // $('#resize_handle').on( 'mousedown', function (e) {
        //     var mouseStartY = e.pageY;
        //     var resizeStartHeight = wrapper.height();
         
        //     $(document)
        //         .on( 'mousemove.demo', function (e) {
        //             var height = resizeStartHeight + (e.pageY - mouseStartY);
        //             if ( height < 200 ) {
        //                 height = 200;
        //             }
         
        //             wrapper.height( height );
        //         } )
        //         .on( 'mouseup.demo', function (e) {
        //             $(document).off( 'mousemove.demo mouseup.demo' );
        //         } );
         
        //     return false;
        // } );
        
    };

    return {

        //main function to initiate the module
        init: function () {
            handleTable();
            handleHistory();
        }

    };

}();

jQuery(document).ready(function() {
    kasformEditable.init();
});