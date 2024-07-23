var journalextract = function() {
	var handleForm = function(){
		var wrapper = $('#row_extract');
		var table = wrapper.find('#table_extract');
		var grid = new Datatable();
		
		var parameter = {
			sourceid: 0,
			bulan: parameter_system.bulanbuku,
			tahun: parameter_system.tahunbuku,
			tanggalfrom: changedate(tgl, 'YMD'),
			tanggalto: changedate(tgl, 'YMD')
		};

		grid.init({
			src: table,
			select: false,
            dataTable: {
                "dom": "r<''t><'row'<'col-md-8 col-sm-12'li><'col-md-4 col-sm-12'<'pull-right'p>>>", // datatable layout
                "ordering": false,
            	"columns": [
	                { "data": null, "width": "5%", "defaultContent": '',
	                	render: function ( data, type, row, meta ) {
	                		var html = "<label class='mt-checkbox mt-checkbox-single mt-checkbox-outline'><input type='checkbox' class='checkboxes' value='1' /><span></span></label>";

				               	return html;
				            }
	            	},
	                { "data": "journalno",			"title": "Journal #", 				"className": 'dt-head-center', "width": "10%"},
	                { "data": "journalgroupdesc",			"title": "Group", 				"className": 'dt-center'},
	                { "data": "journaldate",		"title": "Date", "className": 'dt-center',
		                	render: function ( data, type, row, meta ) {
				               	return changedate(data, 'DMY');
				            }
		            },
	                { "data": "journalremark",			"title": "Remark", 				"className": 'dt-head-center', "width": "30%"},
	                { "data": "dueamount",			"title": "Due Amount", 				"className": 'dt-right',
		                render: function ( data, type, row, meta ) {
			                	return intVal(data).format(2, 3, '.', ',');
			            }
		            },
		            {"data": null, "className": "details-control", "defaultContent": '', "orderable": false, "width": "5%",}
	            ],
	            "order": [[0, 'asc']],
            	"ajax": {
            		type: "post",      
                    dataType: "json",              
					url: siteurl+"Accounting/extract/get_extract",
					data: function (d) {
	                        d.sourceid = parameter.sourceid;
	                        d.bulan = parameter.bulan;
	                        d.tahun = parameter.tahun;
	                        d.tanggalfrom = parameter.tanggalfrom;
	                        d.tanggalto = parameter.tanggalto;
	                    },
					error: function (xhr, error, thrown) {
							wrapper.find('.info').html(xhr.responseText);
						}
            	},
            	// "drawCallback": function( settings ) {
            	// 	var api = this.api();
            	// 	var json = api.ajax.json();
		           //      console.log(json);
            	// },
            	"rowCallback": function( row, data, index ) {
		          $('td:eq(4)', row).addClass( "font-blue bold" );
		        },
            	"footerCallback": function ( row, data, start, end, display ) {
		                var api = this.api();
		                var json = api.ajax.json();
		     
		                // Total over all pages
		                var totalpenyusutan = api
		                    .column( 5 )
		                    .data()
		                    .reduce( function (a, b) {
		                        return intVal(a) + intVal(b);
		                    }, 0 );

		                // Update footer
		                var grandtotal = intVal(json.grandtotal);
		                $( api.column( 5 ).footer() ).html('<div class="totalfooter"><p>'+
		                    totalpenyusutan.format(2, 3, '.', ',')+'</p> <p class="font-red bold">'+grandtotal.format(2, 3, '.', ',')+'</p></div>'
		                );
		            },
            }
		}); // End of Grid.Init
		var oTable = grid.getDataTable();

		/********************* Start bulan-tahun combobox ***************/
        var arbulan = ["Januari","Februari","Maret",'April',"Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        var tgl = new Date();
        var tahun = tgl.getFullYear();
        var bulan = tgl.getMonth()+1;
        var option = '';
        var i;
        for (i = 0; i < arbulan.length; i++) {
        	option += "<option value='"+(i+1)+"'>"+arbulan[i]+"</option>";
        }
        wrapper.find('#bulan').html(option);//.val(bulan+1);
        wrapper.find('#bulan').val(bulan);

        option = '';
        for (i = 15 - 1; i >= 0; i--) {
        	option += "<option value='"+(tahun-i)+"' data-value="+(tahun-i)+" >"+(tahun-i)+"</option>";
        }

        for (i = 1; i < 10; i++) {
        	option += "<option value='"+(tahun+i)+"' data-value="+(tahun+i)+">"+(tahun+i)+"</option>";
        }
        wrapper.find('#tahun').html(option);//.val(tahun);
        wrapper.find('#tahun').val(tahun);
        $('.tahun').selectpicker('refresh');
        wrapper.find('#dpperiode').datepicker('update',changedate(parameter.tanggalfrom,'DMY'));
        wrapper.find('#dpperiode1').datepicker('update',changedate(parameter.tanggalto,'DMY'));

        arbulan = undefined; tgl = undefined; bulan = undefined; tahun = undefined; option = undefined; i = undefined;
        /********************* end bulan-tahun combobox ***************/

        //Extract Source Change
        wrapper.on('changed.bs.select','#source',function(e, clickedIndex, newValue, oldValue) {
	        var selectedD = $(this).val(); // $(this).find('option:eq(' + clickedIndex + ')').data('value');
	        parameter.sourceid = selectedD-1;
	        //console.log(parameter.sourceid);

	        if (selectedD == 6)  {
	        	wrapper.find('.bulantahun').show();
	        	wrapper.find('.periode').hide();
	        	//oTable.ajax.reload();
	        } else {
	        	wrapper.find('.bulantahun').hide();
	        	wrapper.find('.periode').show();
	        }
	        table.find('tbody').empty();
	        table.find('tfoot > tr > th > .totalfooter').html('0');
	    });

        //Bulan, Tahun Source Change
	    wrapper.on('changed.bs.select','#bulan, #tahun',function(e, clickedIndex, newValue, oldValue) {
	        var selectedD = $(this).val();
	        if ($(this).attr('id') == 'bulan') {
	        	parameter.bulan = $(this).val();
	        } else {
	        	parameter.tahun = $(this).val();
	        }
	       // console.log(parameter);
	    });

	    // Tanggal Pembayaran Onchange
		wrapper.on('changeDate','#dpperiode, #dpperiode1', function(ev){
            if ($(this).attr('id') == 'dpperiode') {
            	//wrapper.find('#tglextract').val();
            	parameter.tanggalfrom = $('#dpperiode').datepicker('getFormattedDate','yyyy-mm-dd');
            	//wrapper.find('#tglextract').val();
            } else {
            	parameter.tanggalto = $('#dpperiode1').datepicker('getFormattedDate','yyyy-mm-dd');
            }
        });

	    //Reload Grid
	    wrapper.on('click','.reset', function(){
	    	oTable.ajax.reload();
	    	//console.log(parameter_system, parameter);
	    });

	    //Save Record
	    wrapper.on('click','.save', function(){
	    	var datastr = grid.getSelectedRowsData();	
	    	//console.log(JSON.stringify(datastr));
	    	$.ajax({
				type: 'POST',
				dataType: 'JSON',
				//async: false,
				url: siteurl+'Accounting/extract/save_extract',
				data: {record: JSON.stringify(datastr)},
				error: function(xhr, error, thrown) {									
					wrapper.find('.info').html(xhr.responseText);
					//console.log(xhr.responseText);
				},
				success: function(json) {
					//console.log(json);
					if (json == 'OK') {oTable.ajax.reload();}
					
				}
			});
	    });

	    /*-------------------------------------------
				HANDLE Detail Journal
		---------------------------------------------*/
		function fnFormatDetails(table_id, html) {
		    var sOut = "<table id=\"exampleTable_" + table_id + "\">";
		    sOut += html;
		    sOut += "</table>";
		    return sOut;
		}

		var detailsTableHtml = $("#table_jurnaldetail").html();
		var detailsTable = $("#table_jurnaldetail");
		table.on('click','td.details-control', function () {	
            var tr = $(this).parents('tr');
         	var row = oTable.row(tr);
            if ( row.child.isShown() ) {
		        // This row is already open - close it
		        detailsTable.hide();
		        row.child.hide();
		        tr.removeClass('shown');
		    }
            else {
                // if any row already open - close it
                if ( oTable.row( '.shown' ).length ) {
                  $('.details-control', oTable.row( '.shown' ).node()).click();
          		}

          		/* Open this row */
                row.child(fnFormatDetails(row.data().linkid, detailsTableHtml)).show();
                tr.addClass('shown');
                oInnerTable = $("#exampleTable_" + row.data().linkid).dataTable({
                    "dom": "<'table-responsive't>",
                    "ordering": false,
                    "paging": false,
                    "columns": [
		                { "data": "indexvalue",			"title": "#", 			"width": "8%"},
		                { "data": "rekid", "title":"ID",	"className": 'dt-center'},
			            { "data": "accountno",			"title": "Account"},
		                { "data": "description",			"title": "Description"},
		                { "data": "debit",		"title": "Debit", "className": 'dt-right',
		                	render: function ( data, type, row, meta ) {
				               	return intVal(data).format(2, 3, '.', ',');
				            }
		            	},
		                { "data": "credit",		"title": "Credit",  "className": 'dt-right',
		                	render: function ( data, type, row, meta ) {
				               	return intVal(data).format(2, 3, '.', ',');
				            }
		            	}
	                ],
                    "ajax": {
	                    type: "post",      
	                    dataType: "json",        
	                    dataSrc: function ( json ) {
	                        return json;
	                    },
	                    url: siteurl+"Accounting/extract/get_extract_detail",
	                    data: function (d) {
	                        d.linkid = row.data().linkid;
	                        d.group = row.data().journalgroup;
	                    }, 
	                    error: function (xhr, error, thrown) {
	                               wrapper.find('.info').html(xhr.responseText);
	                               //console.log('error');
	                            },
	                },
	                "footerCallback": function ( row, data, start, end, display ) {
		                var api = this.api();
		     
		                // Total over all pages
		                var totalD = api
		                    .column( 4 )
		                    .data()
		                    .reduce( function (a, b) {
		                        return intVal(a) + intVal(b);
		                    }, 0 );

		                // Total over all pages
		                var totalC = api
		                    .column( 5 )
		                    .data()
		                    .reduce( function (a, b) {
		                        return intVal(a) + intVal(b);
		                    }, 0 );
		     
		                // Update footer
		                $( api.column( 4 ).footer() ).html(
		                    totalD.format(2, 3, '.', ',')
		                );
		                $( api.column( 5 ).footer() ).html(
		                    totalC.format(2, 3, '.', ',')
		                );
		            },
                });
            }
        });
       
        /*------------------ end of Detail Journal */

	}; //end of handleForm

	return {
			init: function() {
				handleForm();
			}
		};
}(); //End of journalextract

$(document).ready(function(){
	journalextract.init();
});

