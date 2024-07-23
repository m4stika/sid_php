var handleJurnalextract = function() {
	var handleRecord = function() {
		var table = $('#table_extract');
		var grid = new Datatable();
        var jenisextract = 1;



		grid.init({
			src: table,
			select: false,
			dataTable: {
				"dom": "<'row'<'col-md-8 col-sm-12'p><'table-group-actions pull-right'>r><'table-responsive't><'row'<'col-md-6 col-sm-12'li><'col-md-6 col-sm-12'<'pull-right'p>>>", // datatable layout
				//"dom": "<'row'<'col-md-8 col-sm-12'p><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r><'table-responsive't><'row'<'col-md-8 col-sm-12'li><'col-md-4 col-sm-12'<'pull-right'p>>>", // datatable layout
				"lengthMenu": [
                        [10, 20, 50, 100, 150, -1],
                        [10, 20, 50, 100, 150, "All"] // change per page values here
                    ],
                "pageLength": 10, // default record count per page
                "order" : [],
                //"processing": true,
                "columnDefs": [
                        {  "targets": [0], "orderable": false, "className": "details-control dt-head-center" },
                        {  "targets": [1], "className": "dt-body-right dt-head-center" },
                        {  "targets": [2], "className": "dt-head-center" },
                        {
                            "targets": [3],
                            "type" : "date",
                            "className": "dt-head-center",
                            "render": function (data) {
                                if (data !== null) {
                                    var date = new Date(data);
                                    //var bulan = date.getMonth()+1;
                                    var month = date.getMonth() + 1;
                                    var tanggal = date.getDate();
                                    //console.log(month);
                                    date = ((tanggal > 9) ? tanggal : "0" + tanggal) + "/" + ((month > 9) ? month : "0" + month) + "/" + date.getFullYear();
                                    //date = date.getDate()+"-"+bulan+"-"+date.getFullYear();
                                    return "<div class= date>"+date+"<div>";
                                } else {
                                    return "";
                                }
                            }
                        },
                        {   "targets": [4,5],
                            "className": "dt-head-center"
                        },
                        {
                            "targets": [6],
                            "render": $.fn.dataTable.render.number( '.', ',', 2, '' ),
                            "className": 'dt-body-right dt-head-center info bold',
                            "type": "num"
                        },
                        //{ "targets": [4,5,6,7], "visible": false,"searchable": false},
                    ],
                "ajax": {
                	type: "post",
                    dataType: "json",                 
                    url: "get_listextractKB",
                   // data: function(d) {d.flag = $('#actionflag', $('.row_extract')).val()},
                    //data: {flag: 1},
                    error: function (xhr, error, thrown) {
                                $('.row_extract .info').html(xhr.responseText);
                                console.log(xhr.responseText);
                            },
                },
                "fnDrawCallback": function( settings ) {
			        //var api = this.api();
			        var info = this.api().page.info();
			        //var data = settings.json;
			 
			        (info.recordsDisplay > 0) ? $('.save',$('.row_extract')).removeAttr('disabled') : $('.save',$('.row_extract')).prop('disabled','disabled');
			    }
			}
		})

        grid.setAjaxParam("customFilter", true);

		// handle filter cancel button click
        table.on('click', '.filter-cancel', function(e) {
            e.preventDefault();            
            grid.setAjaxParam("customFilter", true);
            grid.setAjaxParam("flag", jenisextract);
             $('#extracttype', $('.row_extract')).val(jenisextract);
            grid.getDataTable().ajax.reload(); 
        });

        // // handle filter submit button click
        // table.on('click', '.filter-submit', function(e) {
        //     e.preventDefault();
        //     //$('#actionflag', $('.row_extract')).val($('select[name=extracttype]', $('.row_extract')).val());
        // });

        // handle filter submit button click
        $('#extracttype').on('change',function(e) {
            e.preventDefault();
            grid.setAjaxParam("flag", $(this).val());
            //$('#actionflag', $('.row_extract')).val($(this).val());
            jenisextract = $(this).val();
            grid.setAjaxParam("customFilter", true);
            //console.log('flag :',$(this).val());
            grid.getDataTable().ajax.reload();// clear().draw();
        });

		// Tanggal from Onchange
        $('#table_extract').on('changeDate','#dttglextractfrom', function(ev){
            $('#tglextract',$('#table_extract')).val($('#dttglextractfrom').datepicker('getFormattedDate','yyyy-mm-dd'));
            if($('#tglextractto').val() == ""){
            //if ($('#tglextractto').html() == "") {
              $('#tglextractto',$('#table_extract')).val($('#dttglextractfrom').datepicker('getFormattedDate','yyyy-mm-dd'));
            }
            
            //console.log($('#tglpembayaran').val());
        });

        // Tanggal to Onchange
        $('#table_extract').on('changeDate','#dttglextractto', function(ev){
            $('#tglextractto',$('#table_extract')).val($('#dttglextractto').datepicker('getFormattedDate','yyyy-mm-dd'));
            //console.log($('#tglpembayaran').val());
        });

        //save Button Click
        $('.save', $('.row_extract')).on('click',function(e){
            e.preventDefault();
            aData = grid.getRowsID();
            //console.log('rows : ',aData);
            if (aData) {
                grid.setAjaxParam("customActionType", "extract");
                grid.setAjaxParam("customActionFlag", jenisextract);
                grid.setAjaxParam("id", aData);
                grid.getDataTable().ajax.reload();
                grid.clearAjaxParams();
            } else  {
                App.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'Tidak ada data yang di proses',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            }
        });

		function fnFormatDetails(table_id, html) {
		    var sOut = "<table id=\"exampleTable_" + table_id + "\">";
		    sOut += html;
		    sOut += "</table>";
		    return sOut;
		}

		var oTable = table.dataTable();
		var detailsTableHtml = $("#table_jurnaldetil").html();
		table.on('click','tbody td img', function () {
            var nTr = $(this).parents('tr')[0];
            var aData = grid.getData(nTr);
            if (oTable.fnIsOpen(nTr)) {
                /* This row is already open - close it */
                this.src = siteurl+"assets/pages/img/plus.png"; //"http://i.imgur.com/SD7Dz.png";
                oTable.fnClose(nTr);
                //console.log('close');
            }
            else {
                /* Open this row */
                //console.log('open');
                this.src = siteurl+"assets/pages/img/minus.png"; //"http://i.imgur.com/d4ICC.png";
                //oTable.fnOpen(nTr,"Details row opened :"+aData[1], "details" );
                oTable.fnOpen(nTr, fnFormatDetails(aData[1], detailsTableHtml), 'details');
                oInnerTable = $("#exampleTable_" + aData[1]).dataTable({
                    //"dom": "<'row'<'col-md-1'><'col-md-10'<'table-responsive't>><'col-md-1'>>",
                     "dom": "<'table-responsive't>",
                    "ordering": false,
                    //"bJQueryUI": true,
                    "columnDefs": [
                        //{  "targets": [1], "className": "dt-body-right dt-head-center" },
                       
                        {   "targets": [1,2,3],
                            "className": "dt-head-center"
                        },
                        {
                            "targets": [4],
                            "render": $.fn.dataTable.render.number( '.', ',', 2, '' ),
                            "className": 'dt-body-right dt-head-center info',
                            "type": "num"
                        },
                        //{ "targets": [4,5,6,7], "visible": false,"searchable": false},
                    ],
                    "ajax": {
	                    type: "post",      
	                    dataType: "json",        
	                    dataSrc: function ( json ) {
	                        return json;
	                    },
	                    url: "get_extractDetilKB",
	                    data: function (d) {
	                        d.noid = aData[1],
	                        d.flag = jenisextract

	                    }, //document.getElementById("selectWarehouse").value ,
	                    error: function (xhr, error, thrown) {
	                                var htoastr = new myToastr(xhr['responseText'], "<h2>Error</h2> <hr>")
	                                htoastr.toastrError()
	                            },
	                },
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
		                    .column( 4 )
		                    .data()
		                    .reduce( function (a, b) {
		                        return intVal(a) + intVal(b);
		                    }, 0 );
		     
		                // Total over this page
		                pageTotal = api
		                    .column( 4, { page: 'current'} )
		                    .data()
		                    .reduce( function (a, b) {
		                        return intVal(a) + intVal(b);
		                    }, 0 );
		     
		                // Update footer
		                $( api.column( 4 ).footer() ).html(
		                    'Rp. '+ total.format(2, 3, '.', ',')
		                    //pageTotal +' ( $'+ total +' total)'
		                );
		            },
                });
            }
        });
	}


	return {
		init: function() {
			handleRecord();
		}
	}
}()

jQuery(document).ready(function() {
    handleJurnalextract.init();
});