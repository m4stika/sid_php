var masterkavling = function () {

    var handleRecords = function () {
    	var wrapper = $('#row_browsekavling');
        var table = wrapper.find('#table_masterkavling');
        var formWrapper = $('#row_kavlingform');
        var form = formWrapper.find('#kavlingform');
        var grid = new Datatable();
        var status = ['Open','Lock','Akad','Closed','Canceled'];
        var statuslabel = ['primary','warning','success','danger','default'];

        // table.DataTable({
        grid.init({			            
            src: table,
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options 
				"dom": "<'row'<'col-md-8 col-sm-12'p><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r><'table-responsive't><'row'<'col-md-8 col-sm-12'li><'col-md-4 col-sm-12'<'pull-right'p>>>", // datatable layout
				//"dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
				"fnDrawCallback": function (data, type, full, meta) {
					$('[data-toggle="tooltip"]').tooltip({ container: 'body', html: true });
				},
                "processing": true,
                "autoWidth": true,
                "lengthMenu": [
                    [10, 20, 50, 100, 150, -1],
                    [10, 20, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": 10, // default record count per page		
                "columns": [
	                { "data": "action", "title": "Actions",  "orderable": false, "searchable": false, 
	                	render: function ( data, type, row, meta ) {
		               		 var dropdown = new gridDropdown();
		               		return dropdown.addDropdown(data, row.statusbooking);
		               		//return add_dropdown(0, data, true);
		                }
		            },
	                { "data": "noid", "title": "#ID"},
	                { "data": "blok", "title": "Blok"},
	                { "data": "nokavling", "title": "No. Kavling"},
	                { "data": "keterangan", "title": "Keterangan", "width": "20%"},
	                { "data": "typerumah", "title": "Type Rumah"},
	                { "data": "luastanah", "title": "Tanah", "orderable": false, "searchable": false},
	                { "data": "luasbangunan", "title": "Bangunan", "orderable": false, "searchable": false},
	                { "data": "kelebihantanah", "title": "KLT", "orderable": false, "searchable": false},
	                { "data": "sudut", "title": "Sudut", "orderable": false, "searchable": false,
						render: function ( data, type, row, meta ) {
		               		return (data == '1') ? "<span class=\"fa fa-check fa-lg\"></span>" : "";
		                }
	            	},
	                { "data": "hadapjalan", "title": "Hadap Jln", "orderable": false, "searchable": false,
	                	render: function ( data, type, row, meta ) {
		               		return (data == '1') ? "<span class=\"fa fa-check fa-lg\"></span>" : "";
		                }
	            	},
	                { "data": "fasum", "title": "Fasum", "orderable": false, "searchable": false,
	                	render: function ( data, type, row, meta ) {
		               		return (data == '1') ? "<span class=\"fa fa-check fa-lg\"></span>" : "";
		                }
	            	},
	                { "data": "statusbooking", "title": "Status", "orderable": false, "searchable": false,
	                	render: function ( data, type, row, meta ) {
	                		
	                		return "<span class='label label-sm label-"+statuslabel[data]+"'>"+status[data]+"</span>";
	                	}

	            	},
	            ],		
				"columnDefs": [{"className": "dt-center", "targets": "_all"}],
                "ajax": {
                    type: "post",
                    dataType: "json",
					url: siteurl+"Perencanaan/masterkavling/get_masterkavling_list",										
					error: function (xhr, error, thrown) {
							App.alert({
                                type: 'danger',
                                icon: 'warning',
                                message: xhr.responseText,
                                container: grid.gettableContainer(),
                                place: 'prepend',
                                //closeInSeconds: 3 // auto close in 5 seconds
                            });
                            App.unblockUI(wrapper.find('.table-container'));
						}
                },
				buttons: [
                     { 	extend: 'print', 
	                    className: 'btn default',
	                    autoPrint: true,
	                    exportOptions: { columns: [1,2,3,4,5] },
	                    customize: function ( win ) {
		                    $(win.document.body)
		                        .css( 'font-size', '10pt' )
		                        .prepend(
		                            '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
		                        );
		 
		                    $(win.document.body).find( 'table' )
		                        .addClass( 'compact' )
		                        .css( 'font-size', 'inherit' );
		                } 
                	},
                    { extend: 'copy', className: 'btn default' },
                    { extend: 'pdf', className: 'btn default' },
                    { extend: 'excel', className: 'btn default' },
                    { extend: 'csv', className: 'btn default' },
                    {
                        text: 'Reload',
                        className: 'btn default',
                        action: function ( e, dt, node, config ) {
                            dt.ajax.reload();
                           // alert('Datatable reloaded!');
                        }
                    }
                ],
	            //scroller:       true,
	            //deferRender:    true,
	            scrollX:        true,
	            //scrollCollapse: true, 
                "order": [
                    [1, "asc"]
                ]// set first column as a default sort by asc
            }
        });
		var oTable = grid.getDataTable();

		// handle datatable custom tools
        wrapper.find('#datatable_ajax_tools > li > a.tool-action').on('click', function() {
            var action = $(this).attr('data-action');
            grid.getDataTable().button(action).trigger();
        });

		//changed.bs.select Combao Kavling
	     form.on('changed.bs.select','#selecttyperumah',function(e, clickedIndex, newValue, oldValue) {
	        var selectedD = $(this).find('option:eq(' + clickedIndex + ')').data('value');

	        form
                .find('[name="idtyperumah"]').val($(this).val()).end()
                .find('[name="luastanah"]').val(selectedD.luastanah).end()
                .find('[name="luasbangunan"]').val(selectedD.luasbangunan).end()
                .find('[name="hargajual"]').val(selectedD.hargajual).end()
                .find('[name="hpp"]').val(selectedD.hpp).end()
                .find('[name="plafonkpr"]').val(selectedD.plafonkpr).end()
                .find('[name="bookingfee"]').val(selectedD.bookingfee).end()
                .find('[name="uangmuka"]').val(selectedD.uangmuka).end()
                .find('[name="hargasudut"]').val(selectedD.hargasudut).end()
                .find('[name="hargahadapjalan"]').val(selectedD.hargahadapjalan).end()
                .find('[name="hargafasum"]').val(selectedD.hargafasum).end();
                $('.change-total').change();
	        //$('.change-total').change();
	        
	    }); 

	    //Calculate Total
        form.on('change','.change-total', function() {           
            var hargasudut = (form.find("#sudut").is(':checked') ? parseInt(form.find('#hargasudut').val()) : 0);
            var hargahadapjalan = (form.find("#hadapjalan").is(':checked') ? parseInt(form.find('#hargahadapjalan').val()) : 0);
            var hargaklt = (parseInt(form.find('#hargakltm2').val()) * parseInt(form.find('#kelebihantanah').val()));
            var hargafasum = (form.find("#fasum").is(':checked') ? parseInt(form.find('#hargafasum').val()) : 0);
             var total = parseInt(form.find('#hargajual').val()) - parseInt(form.find('#diskon').val()) + hargaklt +
                        hargasudut + hargahadapjalan + hargafasum;
            form.find('#hargaklt').val(hargaklt);           
            form.find('#totalharga').val(total);
        });

		

		//New
		wrapper.on('click','.new', function(e) {
			handlevalidation();
			formWrapper.find(".caption-helper").text('Tambah Data Baru');
			form.trigger('reset');
			clearValidation('#kavlingform');
			e.preventDefault();		
			//handleModalReposition();	
			form
				.find('[name="status"]').val('new').end()
				.find('[id="label_idtyperumah"]').text('-1').end()
				.find('select[id=selecttyperumah]').selectpicker('val',-1).end();
			handlebootbox();
		});

		//Edit & copy
        wrapper.on('click', '.edit, .copy', function(e) {
        	var aData = oTable.row('.selected').data();
            if (aData === undefined) {
            	var rowindex = (this).closest('tr').rowIndex;
            	aData = oTable.row(rowindex-2).data();
            }
            //console.log(aData);
        	handleEditCopy(e,aData.noid);
        });

        //Delete
        wrapper.on('click', '.delete', function(e) {
        	var aData = oTable.row('.selected').data();
            if (aData === undefined) {
            	var rowindex = (this).closest('tr').rowIndex;
            	aData = oTable.row(rowindex-2).data();
            }
            //console.log(aData);
        	handleDelete(e, aData);
        });
		

        wrapper.on("click",".export",function(e){    
            $.ajax( {
            	type: "post",
				url: siteurl+"Perencanaan/masterkavling/masterkavling_ExportXLS",
				//dataType: 'JSON',
				error: function (xhr, error, thrown) {									
						App.alert({
	                                type: 'danger',
	                                icon: 'warning',
	                                message: xhr.responseText,
	                                container: grid.gettableContainer(),
	                                place: 'prepend',
	                                closeInSeconds: 3 // auto close in 5 seconds
	                            });
						},
				success: function(result) { 
						App.alert({
	                                type: 'success',
	                                icon: 'info',
	                                message: 'Export has been Complated..',
	                                container: grid.gettableContainer(),
	                                place: 'prepend',
	                                closeInSeconds: 3 // auto close in 5 seconds
	                            });
					}
            });
            
        });

		var handleEditCopy = function(e, noid) {
			e.preventDefault();
			
			var caption = "";
			var status = "";
			console.log(noid);
			if ($(e.target).hasClass('edit')||$(e.target).parent().hasClass('edit')) { 
                // $('#form_typerumah #crud').val("edit");
                // $('#row_typerumah .page-title').html("perencanaan <small>Edit Type Rumah</small>");
                // $('#row_typerumah .portlet-title span.caption-subject').text("Edit pemesanan");
                status = 'edit';
                caption = 'Koreksi Data';
            } else {
             //    $('#form_typerumah #crud').val("copy");
             //    $('#row_typerumah .page-title').html("perencanaan <small>Copy Type Rumah</small>");
            	// $('#row_typerumah .portlet-title span.caption-subject').text("Copy pemesanan");
                status = 'copy';
                caption = 'Duplicate Data';
            }
            formWrapper.find(".caption-helper").text(caption);

			handlevalidation();
			form.trigger('reset');
			clearValidation('#kavlingform');			
			$.ajax({
					type: "post",
					dataType: "json",
					url: siteurl+"Perencanaan/masterkavling/masterkavling_edit",
					data : {noid: noid}, 
					error: function (xhr, error, thrown) {
								App.alert({
	                                type: 'danger',
	                                icon: 'warning',
	                                message: xhr.responseText,
	                                container: grid.gettableContainer(),
	                                place: 'prepend',
	                               // closeInSeconds: 3 // auto close in 5 seconds
	                            });
							}
				}).success(function(response) {
					// Populate the form fields with the data returned from server					
					form
						.find('[name="idtyperumah"]').val(response.data.idtyperumah).end()
						.find('[name="luasbangunan"]').val(response.data.luasbangunan).end()
						.find('[name="luastanah"]').val(response.data.luastanah).end()
						.find('[name="hargajual"]').val(response.data.hargajual).end()
						.find('[name="hpp"]').val(response.data.hpp).end()
						.find('[name="plafonkpr"]').val(response.data.plafonkpr).end()
						.find('[name="bookingfee"]').val(response.data.bookingfee).end()
						.find('[name="uangmuka"]').val(response.data.uangmuka).end()
						.find('[name="hargasudut"]').val(response.data.hargasudut).end()
						.find('[name="hargahadapjalan"]').val(response.data.hargahadapjalan).end()
						.find('[name="hargafasum"]').val(response.data.hargafasum).end()
						.find('[name="noid"]').val((status == 'edit') ? response.data.noid : -1).end()
						.find('[name="blok"]').val(response.data.blok).end()
						.find('[name="nokavling"]').val(response.data.nokavling).end()
						.find('[name="kelebihantanah"]').val(response.data.kelebihantanah).end()
						.find('[name="hargakltm2"]').val(response.data.hargakltm2).end()
						.find('[id="sudut"]').prop('checked',((response.data.sudut==1) ? true : false)).end()
						.find('[id="hadapjalan"]').prop('checked',((response.data.hadapjalan==1) ? true : false)).end()
						.find('[id="fasum"]').prop('checked',((response.data.fasum==1) ? true : false)).end()						
						.find('[name="diskon"]').val(response.data.diskon).end()
						.find('[name="alasandiskon"]').val(response.data.alasandiskon).end()
						.find('[name="status"]').val(status).end()
						.find('[id="label_idtyperumah"]').text(response.data.idtyperumah).end();
						form.find('select[id=selecttyperumah]').selectpicker('val',response.data.idtyperumah);
						form.find('.change-total').change();
						
					// Show the dialog
					if (response.hasil == "OK") {
						handlebootbox();
					} else console.log('No Record to display');
				});
		};

		var handlebootbox = function() {
			bootbox
				.dialog({
					closeButton: false,
					message: formWrapper,
					className: "bxtyperumah",
					show: false // We will show it manually later						
				})
				.on('shown.bs.modal', function() {
					formWrapper.show();
				})
				.on('hide.bs.modal', function() {
					formWrapper.hide().appendTo('body');
				})
				.modal('show')
				.find("div.modal-dialog").addClass("large-xl");  
		};

		var handleDelete = function(e, aData) {
			var originalState = $("#form_delete").clone();		
			var formDelete = $('#form_delete');
			e.preventDefault();
			//handleModalReposition();
			formDelete.find("#form_delete_body")
				.find('[id="noid"]').html( "<strong>"+aData.noid+"</strong>" ).end()
				.find('[id="blok"]').html( "<strong>"+aData.blok+"</strong>" ).end()
				.find('[id="nokavling"]').html( "<strong>"+aData.nokavling+"</strong>" ).end()
				.find('[id="typerumah"]').html( "<strong>"+aData.typerumah+"</strong>" ).end()
				.find('[id="status"]').html("<span class='label label-sm label-"+statuslabel[aData.statusbooking]+"'>"+status[aData.statusbooking]+"</span>").end();
				
				bootbox
					.dialog( {
				    size: 'medium',
					closeButton: false,
					message: formDelete, 
					buttons: {
						'confirm': {
							label: 'Delete',
							className: 'btn-danger',
							callback: function() {
								$.ajax({
									type: "post",
									dataType: 'JSON',
									url: siteurl+"Perencanaan/masterkavling/masterkavling_delete",
									data: { noid: aData.noid, flag: 2 },							
									error: function (xhr, error, thrown) {									
											App.alert({
				                                type: 'danger',
				                                icon: 'warning',
				                                message: xhr.responseText,
				                                container: grid.gettableContainer(),
				                                place: 'prepend',
				                                //closeInSeconds: 3 // auto close in 5 seconds
				                            });
										},
									success: function(result) { 
										App.alert({
				                                type: 'success',
				                                icon: 'info',
				                                message: "Record has been deleted..",
				                                container: grid.gettableContainer(),
				                                place: 'prepend',
				                                closeInSeconds: 3 // auto close in 5 seconds
				                            });
										grid.getDataTable().ajax.reload();

									}
								});
							 }  // end of callback
						}, // end of confirm
						'cancel': {
							label: 'Cancel',
							className: 'btn-primary',
							callback: function() {
								App.alert({
		                            type: 'success',
		                            icon: 'info',
		                            message: "Deleting record canceled",
		                            container: grid.gettableContainer(),
		                            place: 'prepend',
		                            closeInSeconds: 3 // auto close in 5 seconds
		                        });
							}
						}
					}, //end of button
				})
				.on('shown.bs.modal', function() {
							formDelete.show();
				})
				
				.on('hide.bs.modal', function(e) {	
							formDelete.replaceWith(originalState.clone());
							formDelete.hide().appendTo('body');
				});
		};

		var handlevalidation = function() {		
			urls = siteurl+"Perencanaan/masterkavling/masterkavling_crud";
			form.validate({
			errorElement: 'span', //default input error message container
	        errorClass: 'help-block', // default input error message class
	        focusInvalid: true, // do not focus the last invalid input
	            rules: {                
	                blok: {
	                    required: true
	                },
					nokavling: {
	                    required: true
	                },
					selecttyperumah: {
	                    required: true
	                },
	                kelebihantanah: {
	                    required: true
	                },				
	                hargakltm2: {
	                    required: true
	                },				
	            },
				messages:
				{
					blok:{
	                      required: "blok harus diisi"
							},
					selecttyperumah: "Type rumah harus diisi",
					nokavling: "nomor kavling harus diisi",
					kelebihantanah: "kelebihan Tanah harus diisi dengan type integer",
					hargakltm2: "Harga kelebihan tanah harus diisi",
				},
				highlight: function(element) { // hightlight error inputs
	                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
	            },
				success: function(label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();						
	            },
				
				submitHandler: function(e){				
					var data = form.serialize();
					$.ajax({
							type: 'post',
							dataType: 'json',
							url: urls, 
							data: data,
							error: function (xhr, error, thrown) {
										App.alert({
				                                type: 'danger',
				                                icon: 'warning',
				                                message: xhr.responseText,
				                                container: grid.gettableContainer(),
				                                place: 'prepend',
				                                //closeInSeconds: 3 // auto close in 5 seconds
				                            });
									}
						}).success(function(response) {
							App.alert({
		                            type: 'success',
		                            icon: 'info',
		                            message: "Process Complated..",
		                            container: grid.gettableContainer(),
		                            place: 'prepend',
		                            closeInSeconds: 3 // auto close in 5 seconds
		                        });
							});
					grid.getDataTable().ajax.reload();
					$('.bxtyperumah').modal("hide");				
					return false;						
				}  
			});
		};  
    };

    return {
        //main function to initiate the module
        init: function () {
           // initPickers();
            handleRecords();			
        }

    };

}();
	
 
jQuery(document).ready(function() {			
    masterkavling.init();	
});

