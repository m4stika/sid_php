var typerumah = function () {
    var handleRecords = function () {
	    var wrapper = $('#browse_typerumah');
	    var table = wrapper.find('#table_typerumah');
	    var wrapperForm = $('#row_typerumah');
	    var form = wrapperForm.find('#form_typerumah');
        var grid = new Datatable();

        grid.init({        	
            src: table,
            onSuccess: function (grid, response) {
                // grid:        grid object
                // response:    json object of server side ajax response
                // execute some code after table records loaded
            },
            onError: function (grid, xhr) {
                // execute some code on network or other general error  
            },
            onDataLoad: function(grid) {
                // execute some code on ajax data load
                
            },
           // loadingMessage: 'Loading records...',
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options 
                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js). 
                // So when dropdowns used the scrollable div should be removed. 
                "dom": "<'row'<'col-md-8 col-sm-12'p><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r><'table-responsive't><'row'<'col-md-8 col-sm-12'li><'col-md-4 col-sm-12'<'pull-right'p>>>", // datatable layout
				"fnDrawCallback": function (data, type, full, meta) {
					$('[data-toggle="tooltip"]').tooltip({ container: 'body', html: true });
				},
				"language": {
					//"metronicAjaxRequestGeneralError": error, 
				},
                "processing": true,
				//"bServerSide": true,
				//"deferRender": true,
				"select": false,
                "lengthMenu": [
                    [10, 20, 50, 100, 150, -1],
                    [10, 20, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": 10, // default record count per page
                "columns": [
	                { "data": "action",  "orderable": false, "searchable": false, render: function ( data, type, row, meta ) {
		               		var dropdown = new gridDropdown();
		               		return dropdown.addDropdown(data);
		               		//return add_dropdown(0, data, true);
		                }
		            },
	                { "data": "noid"},
	                { "data": "typerumah"},
	                { "data": "keterangan"},
	                { "data": "luasbangunan", "orderable": false, "searchable": false},
	                { "data": "luastanah", "orderable": false, "searchable": false},
	            ],
                "ajax": {
                    type: "post",      
                    dataType: "json",              
					url: siteurl+"Perencanaan/typerumah/typerumah_list",
					error: function (xhr, error, thrown) {
								App.alert({
	                                type: 'danger',
	                                icon: 'warning',
	                                message: xhr.responseText,
	                                container: grid.gettableContainer(),
	                                place: 'prepend',
	                               // closeInSeconds: 3 // auto close in 5 seconds
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
                    { extend: 'pdf', className: 'btn default', exportOptions: { columns: [1,2,3,4,5] } },
                    { extend: 'excelHtml5', 
                    		className: 'btn default',
                    		exportOptions: { columns: [1,2,3,4,5] },
                     },
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
                    [1, "asc"]
                ]// set first column as a default sort by asc
            }
        });
        var oTable = grid.getDataTable();
        grid.setAjaxParam("customFilter", true);

        // handle filter cancel button click
        table.on('click', '.filter-cancel', function(e) {
			grid.setAjaxParam("customFilter", true);            
        });

		// handle datatable custom tools
        $('#datatable_ajax_tools > li > a.tool-action').on('click', function() {
            var action = $(this).attr('data-action');
            oTable.button(action).trigger();
        });

		//New Button Click
		wrapper.on('click', '.new', function(e) {
            handleValidation("new");
            form.trigger('reset');
            form.find('#crud').val("new");
            wrapperForm.find('.page-title').html("Pemasaran <small>New Type Rumah</small>");
            wrapperForm.find('.portlet-title span.caption-helper').text("Tambah Data Baru");
            form.find('#noid_span').text("-1");
            form.validate();
            form.find('.form-group').removeClass('has-error');
            wrapper.slideUp('fast', function(){
            	wrapper.hide();
            	wrapperForm.show();	
            });
            e.preventDefault();
        });

		//Edit & copy
        wrapper.on('click', '.edit, .copy', function(e) {
        	var aData = oTable.row('.selected').data();
            if (aData === undefined) {
            	var rowindex = (this).closest('tr').rowIndex;
            	aData = oTable.row(rowindex-2).data();
            }
            //console.log(aData);
        	handleCopyEdit(e,aData.noid);
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

        //Cancel / Back
        wrapperForm.on("click",".back",function(e){    
            e.preventDefault();
            wrapper.slideDown('fast', function(){
            	wrapperForm.hide();	
            });
            
        });

        wrapper.on("click",".export",function(e){    
            $.ajax( {
            	type: "post",
				url: siteurl+"Perencanaan/typerumah/typerumah_ExportXLS",
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

        // ==================================================//
        // ================== DRAG & DROP =================== //
        // ==================================================//
        $( ".drop-item" ).droppable({
            drop: function( event, ui ) {
                var element = $(event.target); //$(event.toElement); // equivalent to $(ui.helper);
                var elm = '#'+element.closest('.drop-item').attr('id');
	            	elm = (elm.substr(elm.length-3) == 'ket') ? elm = elm.substr(0,elm.length-3) : elm;
	            var elmid = elm+'id';
	            var elmdesc = elm+'ket';
	            
                if (element.closest('.drop-item').length) {
                    var data = $(ui.draggable).data('value');
                    $(elmid).val(data.noid);
                    $(elm).val(data.accountno);
                    $(elmdesc).val(data.description);
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
	            var elm = '#'+t.closest('.drop-item').attr('id');
	            	elm = (elm.substr(elm.length-3) == 'ket') ? elm = elm.substr(0,elm.length-3) : elm;
	            var elmid = elm+'id';
	            var elmdesc = elm+'ket';
	            if (!t.closest('.jstree').length) {
	                if (t.closest('.drop-item').length) {
	                    var adata = data.data.origin.get_node(data.element).data;
	                    if (adata.classacc != '0') {
		                    $(elmid).val(adata.noid);
		                    $(elm).val(adata.accountno);
		                    $(elmdesc).val(adata.description);
		                }
	                }
	            }
	        });
	    // End of DRAG & DROP =======================


		var handleDelete = function(e, aData) {
			e.preventDefault();
			
			bootbox.confirm( {
			   // size: 'small',
				closeButton: false,
				title: 'SID - Delete Record',
				message: "yakin mau menghapus data : "+aData.typerumah+" ? ",
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
						url: siteurl+"Perencanaan/typerumah/typerumah_delete",
						data: { noid: aData.noid, flag: 1 },
						dataType: 'JSON',
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
		                                message: "Record has been deleted..",
		                                container: grid.gettableContainer(),
		                                place: 'prepend',
		                                closeInSeconds: 3 // auto close in 5 seconds
		                            });
								grid.getDataTable().ajax.reload();

							}
						});
						
					}else {
						//console.log(grid.tableContainer);
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
			}); 
		};
		 

		var handleCopyEdit = function(e, noid) {
			var status = '';
			e.preventDefault();
			

            if ($(e.target).hasClass('edit')||$(e.target).parent().hasClass('edit')) { 
                form.find('#crud').val("edit");
                wrapperForm.find('.page-title').html("perencanaan <small>Edit Type Rumah</small>");
                wrapperForm.find('.portlet-title span.caption-helper').text("Koreksi Data");
                status = 'edit';
            } else {
                form.find('#crud').val("copy");
                wrapperForm.find('.page-title').html("perencanaan <small>Copy Type Rumah</small>");
                wrapperForm.find('.portlet-title span.caption-helper').text("Duplicate Data");
                status = 'copy';
            }
            handleValidation(status);

			form.trigger('reset');
			form.validate();
            
			$.ajax({
					type: "post",
					dataType: "json",
					url: siteurl+"Perencanaan/typerumah/typerumah_edit",
					data : {
						noid: noid,
					}, 
					error: function (xhr, error, thrown) {
								App.alert({
	                                type: 'danger',
	                                icon: 'warning',
	                                message: xhr.responseText,
	                                container: grid.gettableContainer(),
	                                place: 'prepend',
	                                closeInSeconds: 3 // auto close in 5 seconds
	                            });
							}
				}).success(function(response) {
					form
						.find('#noid_span').text(response.data.noid).end()
						.find('[name="noid"]').val(response.data.noid).end()
						.find('[name="typerumah"]').val(response.data.typerumah).end()
						.find('[name="keterangan"]').val(response.data.keterangan).end()
						.find('[name="luastanah"]').val(response.data.luastanah).end()
						.find('[name="luasbangunan"]').val(response.data.luasbangunan).end()
						.find('[name="hargajual"]').val(response.data.hargajual).end()
						.find('[name="hpp"]').val(response.data.hpp).end()
						.find('[name="plafonkpr"]').val(response.data.plafonkpr).end()
						.find('[name="bookingfee"]').val(response.data.bookingfee).end()
						.find('[name="uangmuka"]').val(response.data.uangmuka).end()
						.find('[name="hargasudut"]').val(response.data.hargasudut).end()
						.find('[name="hargahadapjalan"]').val(response.data.hargahadapjalan).end()
						.find('[name="hargafasum"]').val(response.data.hargafasum).end()

						.find('[name="acctitipanbfid"]').val(response.data.bookingfeeacc1).end()
						.find('[name="acctitipanbf"]').val(response.data.bookingfeeacc1no).end()
						.find('[name="acctitipanbfket"]').val(response.data.bookingfeeacc1desc).end()
						.find('[name="acctitipanumid"]').val(response.data.uangmukaacc1).end()
						.find('[name="acctitipanum"]').val(response.data.uangmukaacc1no).end()
						.find('[name="acctitipanumket"]').val(response.data.uangmukaacc1desc).end()
						.find('[name="acctitipankltid"]').val(response.data.kltacc1).end()
						.find('[name="acctitipanklt"]').val(response.data.kltacc1no).end()
						.find('[name="acctitipankltket"]').val(response.data.kltacc1desc).end()
						.find('[name="acctitipansudutid"]').val(response.data.posisisudutacc1).end()
						.find('[name="acctitipansudut"]').val(response.data.posisisudutacc1no).end()
						.find('[name="acctitipansudutket"]').val(response.data.posisisudutacc1desc).end()
						.find('[name="acctitipanhadapjalanid"]').val(response.data.hadapjlnutamaacc1).end()
						.find('[name="acctitipanhadapjalan"]').val(response.data.hadapjlnutamaacc1no).end()
						.find('[name="acctitipanhadapjalanket"]').val(response.data.hadapjlnutamaacc1desc).end()
						.find('[name="acctitipanfasumid"]').val(response.data.hadapfasumacc1).end()
						.find('[name="acctitipanfasum"]').val(response.data.hadapfasumacc1no).end()
						.find('[name="acctitipanfasumket"]').val(response.data.hadapfasumacc1desc).end()
						.find('[name="acctitipanredesignid"]').val(response.data.redesignbangunanacc1).end()
						.find('[name="acctitipanredesign"]').val(response.data.redesignbangunanacc1no).end()
						.find('[name="acctitipanredesignket"]').val(response.data.redesignbangunanacc1desc).end()
						.find('[name="acctitipantambahkwalitasid"]').val(response.data.tambahkwalitasacc1).end()
						.find('[name="acctitipantambahkwalitas"]').val(response.data.tambahkwalitasacc1no).end()
						.find('[name="acctitipantambahkwalitasket"]').val(response.data.tambahkwalitasacc1desc).end()
						.find('[name="acctitipanpekerjaantambahid"]').val(response.data.pekerjaantambahacc1).end()
						.find('[name="acctitipanpekerjaantambah"]').val(response.data.pekerjaantambahacc1no).end()
						.find('[name="acctitipanpekerjaantambahket"]').val(response.data.pekerjaantambahacc1desc).end()
						.find('[name="acctitipanhrgjualid"]').val(response.data.hargajualacc1).end()
						.find('[name="acctitipanhrgjual"]').val(response.data.hargajualacc1no).end()
						.find('[name="acctitipanhrgjualket"]').val(response.data.hargajualacc1desc).end()
						.find('[name="acctitipanpiutangid"]').val(response.data.piutangacc1).end()
						.find('[name="acctitipanpiutang"]').val(response.data.piutangacc1no).end()
						.find('[name="acctitipanpiutangket"]').val(response.data.piutangacc1desc).end()

						.find('[name="accpenerimaankprid"]').val(response.data.penerimaankpracc).end()
						.find('[name="accpenerimaankpr"]').val(response.data.penerimaankpraccno).end()
						.find('[name="accpenerimaankprket"]').val(response.data.penerimaankpraccdesc).end()
						.find('[name="accpenerimaanbfid"]').val(response.data.bookingfeeacc).end()
						.find('[name="accpenerimaanbf"]').val(response.data.bookingfeeaccno).end()
						.find('[name="accpenerimaanbfket"]').val(response.data.bookingfeeaccdesc).end()
						.find('[name="accpenerimaanumid"]').val(response.data.uangmukaacc).end()
						.find('[name="accpenerimaanum"]').val(response.data.uangmukaaccno).end()
						.find('[name="accpenerimaanumket"]').val(response.data.uangmukaaccdesc).end()
						.find('[name="accpenerimaankltid"]').val(response.data.kltacc).end()
						.find('[name="accpenerimaanklt"]').val(response.data.kltaccno).end()
						.find('[name="accpenerimaankltket"]').val(response.data.kltaccdesc).end()
						.find('[name="accpenerimaansudutid"]').val(response.data.posisisudutacc).end()
						.find('[name="accpenerimaansudut"]').val(response.data.posisisudutaccno).end()
						.find('[name="accpenerimaansudutket"]').val(response.data.posisisudutaccdesc).end()
						.find('[name="accpenerimaanhadapjalanid"]').val(response.data.hadapjlnutamaacc).end()
						.find('[name="accpenerimaanhadapjalan"]').val(response.data.hadapjlnutamaaccno).end()
						.find('[name="accpenerimaanhadapjalanket"]').val(response.data.hadapjlnutamaaccdesc).end()
						.find('[name="accpenerimaanfasumid"]').val(response.data.hadapfasumacc).end()
						.find('[name="accpenerimaanfasum"]').val(response.data.hadapfasumaccno).end()
						.find('[name="accpenerimaanfasumket"]').val(response.data.hadapfasumaccdesc).end()
						.find('[name="accpenerimaanredesignid"]').val(response.data.redesignbangunanacc).end()
						.find('[name="accpenerimaanredesign"]').val(response.data.redesignbangunanaccno).end()
						.find('[name="accpenerimaanredesignket"]').val(response.data.redesignbangunanaccdesc).end()
						.find('[name="accpenerimaantambahkwalitasid"]').val(response.data.tambahkwalitasacc).end()
						.find('[name="accpenerimaantambahkwalitas"]').val(response.data.tambahkwalitasaccno).end()
						.find('[name="accpenerimaantambahkwalitasket"]').val(response.data.tambahkwalitasaccdesc).end()
						.find('[name="accpenerimaanpekerjaantambahid"]').val(response.data.pekerjaantambahacc).end()
						.find('[name="accpenerimaanpekerjaantambah"]').val(response.data.pekerjaantambahaccno).end()
						.find('[name="accpenerimaanpekerjaantambahket"]').val(response.data.pekerjaantambahaccdesc).end()
						.find('[name="accpenerimaanhrgjualid"]').val(response.data.hargajualacc).end()
						.find('[name="accpenerimaanhrgjual"]').val(response.data.hargajualaccno).end()
						.find('[name="accpenerimaanhrgjualket"]').val(response.data.hargajualaccdesc).end()
						.find('[name="acchppid"]').val(response.data.hppacc).end()
						.find('[name="acchpp"]').val(response.data.hppaccno).end()
						.find('[name="acchppket"]').val(response.data.hppaccdesc).end()
						.find('[name="accpersediaanid"]').val(response.data.persediaanacc).end()
						.find('[name="accpersediaan"]').val(response.data.persediaanaccno).end()
						.find('[name="accpersediaanket"]').val(response.data.persediaanaccdesc).end();

					if (response.hasil == "OK") {
	        			wrapper.slideUp('fast', function(){
			            	wrapper.hide();
			            	wrapperForm.show();	
			            });
                    } else console.log('No Record to display');
				});
			//return output;
		};

		var handleValidation = function(status) {    	
	    	//console.log('start validasi');
	    	if (status == 'edit') {
				urls = siteurl+"Perencanaan/typerumah/typerumah_update";
			} else if (status == 'new') {
				urls = siteurl+"Perencanaan/typerumah/typerumah_add";
			} else if (status == 'copy') {
				urls = siteurl+"Perencanaan/typerumah/typerumah_add";
			}
	    	//var table = grid.getDataTable();// $('#datatable_ajax').DataTable();
	        form.validate({
	        errorElement: 'span', //default input error message container
	        errorClass: 'help-block', // default input error message class
	        focusInvalid: true, // do not focus the last invalid input
	            rules: {
	                typerumah: {required: true, minlength: 5},
	                keterangan: {required: true},
	                luastanah: {required: true, number: true},
	                luasbangunan: {required: true, number: true},
	            },
	            messages:
	            {
	                typerumah:{required: "Nomor Kavling Perlu diisi"},
	                keterangan:{required: "Nama Pemesanan harus diisi"},
	                luastanah:{required: "Alamat Pemesanan harus diisi"},
	                luasbangunan:{required: "Nama Pemesanan harus diisi"},
	            },

	            highlight: function(element) { // hightlight error inputs
	                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
	                //console.log("error");

	            },
	            success: function(label) {
	               // console.log('submit sukses');
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit     
		           // console.log('invalid handler');
		            $(document).scrollTop( $(".form-body").offset().top ); 
	        	},

	            submitHandler: function(e){
	                // Post Data Form
	                var data = form.serialize();

	                $.ajax({
	                        type: 'post',
	                        dataType: 'json',
	                        url: urls, // ajax source
	                        data: data, //{data, dataTable: datatable},
	                        error: function (xhr, error, thrown) {
	                                    App.alert({
				                                type: 'danger',
				                                icon: 'warning',
				                                message: xhr.responseText,
				                                container: grid.gettableContainer(),
				                                place: 'prepend',
				                                closeInSeconds: 3 // auto close in 5 seconds
				                            });
	                                }
	                    	}).success(function(response) {
	                    		if (response.status) {
		                    		App.alert({
			                            type: 'success',
			                            icon: 'info',
			                            message: "Process Complated..",
			                            container: grid.gettableContainer(),
			                            place: 'prepend',
			                            closeInSeconds: 3 // auto close in 5 seconds
			                        });
			                        grid.getDataTable().ajax.reload();
						            wrapper.slideDown('fast', function(){
							           	wrapperForm.hide();	
							        });
		               //      		bootbox.alert("Data sudah di proses...!!", function()
		               //      		{ 
		               //      		  grid.getDataTable().ajax.reload();
						           //    wrapper.slideDown('fast', function(){
							          //  	wrapperForm.hide();	
							          // });
		               //      		});
		                    	}
	                        });
	                
	                return false;
	            }
	    	});
	    };
    }; //end of handleRecords

    return {
        //main function to initiate the module
        init: function () {
            handleRecords();
        }

    };

}();


jQuery(document).ready(function() {	
    typerumah.init();    
});


//http://jsfiddle.net/mijopabe/gj9axc18/5/
//
// $("#dragitem").draggable({
// 	  helper: 'clone',
// 	  revert: 'invalid',
// 	  start: function(e, ui) {
// 	  	$(this)
// 		  	.data("id","214")
// 		  	.data("acc","1-01010211")
// 		  	.data("accdesc","Bank Mandiri")
// 	  }
// 	})
// 	// .data("id","214")
// 	// .data("acc","1-01010211")
// 	// .data("accdesc","Bank Mandiri")

// 	$("#acctitipanbf,#acctitipanbfket").droppable({
// 	   accept: "#dragitem",
// 	   hoverClass: "drophover",
// 	   tolerance: "touch",
// 	   drop: function(event, ui){
// 	          // alert($(ui.draggable).data("myData"));
// 	           $("#acctitipanbfid").val((ui.draggable).data("id"));
// 	           $("#acctitipanbf").val((ui.draggable).data("acc"));
// 	           $("#acctitipanbfket").val((ui.draggable).data("accdesc"));
// 	   }
// 	});
