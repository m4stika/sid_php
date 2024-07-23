var penyusutan = function() {
	var handleForm = function(){
		var table = $('#table_penyusutan');
		var wrapper = $('#row_penyusutan');
		var grid = new Datatable();
		grid.init({
		//oTable = table.DataTable({
			src: table,
			select: false,
            dataTable: {
            	"dom": "<'table-responsive't>",
            	"columns": [
	                { "data": "noid",			"title": "#", 				"className": 'dt-body-right dt-head-center'},
	                { "data": "namaaktiva",		"title": "Nama Aktiva", 	"width": "20%"},
	             //    { "data": "bulanperolehan", "title":"BL-TH disusutkan",	"className": 'dt-right', "width": "10%", "orderable": false,
		            //     render: function ( data, type, row, meta ) {
			           //     	return ((intVal(data) > 9) ? data : "0" + data)+'-'+row.tahunperolehan;
			           //  }
		            // },
	                { "data": "totalharga", "title": "Tot. Harga", "className": 'dt-right', 
	                	render: function ( data, type, row, meta ) {
			               	return intVal(data).format(2, 3, '.', ',');
		                } 
		            },
		            { "data": "usiaekonomis", "title": "Usia", "className": 'dt-right'},
		            { "data": "penyusutanbulan_II", "title": "Penyusutan", "className": 'dt-right', "orderable": false, 
		            	render: function ( data, type, row, meta ) {
			               	var akum = (intVal(row.akumpenyusutan) === 0) ? row.penyusutanbulan_I : row.penyusutanbulan_II;
			               	akum = (intVal(row.nilaibuku) < intVal(akum)) ? row.nilaibuku : akum;
			               	return intVal(akum).format(2, 3, '.', ',');
			            }
		            },
		            { "data": "akumpenyusutan", "title": "Akum. Peny", "className": 'dt-right', 
		            	render: function ( data, type, row, meta ) {
			               	return intVal(data).format(2, 3, '.', ',');
		                }
		            },
		            { "data": "nilaibuku", "title": "Nilai Buku", "className": 'dt-right', 
		            	render: function ( data, type, row, meta ) {
			               	return intVal(data).format(2, 3, '.', ',');
		                }
		            }
		            //{"data": null, "className": "details-control", "defaultContent": '', "orderable": false, "width": "5%",}
	            ],
	            "order": [[0, 'asc']],
            	"ajax": {
            		type: "post",      
                    dataType: "json",              
					url: siteurl+"Accounting/penyusutan/get_penyusutan",
					error: function (xhr, error, thrown) {
							wrapper.find('.info').html(xhr.responseText);
						}
            	},
            	"rowCallback": function( row, data, index ) {
		          $('td:eq(4)', row).addClass( "font-blue bold" );
		          //$('td:eq(1),td:eq(2),td:eq(3)', nRow).addClass( "avo-light" );
		        },
            	"footerCallback": function ( row, data, start, end, display ) {
		                var api = this.api();
		     
		                // Total over all pages
		                var totalpenyusutan = api
		                    .column( 4 )
		                    .data()
		                    .reduce( function (a, b) {
		                        return intVal(a) + intVal(b);
		                    }, 0 );

		                var totalakumulasi = api
		                    .column( 5 )
		                    .data()
		                    .reduce( function (a, b) {
		                        return intVal(a) + intVal(b);
		                    }, 0 );

		                var totalnilaibuku = api
		                    .column( 6 )
		                    .data()
		                    .reduce( function (a, b) {
		                        return intVal(a) + intVal(b);
		                    }, 0 );
		     
		                // Update footer
		                $( api.column( 4 ).footer() ).html(
		                    totalpenyusutan.format(2, 3, '.', ',')
		                );
		                $( api.column( 5 ).footer() ).html(
		                    totalakumulasi.format(2, 3, '.', ',')
		                );
		                $( api.column( 6 ).footer() ).html(
		                    totalnilaibuku.format(2, 3, '.', ',')
		                );
		            },
            }
		}); // End of Grid.Init
		var oTable = grid.getDataTable();

		wrapper.on('click','.save1', function(){
			console.log('save');
			$.ajax({
				type: 'POST',
				dataType: 'JSON',
				async: false,
				url: siteurl+'Accounting/penyusutan/save_penyusutan',
				//data: {record: JSON.stringify(faData)},
				error: function(xhr, error, thrown) {									
					wrapper.find('.info').html(xhr.responseText);
					//handleData(false, xhr.responseText);
					return false;
				},
				success: function(json) {
					//if (json == 'OK') {
						console.log(json);
						oTable.ajax.reload();
					//}
					return true;
				}
			});
		});
	};
	return {
			init: function() {
				handleForm();
			}
		};
}(); //End of penyusutan

$(document).ready(function(){
	penyusutan.init();
});