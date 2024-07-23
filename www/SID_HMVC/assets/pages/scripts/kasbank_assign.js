var handleJurnalassign = function() {
	var handleRecord = function() {
		var table = $('#table_jurnalassign');
		var grid = new Datatable();

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
                        {  "targets": [0], "orderable": false, "className": "dt-head-center" },
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
                "ajax": {
                	type: "post",
                    dataType: "json",                 
                    url: "get_listAssignKB",
                    error: function (xhr, error, thrown) {
                                $('.row_assign .info').html(xhr.responseText);
                                console.log('error');
                            },
                }
			}
		})

		grid.setAjaxParam("customFilter", true);

		// handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
            e.preventDefault();
            //console.log(grid.getSelectedID());
            var action = $(".table-group-action-input", grid.getTableWrapper());
            //if (action.val() != "")  && grid.getSelectedRowsCount() > 0) {
        	if (grid.getSelectedRowsCount() > 0) {
                grid.setAjaxParam("customActionType", "group_action");
                grid.setAjaxParam("customActionName", action.val());
                grid.setAjaxParam("id", grid.getSelectedID());
                grid.getDataTable().ajax.reload();
                grid.clearAjaxParams();
            // } else if (action.val() == "") {
            //     App.alert({
            //         type: 'danger',
            //         icon: 'warning',
            //         message: 'Please select an action',
            //         container: grid.getTableWrapper(),
            //         place: 'prepend'
            //     });
            } else if (grid.getSelectedRowsCount() === 0) {
                App.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'Pilih data yang mau di Assign',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            }
        });

        //save Button Click
        $('.save', $('.row_assign')).on('click',function(e){
            e.preventDefault();
            if (grid.getSelectedRowsCount() > 0) {
                grid.setAjaxParam("customActionType", "group_action");
                grid.setAjaxParam("customActionName", 'assign');
                grid.setAjaxParam("id", grid.getSelectedID());
                grid.getDataTable().ajax.reload();
                grid.clearAjaxParams();
            } else if (grid.getSelectedRowsCount() === 0) {
                App.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'Pilih data yang mau di Assign',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            }
        });

        

        table.on('click', '.view', function(){
        	var aData = grid.getData($(this).parents('tr')[0]);
        	$('#noid', $('#jurnal_view')).val(aData[1]);
        	vgrid.getDataTable().ajax.reload();
        	bootbox
				.dialog({
					closeButton: false,
					message: $('#jurnal_view'),
					className: "bxtyperumah",
					show: false, // We will show it manually later
					buttons: {
						'cancel': {
							label: 'Close',
							className: 'btn-primary',
							callback: function() {
								//console.log("Close");
							}
						}
					}, //end of button
				})
				.on('shown.bs.modal', function() {
					$('#jurnal_view').show()    // Show the login form								
				})
				.on('hide.bs.modal', function() {
					vgrid.getDataTable().clear();
					$('#jurnal_view').hide().appendTo('body');
				})
				.modal('show')
				.find("div.modal-dialog").addClass("large-xl");  
        });

        var vtable = $('#table_jurnalKB');
		var vgrid = new Datatable();

		vgrid.init({
				src: vtable,
				loadingMessage: 'loading...',
				select: false,
				dataTable: {
				"dom": "<'table-responsive't>",
				"orderCellsTop": false,
				"lengthMenu": [
                    [10, 20, 50, 100, 150, -1],
                    [10, 20, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": 30, // default record count per page
                "columnDefs": [
	                {
	                    "targets": [5],
	                    "render": $.fn.dataTable.render.number( '.', ',', 2, '' ),
	                    "className": 'dt-right bold',                        
	                    "type": "num",
	                    "orderable": false
	                },
	                {
	                    "targets": [1,2,3],
	                    "className": 'bg-warning',
	                    "orderable": false                          
	                },
	                { "targets": [4], "orderable": false},
	                
	                { "targets": [0], "visible": false,"searchable": false},
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

	                // $('#form_jurnalkb #totaltransaksi').val(total);
	                // //(total <= 0) ? $('.row_kasbank .save').attr('disabled','disabled') : $('.row_kasbank .save').removeAttr('disabled');
	                // if (total > 0) $('#totaltransaksi', $('.row_kasbank')).valid();
	            },
				"ajax": {
                    type: "post",      
                    dataType: "json",        
                    //dataSrc: "jurnalDetail",      
                    dataSrc: function ( json ) {
                        if (json['jurnalHeader']) handleHeader(json['jurnalHeader'])
                        return json['jurnalDetail'];
                    },
                    url: "get_jurnalKB",
                    data: function (d) {
                        d.noid = $('#noid',$('#jurnal_view')).val(),
                        d.crud = $('#crud',$('#jurnal_view')).val()

                    }, //document.getElementById("selectWarehouse").value ,
                    error: function (xhr, error, thrown) {
                                var htoastr = new myToastr(xhr['responseText'], "<h2>Error</h2> <hr>")
                                htoastr.toastrError()
                            },
                },
				//"pagingType": "bootstrap_full_number",
				"order": []// set first column as a default sort by asc
            }
				
		})
		

    	function handleHeader(aData) {
    	//console.log(aData.tgltransaksi1);
    	var namabulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Aug','Sep','Okt','Nov','Des'];
        var date = new Date(aData.tgltransaksi1);
        //var month = namabulan[date.getMonth() + 1];
        var month = namabulan[date.getMonth()];
        var tanggal = date.getDate();
        //date = ((tanggal > 9) ? tanggal : "0" + tanggal) + "/" + ((month > 9) ? month : "0" + month) + "/" + date.getFullYear();
        date = ((tanggal > 9) ? tanggal : "0" + tanggal) + "-" + month + "-" + date.getFullYear();

        $('#jurnal_view')
            .find('[id="kasbanktype"]').text(function() {
            	var status =  ["Cash-IN","Cash-OUT","Bank-IN","Bank-OUT"];
            	return status[aData.kasbanktype];
            }).end()
            .find('[id="tgltransaksi"]').html(date).end()
            .find('[id="accountno"]').html(aData.perkiraan).end()
            .find('[id="nobukti"]').text(aData.nobukti).end()
            .find('[id="nomorcek"]').text(aData.nomorcek).end()
            .find('[id="uraian"]').text(aData.uraian).end()
        }
	}

	return {
		init : function() {
			handleRecord()
		}
	}
}()

jQuery(document).ready(function() {
    handleJurnalassign.init();
});