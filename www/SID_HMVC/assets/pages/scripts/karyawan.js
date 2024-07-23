var karyawanForm = function() {
	var handleForm = function() {
		var wrapper = $('#wrapper_karyawan');
		var table = wrapper.find('#table_karyawan');
		var wrapperForm = wrapper.find('#wrapper_form');
		var form = wrapperForm.find('#karyawanform');
		var grid = new Datatable();
		
		//var fixedassetObj = new Fixedasset();
		//var formdata;

		grid.init({
			src: table,
            dataTable: {
            	"processing": true,
            	"columns": [
	                { "data": "action",	"title": "Action", "width": "8%", "orderable": false,
	                	render: function ( data, type, row, meta ) {
		               		var dropdown = new gridDropdown();
		               		return dropdown.addDropdown(data);
		                }
	            	},
	                { "data": "noid",		"title": "#", "className": 'dt-body-right dt-head-center'},
	                { "data": "nama",		"title": "Nama", 	"width": "20%"},
	                { "data": "alamat",		"title": "Alamat", 	"width": "30%"},
	                { "data": "notelp",		"title": "No. Telp", "orderable": false},
	                { "data": "nohp",		"title": "No. HP", "orderable": false},
	                { "data": "jabatan",	"title": "Jabatan",
	                	render: function (data, type, row, meta) {
	                		var jabatandes = ["Pimpinan","Accounting","Kasir","Marketing"];
	                		return jabatandes[data-1];
	                	}
	            	}
	            ],
	            "order": [[1, 'asc']],
	            buttons: [
                    { 	extend: 'print', 
	                    className: 'btn warning',
	                    autoPrint: true,
	                    exportOptions: { columns: [1,2,3,4,5] },
	                    customize: function ( win ) {
		                    $(win.document.body)
		                        .css( 'font-size', '10pt' )
		                        // .prepend(
		                        //     '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
		                        // );
		 
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
                            //alert('Datatable reloaded!');
                        }
                    }
                ],
            	"ajax": {
            		type: "post",      
                    dataType: "json",              
					url: siteurl+"Pemasaran/karyawan/get_list",
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
            	}
            }
		}); // End of Grid.Init
		var oTable = grid.getDataTable();

		// handle datatable custom tools
        wrapper.find('#datatable_ajax_tools > li > a.tool-action').on('click', function() {
            var action = $(this).attr('data-action');
            oTable.button(action).trigger();
        });

        // Tools Button Click
        wrapper.off('click','.new, .edit, .copy').on('click','.new, .edit, .copy', function(e){        	
        	e.preventDefault();
        	var tableClick = $(this).parent('li').length;
        	var data = {noid: -1};
        	//console.log(tableClick);

        	if ($(this).hasClass('new')) {
        		data.flag = 0;
        	} else if ($(this).hasClass('edit')) {
        		data = (tableClick === 0) ? grid.getSelectedRows() : oTable.row((this).closest('tr').rowIndex-1).data();
        		data.flag = 1;
        	} else {
        		data = (tableClick === 0) ? grid.getSelectedRows() : oTable.row((this).closest('tr').rowIndex-1).data();
        		data.flag = 2;
        	}
        	//data.jabatan = 3;
         	resetFormentry(data);
        	wrapperForm.modal({backdrop: 'static', keyboard: false, show: true})
				.on('shown.bs.modal', function(){
					form.find('#nama').focus(); //set focus
				});
        });

        //Delete Button Click on Table
        wrapper.on('click', '.delete', function (e) {
            e.preventDefault();
            var tableClick = $(this).parent('li').length;
            var data = tableClick ? oTable.row((this).closest('tr').rowIndex-1).data() : oTable.row('.selected').data();
            bootbox.confirm({
            	title: "Delete Record",
    			message: "Are you sure to delete <span class='bold'>"+data.nama+" </span> ? ",
    			callback: function (result) {
			        if (! result) return;
	            	$.ajax({
						type: 'POST',
						dataType: 'JSON',
						//async: false,
						url: siteurl+'Pemasaran/karyawan/delete_record',
						data: {noid: data.noid},
						error: function(xhr, error, thrown) {									
							App.alert({
	                            type: 'danger',
	                            icon: 'warning',
	                            message: xhr.responseText,
	                            container: grid.gettableContainer(),
	                            place: 'prepend',
	                            //closeInSeconds: 3 // auto close in 5 seconds
	                        });
						},
						success: function(json) {
							if (json == 'OK') {
								App.alert({
	                                type: 'success',
	                                icon: 'info',
	                                message: "Record has been deleted..",
	                                container: grid.gettableContainer(),
	                                place: 'prepend',
	                                closeInSeconds: 3 // auto close in 5 seconds
	                            });
								oTable.ajax.reload();
							}
						}
					});
			    }
            }).find('.modal-header').css({'background-color': '#D91E18', color: 'white'});
            //box.find('.modal-header').css({'background-color': '#D91E18', color: 'white'})
        });

        /*--------------------------------------------------------------
				HANDLE FORM KARYAWAN
        --------------------------------------------------------------*/        
        wrapperForm.on('changed.bs.select','#jabatan',function(e, clickedIndex, newValue, oldValue) {
	        var selectedD = $(this).find('option:eq(' + clickedIndex + ')').val();
	        //console.log(selectedD);
	    });

        //Reset Form
        var resetFormentry = function(aData){
        	var caption = ['New','Edit','Copy'];
        	form.trigger('reset');
        	//formValidation.resetForm();
            form.find('.form-group').removeClass('has-error');

            form.find('#nama').focus(); //set focus

        	wrapperForm.find('.caption-helper').text(caption[aData.flag]);
    		//form.find('select[name=jabatan]').selectpicker('val',aData.jabatan);

        	wrapperForm.find('#noid').text(aData.flag === 2 ? -1 : aData.noid).end();
        	form
        		.find('#noid').val(aData.noid).end()
        		.find('#flag').val(aData.flag).end()
        		.find('#nama').val(aData.nama).end()
        		.find('#alamat').val(aData.alamat).end()
        		.find('#notelp').val(aData.notelp).end()
        		.find('#nohp').val(aData.nohp).end()
        		.find('select[name=jabatan]').selectpicker('val',aData.jabatan);
        };

        //Form Validation
        form.validate({
		errorElement: 'span', //default input error message container
	    errorClass: 'help-block', // default input error message class
	    focusInvalid: true, // do not focus the last invalid input
	        rules: {                
	            nama: {required: true},
	            alamat: {required: true},
	        },
			messages:
			{
				nama:{required: "Nama harus diisi"},
				alamat:{required: "Alamat harus diisi"},
			},
			highlight: function(element) { // hightlight error inputs
	            $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
	        },
			success: function(label) {
	            label.closest('.form-group').removeClass('has-error');
	            label.remove();						
	        },
			submitHandler: function(e){				
				aData = form.serialize();
				//console.log(aData);
				//return false;
				$.ajax({
					type: 'POST',
					dataType: 'JSON',
					url: siteurl+'Pemasaran/karyawan/save_record',
					//data: {record: JSON.stringify(faData)},
					data: {record: aData},
					error: function(xhr, error, thrown) {									
						App.alert({
                            type: 'danger',
                            icon: 'warning',
                            message: xhr.responseText,
                            container: grid.gettableContainer(),
                            place: 'prepend',
                            //closeInSeconds: 3 // auto close in 5 seconds
                        });
					},
					success: function(json) {
						//console.log(json);
						if (json == 'OK') {
							App.alert({
	                            type: 'success',
	                            icon: 'info',
	                            message: "Process Complated..",
	                            container: grid.gettableContainer(),
	                            place: 'prepend',
	                            closeInSeconds: 3 // auto close in 5 seconds
	                        });
	                        oTable.ajax.reload();
						}
						wrapperForm.modal("hide");				
						return false;						
					}
				});
			}  
		});

	}; //end of handleForm

	return {
		init: function() {
			handleForm();
		}
	}; 
}(); //end of karyawanForm

jQuery(document).ready(function() {
	karyawanForm.init();
});