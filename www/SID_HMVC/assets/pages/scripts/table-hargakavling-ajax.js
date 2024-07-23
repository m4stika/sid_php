var TableDatatablesEditable = function () {

    var handleTable = function () {

        function restoreRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);

            for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                oTable.fnUpdate(aData[i], nRow, i, false);
            }

            oTable.fnDraw();
        }

        function editRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);            
            //jqTds[1].innerHTML = '<input type="text" class="form-control input-small" readonly value="' + aData[1] + '">';
			jqTds[7].innerHTML = '<input type="number" step="1" class="form-control input-small entry-onchange" value="' + (aData[7]*1) + '">';
            jqTds[8].innerHTML = '<input type="text" class="form-control input-small" value="' + (aData[8]) + '">';
            jqTds[12].innerHTML = '<input type="number" pattern="[0-9]+([,\.][0-9]+)?" class="form-control input-small entry-onchange" value="' + (aData[12]*1) + '">';
            jqTds[15].innerHTML = '<input type="text" class="form-control input-small" value="' + (aData[15]) + '">';
            //jqTds[19].innerHTML = '<a class="edit" href="">Save</a>';
            //jqTds[20].innerHTML = '<a class="cancel" href="">Cancel</a>';
			jqTds[19].innerHTML = '<a class="edit" href="">Save</a> <a>&nbsp;&nbsp;&nbsp</a> <a class="cancel" href="">Cancel</a>';
            
        }

        function saveRow(oTable, nRow) {
            var jqInputs = $('input', nRow);
			//console.log(jqInputs);
           // oTable.fnUpdate(jqInputs[0].value, nRow, 1, false);
            oTable.fnUpdate(jqInputs[0].value, nRow, 7, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 8, false);
            oTable.fnUpdate(jqInputs[2].value, nRow, 12, false);
			oTable.fnUpdate(jqInputs[3].value, nRow, 15, false);			
            oTable.fnUpdate('<a class="edit" href="">Edit</a>', nRow, 19, false);
           // oTable.fnUpdate('', nRow, 20, false);
			//oTable.fnUpdate('<a class="edit" href="">Edit</a> <a>&nbsp;&nbsp;&nbsp</a> <a class="cancel" href="">Cancel</a>', nRow, 14, false);
           // oTable.fnUpdate('<a class="delete" href="">Delete</a>', nRow, 16, false);
            oTable.fnDraw();
        }

        function cancelEditRow(oTable, nRow) {
            var jqInputs = $('input', nRow);
            oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
            oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
            oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
            oTable.fnUpdate('<a class="edit" href="">Edit</a> <a>&nbsp;&nbsp;&nbsp</a> <a class="cancel" href="">Cancel</a>', nRow, 4, false);
            oTable.fnDraw();
        }

        var table = $('#sample_editable_1');

        var oTable = table.dataTable({

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "language": {
					"decimal": "",
					"thousands": ",",
					"aria": {
						"sortAscending": ": activate to sort column ascending",
						"sortDescending": ": activate to sort column descending"
					},								
					"emptyTable": "No data available in table",                
					"infoEmpty": "No entries found",
					"infoFiltered": "(filtered1 from _MAX_ total entries)",                
					"search": "Search:",
					"zeroRecords": "No matching records found",
					"processing": "<span class=\"glyphicon glyphicon-refresh glyphicon-refresh-animate\"></span> Loading data, Please wait..." 					
				},
                
                "bProcessing": true,
				"bServerSide": true,
				"deferRender": true,				
				//"bStateSave": true, //save datatable state(pagination, sort, etc) in cookie.
				"select": true,
                "lengthMenu": [
                    [5,10, 20, 50, 100, 150, -1],
                    [5,10, 20, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": 10, // default record count per page
								
				"columnDefs": [ {
					  "targets": [0,6,7,8,9,10,11,12,13,14,15,16,17,18,19],
					  "orderable": false,
					  "searchable": false					 
					},					
					// {
					// 	"targets": [3,4],
					// 	"render": $.fn.dataTable.render.number( '.', ',', 2, '' ),
					// 	"className": 'dt-right'
					// },
					{
						"targets": [6,7,8,9,10,11,12,13,14,15,16,17,18],
						"render": $.fn.dataTable.render.number( '.', ',', 0, '' ),
						"className": 'dt-right',						
						"type": "num"
					},
					// {
					// 	"targets": [13],
					// 	"type": "num",
					// 	"render": function ( data, type, row ) {
					// 		//console.log(row);
					// 		//return Math.round( ( row[6] ) + (row[7]));
					// 		var hasil =  Math.round((row[6] * 1) + (row[10] * 1) + (row[11] * 1) + (row[12] * 1));
					// 		var num = $.fn.dataTable.render.number( '.', ',', 0, '' ).display(hasil);
					// 		return num; //row[6].replace(/[\.,]/g, '') + row[7].replace(/[\.,]/g, '');
					// 	},
					// 	"className": 'dt-right'
					// }
					
					
					],
                "ajax": {
                    type: "post",
                    dataType: "json",
					//url: "../form/pemasaran_hargakavling_data.php", // ajax source                    
                    url: siteurl+"Pemasaran/harga_kavling/get_list",
					error: function (xhr, error, thrown) {
								console.log(xhr);
                                $('.m-heading-1 > p').html(xhr.responseText)
							}
                },
				buttons: [
                    { extend: 'print', className: 'btn default' },
                    { extend: 'copy', className: 'btn default' },
                    { extend: 'pdf', className: 'btn default' },
                    { extend: 'excel', className: 'btn default' },
                    { extend: 'csv', className: 'btn default' },
                    {
                        text: 'Reload',
                        className: 'btn default',
                        action: function ( e, dt, node, config ) {
                            dt.ajax.reload();                           
                        }
                    }
                ],
                "order": [
                     [4, "asc"]
                ]// set first column as a default sort by asc
        });

        var tableWrapper = $("#sample_editable_1_wrapper");

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
        
        table.on('click', '.cancel', function (e) {
            e.preventDefault();
            if (nNew) {
                oTable.fnDeleteRow(nEditing);
                nEditing = null;
                nNew = false;
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
        });

        table.on('change','.entry-onchange', function(e) {
            e.preventDefault();
            var nRow = $(this).parents('tr')[0];
            var aData = oTable.fnGetData(nRow);
            var jqInputs = $('input', nRow);

            oTable.fnUpdate((jqInputs[2].value * (aData[11]*1)) , nRow, 13, false); //Total harga Sudut
            var totharga = ((aData[6]*1) - jqInputs[0].value) + (aData[13]*1) + (aData[16]*1) + (aData[17]*1);            
            oTable.fnUpdate(totharga , nRow, 18, false); //TOTAL HARGA
           // console.log($(this).val());
        });

        table.on('click', '.edit', function (e) {
            e.preventDefault();
            nNew = false;
            
            /* Get the row as a parent of the link that was clicked on */
            var nRow = $(this).parents('tr')[0];

            if (nEditing !== null && nEditing != nRow) {
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                restoreRow(oTable, nEditing);
                editRow(oTable, nRow);
                nEditing = nRow;
            } else if (nEditing == nRow && this.innerHTML == "Save") {
                /* Editing this row and want to save it */
              //  saveRow(oTable, nEditing);			                  
				var jqInputs = $('input', nRow);
				var aData = oTable.fnGetData(nRow);
				console.log(oTable.fnGetData(nRow)[1]);
                //alert("Updated! Do not forget to do some ajax to sync with backend :)");
				bootbox.confirm( {
				   // size: 'small',
					closeButton: false,
					title: 'SID - Update Record',
					//message: "yakin mau menyimpan Perubahan data : "+aData[2]+" ? ",
					message: "yakin mau menyimpan Perubahan data ? ",
					buttons: {
						'cancel': {
							label: 'Cancel',
							className: 'btn-default'
						},
						'confirm': {
							label: 'Process',
							className: 'btn-danger'
						}
					},				
						
					callback: function(result) {
						//result will be true if button was click, while it will be false if users close the dialog directly.
						if(result) {
							$.ajax({
							type: "post",
							url: siteurl+"Pemasaran/harga_kavling/set_update", // ajax source
							data: { noid: aData[1],
									diskon: jqInputs[0].value,
									alasandiskon: jqInputs[1].value,
									hargakltm2: jqInputs[2].value,
									alasandiskonsudut: jqInputs[3].value									
							},
							//dataType: 'JSON',
							error: function (xhr, error, thrown) {									

									toastr.options = {
									  "closeButton": false,
									  "debug": false,
									  "positionClass": "toast-top-full-width",
									  "onclick": null,
									  "showDuration": "1000",
									  "hideDuration": "1000",
									  "timeOut": "10000",
									  "extendedTimeOut": "1000",
									  "showEasing": "swing",
									  "hideEasing": "linear",
									  "showMethod": "fadeIn",
									  "hideMethod": "fadeOut"
									};									
									toastr.error(xhr['responseText'], "<h3>Error Update Record</h3> <hr>").css("width","50%")									
									},
							success: function(result) { console.log(result);}
							});
							//grid.getDataTable().ajax.reload();
							//oTable.ajax.reload();
							//oTable.api().ajax.reload();
							saveRow(oTable, nEditing);
							nEditing = null;
						}else {
							console.log("batal");
						}
					}
				}); 
				
				
            } else {
                /* No edit in progress - let's start one */
                editRow(oTable, nRow);
                nEditing = nRow;
            }
        });
    }

    return {

        //main function to initiate the module
        init: function () {
            handleTable();
        }

    };

}();

jQuery(document).ready(function() {
    TableDatatablesEditable.init();
});