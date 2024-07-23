var fixedassetForm = function() {
	var handleForm = function() {
		var wrapper = $('#row_fixedasset');
		var table = wrapper.find('#table_fixedasset');
		var wrapperForm = wrapper.find('#row_aktivaform');
		var form = wrapperForm.find('#aktivaform');
		var wrapperLinkaccount = wrapper.find('#row_linkaccount');
		var grid = new Datatable();
		
		var fixedassetObj = new Fixedasset();
		var formdata;

		grid.init({
		//oTable = table.DataTable({
			src: table,
            dataTable: {
            	"columns": [
	                { "data": "action",			"title": "Action", 			"width": "8%", "orderable": false},
	                { "data": "noid",			"title": "#", 				"className": 'dt-body-right dt-head-center'},
	                { "data": "namaaktiva",		"title": "Nama Aktiva", 	"width": "20%"},
	                { "data": "bulanperolehan", "title":"BL-TH Perolehan",	"className": 'dt-right', "width": "10%", "orderable": false,
		                render: function ( data, type, row, meta ) {
			               	return ((intVal(data) > 9) ? data : "0" + data)+'-'+row.tahunperolehan;
			            }
		            },
	                { "data": "totalharga", "title": "Tot. Harga", "className": 'dt-right', 
	                	render: function ( data, type, row, meta ) {
			               	return intVal(data).format(2, 3, '.', ',');
		                } 
		            },
		            { "data": "usiaekonomis", "title": "Usia", "className": 'dt-right'},
		            { "data": "penyusutanbulan_II", "title": "Penyusutan", "className": 'dt-right', "orderable": false, 
		            	render: function ( data, type, row, meta ) {
			               	return intVal(data).format(2, 3, '.', ',');
			            }
		            },
		            { "data": "akumpenyusutan", "title": "Akum. Peny", "className": 'dt-right', 
		            	render: function ( data, type, row, meta ) {
			               	return intVal(data).format(2, 3, '.', ',');
		                }
		            },
		            { "data": "nilaibuku", "title": "Nilai Buku", "className": 'dt-right bold bg-warning', 
		            	render: function ( data, type, row, meta ) {
			               	return intVal(data).format(2, 3, '.', ',');
		                }
		            },
		            {"data": null, "className": "details-control", "defaultContent": '', "orderable": false, "width": "5%",}
	            ],
	            "order": [[1, 'asc']],
	            buttons: [
                    { 	extend: 'print', 
	                    className: 'btn warning',
	                    autoPrint: true,
	                    exportOptions: { columns: [1,2,3,4,5,6,7,8] },
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
                    { extend: 'pdf', className: 'btn default', exportOptions: { columns: [1,2,3,4,5,6,7,8] } },
                    { extend: 'excelHtml5', 
                    		className: 'btn default',
                    		exportOptions: { columns: [1,2,3,4,5,6,7,8] },
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
					url: siteurl+"Accounting/fixedasset/get_fixedasset_list",
					error: function (xhr, error, thrown) {
							wrapper.find('.info').html(xhr.responseText);
						}
            	}
            }
		}); // End of Grid.Init
		var oTable = grid.getDataTable();

		/*-------------------------------------------
				HANDLE PENYUSUTAN
		---------------------------------------------*/
		function fnFormatDetails(table_id, html) {
		    var sOut = "<table id=\"exampleTable_" + table_id + "\">";
		    sOut += html;
		    sOut += "</table>";
		    return sOut;
		}

		var detailsTableHtml = $("#table_penyusutan").html();
		var detailsTable = $("#table_penyusutan");
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
                row.child(fnFormatDetails(row.data().noid, detailsTableHtml)).show();
                tr.addClass('shown');
                oInnerTable = $("#exampleTable_" + row.data().noid).dataTable({
                    "dom": "<'table-responsive't>",
                    "ordering": false,
                    "columns": [
		                { "data": "no",			"title": "#", 			"width": "8%"},
		                { "data": "bulansusut", "title":"BL-TH disusutkan",	"className": 'dt-center',
			                render: function ( data, type, row, meta ) {
				               	return ((intVal(data) > 9) ? data : "0" + data)+'-'+row.tahunsusut;
				            }
			            },
		                { "data": "tglpenyusutan",		"title": "Tanggal", "className": 'dt-body-right dt-head-center',
		                	render: function ( data, type, row, meta ) {
				               	return changedate(data, 'DMY');
				            }
		            	},
		                { "data": "penyusutan",		"title": "Penyusutan", "className": 'dt-right',
		                	render: function ( data, type, row, meta ) {
				               	return intVal(data).format(2, 3, '.', ',');
				            }
		            	},
		                { "data": "nilaibuku",		"title": "Nilai Buku",  "className": 'dt-right',
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
	                    url: siteurl+"Accounting/fixedasset/get_fixedasset_detail",
	                    data: function (d) {
	                        d.id = row.data().noid;
	                    }, 
	                    error: function (xhr, error, thrown) {
	                               wrapper.find('.info').html(xhr.responseText);
	                               //console.log('error');
	                            },
	                },
	                "footerCallback": function ( row, data, start, end, display ) {
		                var api = this.api();
		     
		                // Total over all pages
		                total = api
		                    .column( 3 )
		                    .data()
		                    .reduce( function (a, b) {
		                        return intVal(a) + intVal(b);
		                    }, 0 );
		     
		                // Update footer
		                $( api.column( 3 ).footer() ).html(
		                    total.format(2, 3, '.', ',')
		                );
		            },
                });
            }
        });
       
        /*------------------ end of HANDLE PENYUSUTAN */

		// handle datatable custom tools
        wrapper.find('#datatable_ajax_tools > li > a.tool-action').on('click', function() {
            var action = $(this).attr('data-action');
            oTable.button(action).trigger();
        });

        form.find(".touchspin").TouchSpin({
            min: 1,
            initval: 1,
            buttondown_class: "btn red",
            buttonup_class: "btn green"
        });

        wrapper.off('click','.new, .edit, .copy').on('click','.new, .edit, .copy', function(e){        	
        	e.preventDefault();
        	var flag;
        	var noid;
        	var tableClick = $(this).parent('li').length;

        	if ($(this).hasClass('new')) {
        		flag = 0;
        		noid = -1;
        	} else if ($(this).hasClass('edit')) {
        		flag = 1;
        		noid = (tableClick === 0) ? grid.getSelectedRows().noid : oTable.row((this).closest('tr').rowIndex-1).data().noid;
        	} else {
        		flag = 2;
        		noid = (tableClick === 0) ? grid.getSelectedRows().noid : oTable.row((this).closest('tr').rowIndex-1).data().noid;
        	}
        	formdata = fixedassetObj.getRecord(noid, flag);
        	resetFormentry(formdata);
        	wrapperForm.modal({backdrop: 'static', keyboard: false, show: true})
				.on('shown.bs.modal', function(){
					form.find('#namaaktiva').focus(); //set focus
				});
				// .on('hide.bs.modal', function(event){
				// });
        });

        //Delete Button Click on Table
        wrapper.on('click', '.delete', function (e) {
            e.preventDefault();
            var tableClick = $(this).parent('li').length;
            var data = tableClick ? oTable.row((this).closest('tr').rowIndex-1).data() : oTable.row('.selected').data();
            bootbox.confirm("Are you sure to delete "+data.namaaktiva+" ? ", function(result){ 
            	if (! result) return;
            	formdata = fixedassetObj.getData();
            	formdata.noid = data.noid;
	            fixedassetObj.deleteRecord(function(status, aData){
	            	if (status === true) {
	            		oTable.ajax.reload();
	            	} else {
	            		wrapper.find('.info').html(aData);
	            	}
	            });	            
            });
        });

        

        /********************* Start bulan-tahun combobox ***************/
        var arbulan = ["Januari","Februari","Maret",'April',"Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        var tgl = new Date();
        var tahun = tgl.getFullYear();
        var bulan = tgl.getMonth();
        var option = '';
        var i;
        for (i = 0; i < arbulan.length; i++) {
        	option += "<option value='"+(i+1)+"'>"+arbulan[i]+"</option>";
        }
        wrapperForm.find('.bulan').html(option);//.val(bulan+1);

        option = '';
        for (i = 20 - 1; i >= 0; i--) {
        	option += "<option value='"+(tahun-i)+"' data-value="+(tahun-i)+" >"+(tahun-i)+"</option>";
        }

        for (i = 1; i < 10; i++) {
        	option += "<option value='"+(tahun+i)+"' data-value="+(tahun+i)+">"+(tahun+i)+"</option>";
        }
        wrapperForm.find('.tahun').html(option);//.val(tahun);
        $('.tahun').selectpicker('refresh');

        arbulan = undefined; tgl = undefined; tahun = undefined; option = undefined; i = undefined;
        /********************* end bulan-tahun combobox ***************/


        /*--------------------------------------------------------------
				HANDLE FORM AKTIVA
        --------------------------------------------------------------*/        
        form.on('changed.bs.select','#tahunperolehan',function(e, clickedIndex, newValue, oldValue) {
	        var selectedD = $(this).find('option:eq(' + clickedIndex + ')').data('value');
	        console.log($(this).val());
	    });

        //Reset Form
        var resetFormentry = function(aData){
        	var caption = ['New','Edit','Copy'];
        	formValidation.resetForm();
            form.find('.form-group').removeClass('has-error');

            form.find('#namaaktiva').focus(); //set focus

            //Set disabled Save Button if akumpenyusutan <> 0
            form.find(':submit').prop('disabled',(intVal(aData.akumpenyusutan) === 0) ? false : true);

        	wrapperForm.find('.caption-helper').text(caption[formdata.flag]);
    		form.find('select[name=tahunperolehan]').selectpicker('val',aData.tahunperolehan);
    		form.find('select[name=bulanperolehan]').selectpicker('val',aData.bulanperolehan);
    		form.find('select[name=bulansusut]').selectpicker('val',aData.bulansusut).end();
    		form.find('select[name=tahunsusut]').selectpicker('val',aData.tahunsusut).end();

        	wrapperForm.find('#noid').text(aData.noid).end();
        	form
        		.find('#namaaktiva').val(aData.namaaktiva).end()
        		.find('#harga').val(aData.harga).end()
        		.find('#qty').val(aData.qty).end()
        		.find('#totalharga').val(aData.totalharga).end()
        		.find('#usiaekonomis').val(aData.usiaekonomis).end()
        		.find('#penyusutanbulan_I').val(aData.penyusutanbulan_I).end()
        		.find('#penyusutanbulan_II').val(aData.penyusutanbulan_II).end()
        		.find('#akumpenyusutan').val(aData.akumpenyusutan).end()
        		.find('#nilaibuku').val(aData.nilaibuku).end()
        		.find('#accaktiva').val(aData.accaktiva_accountno).end()
        		.find('#accaktivadesc').val(aData.accaktiva_description).end()
        		.find('#accakumulasi').val(aData.accakumulasi_accountno).end()
        		.find('#accakumulasidesc').val(aData.accakumulasi_description).end()
        		.find('#akunbiaya').val(aData.akunbiaya_accountno).end()
        		.find('#akunbiayadesc').val(aData.akunbiaya_description).end();

        };

        //On Change Form Entry
        form.on('change','input:text, select', function(){
        	formdata.setValue($(this).attr('name'), $(this).val());
        	form.find('#totalharga').val(formdata.totalharga);
        	form.find('#penyusutanbulan_I').val(formdata.penyusutanbulan_I);
        	form.find('#penyusutanbulan_II').val(formdata.penyusutanbulan_II);
        	form.find('#nilaibuku').val(formdata.nilaibuku);
        });
        
	    //Find Link Account
	    wrapperForm.on('click','.modal-account',function(){
	    	var selectedD;
	    	var the = $(this);
	    	wrapperLinkaccount.modal({backdrop: 'static', keyboard: false, show: true});
	    	wrapperLinkaccount.off('changed.bs.select','#linkaccount').on('changed.bs.select','#linkaccount',function(e, clickedIndex, newValue, oldValue) {
		        selectedD = $(this).find('option:eq(' + clickedIndex + ')').data('value');
		    });
		    wrapperLinkaccount.off('click','.ok').on('click','.ok', function(event){
		    	if (selectedD === undefined) return;
		    	ainput = the.closest('.form-group');
		    	formdata.setValue(ainput.find('input:first').attr('name'), selectedD);
		    	ainput.find('input:first').val(selectedD.accountno);
		    	ainput.find('input:last').val(selectedD.description);
			});
	    });

	    form.on("keypress", "input", function(event) {
    		if (event.keyCode == 13) {
		        event.preventDefault();
		        return false;
		    }
		});

	    var formValidation = form.validate({
		errorElement: 'span', //default input error message container
	    errorClass: 'help-block', // default input error message class
	    focusInvalid: true, // do not focus the last invalid input
	        rules: {                
	            namaaktiva: {required: true},
	            bulanperolehan: {required: true},
	            tahunperolehan: {required: true},
	            harga: {required: true, min:1},
	            qty: {required: true, min: 1},
	            usiaekonomis: {required: true, min: 1},
	            accaktiva: {required: true},
	            accakumulasi: {required: true},
	            akunbiaya: {required: true}
	        },
			messages:
			{
				namaaktiva:{required: "Nama aktiva harus diisi"},
				harga: {required: "Harga Perolehan harus diisi", max: "Booking fee terlalu kecil"},
			},
			highlight: function(element) { // hightlight error inputs
	            $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
	        },
			success: function(label) {
	            label.closest('.form-group').removeClass('has-error');
	            label.remove();						
	        },
			submitHandler: function(e){				
				fixedassetObj.saveRecord(function(status, aData){
				if (status === true) {
					formdata = aData;
	    			resetFormentry(formdata);
	    			oTable.ajax.reload();	
				} else {
					wrapper.find('.info').html(aData);
				}
	    		
	    	});	 
			}  
		});

	    /*------------------- End of Form Aktiva ----------- */
	}; //end of handleForm

	/***********************************
	Class Handling FixedAsset
	created by : Mastika - 6 maret 2017 
	***********************************/
	var Fixedasset = function () {	
		var the;
		var faData = resetFirst();

		function resetFirst() {
			var tgl = new Date();
			return {
				noid: -1,
				namaaktiva: '',
				bulanperolehan: tgl.getMonth(),// getMonthFormatted(),
				tahunperolehan: tgl.getFullYear(),
				harga: 0,
				qty: 1,
				totalharga: 0,
				usiaekonomis: 1,
				penyusutanbulan_I: 0,
				penyusutanbulan_II: 0,
				bulansusut: tgl.getMonth(),// getMonthFormatted(),
				tahunsusut: tgl.getFullYear(),
				akumpenyusutan: 0,
				nilaibuku: 0,
				accaktiva: -1,
				accaktiva_accountno: '', 
				accaktiva_description: '', 
				accakumulasi: -1, 
				accakumulasi_accountno: '', 
				accakumulasi_description: '', 
				akunbiaya: -1, 
				akunbiaya_accountno: '', 
				akunbiaya_description: '',
				flag:0, //New Record,
				calculate: function() {
					this.totalharga = this.harga * this.qty; 
					var pecahan = this.totalharga / this.usiaekonomis;
					var bulat = Math.round(pecahan);
					this.penyusutanbulan_I = bulat + (this.totalharga - (bulat * this.usiaekonomis));
					this.penyusutanbulan_II = bulat;
					this.nilaibuku = this.totalharga - this.akumpenyusutan;
				},				
				setValue: function(name, value) {
					var arname = ['harga','qty','usiaekonomis'];
					var arlinkaccount = ['accaktiva','accakumulasi','akunbiaya'];
					$.each(faData,function(index, item){
						if (index == name) {
							if ($.inArray(index, arname) >= 0) {
								//Set Price
								faData[index] = value;
								faData.calculate();
							} else if ($.inArray(index, arlinkaccount) >= 0) {
								//Set Link Account (rekid, accoutno, Description)
								var accno = index+'_accountno';
								var accdesc = index+'_description';
								faData[index] = value.rekid;
								faData[accno] = value.accountno;
								faData[accdesc] = value.description;
							} else {
								//Set General
								faData[index] = value;
							}
							return true;
						}
					});
					return false;
				}
			};
		}

		function resetdata() {
			var tgl = new Date();
			faData.flag = 0;
			faData.noid = -1;
			faData.namaaktiva = '';
			faData.bulanperolehan = tgl.getMonth()+1;// getMonthFormatted(),
			faData.tahunperolehan = tgl.getFullYear();
			faData.harga = 0;
			faData.qty = 1;
			faData.totalharga = 0;
			faData.usiaekonomis = 1;
			faData.penyusutanbulan_I = 0;
			faData.penyusutanbulan_II = 0;
			faData.bulansusut = tgl.getMonth()+1;// getMonthFormatted(),
			faData.tahunsusut = tgl.getFullYear();
			faData.akumpenyusutan = 0;
			faData.nilaibuku = 0;
			faData.accaktiva = -1;
			faData.accaktiva_accountno = ''; 
			faData.accaktiva_description = ''; 
			faData.accakumulasi = -1; 
			faData.accakumulasi_accountno = ''; 
			faData.accakumulasi_description = ''; 
			faData.akunbiaya = -1; 
			faData.akunbiaya_accountno = ''; 
			faData.akunbiaya_description = '';
		}

		return {
			init: function(options) {
				//code
			},
			getRecord: function(id, flag) {
				faData.flag = (flag === undefined) ? 0 : flag;
				//console.log(faData.flag, flag);
				if (flag === 0) { //New Record
					resetdata();
					return faData;
				}
				$.ajax({
					type: 'POST',
					dataType: 'JSON',
					async: false,
					url: siteurl+'Accounting/fixedasset/get_fixedasset',
					data: {id: id},
					error: function(xhr, error, thrown) {									
						console.log(xhr.responseText);
						faData.detail = [];
					},
					success: function(json) {
						faData.noid = (flag === 1) ? json.noid : -1;
						faData.namaaktiva = json.namaaktiva;
						faData.bulanperolehan = json.bulanperolehan;
						faData.tahunperolehan = json.tahunperolehan;
		            	faData.harga = json.harga;
		            	faData.qty = json.qty;
		            	faData.totalharga = json.totalharga;
		            	faData.usiaekonomis = json.usiaekonomis;
		            	faData.penyusutanbulan_I = json.penyusutanbulan_I;
		            	faData.penyusutanbulan_II = json.penyusutanbulan_II;
		            	faData.bulansusut = json.bulansusut;
		            	faData.tahunsusut = json.tahunsusut;
		            	faData.akumpenyusutan = (flag === 1) ? json.akumpenyusutan : 0;
		            	faData.nilaibuku = (flag === 1) ? json.nilaibuku : json.totalharga;
		            	faData.accaktiva = json.accaktiva;
						faData.accaktiva_accountno= json.accaktiva_accountno; 
						faData.accaktiva_description= json.accaktiva_description; 
						faData.accakumulasi = json.accakumulasi;
						faData.accakumulasi_accountno= json.accakumulasi_accountno; 
						faData.accakumulasi_description= json.accakumulasi_description; 
						faData.akunbiaya = json.akunbiaya;
						faData.akunbiaya_accountno= json.akunbiaya_accountno; 
						faData.akunbiaya_description= json.akunbiaya_description;
					}
				});
				return faData;
			}, //end of getRecord

			saveRecord: function(handleData) {
				$.ajax({
					type: 'POST',
					dataType: 'JSON',
					async: false,
					url: siteurl+'Accounting/fixedasset/save_fixedasset',
					data: {record: JSON.stringify(faData)},
					error: function(xhr, error, thrown) {									
						//console.log(xhr.responseText);
						handleData(false, xhr.responseText);
						return false;
					},
					success: function(json) {
						if (json == 'OK') {
							resetdata();
							handleData(true, faData);
						}
						return true;
					}
				});
			}, //end of saveRecord

			deleteRecord: function(handleData){
				$.ajax({
					type: 'POST',
					dataType: 'JSON',
					async: false,
					url: siteurl+'Accounting/fixedasset/delete_fixedasset',
					data: {noid: faData.noid},
					error: function(xhr, error, thrown) {									
						handleData(false, xhr.responseText);
					},
					success: function(json) {
						if (json == 'OK') {
							handleData(true, faData);
						}
					}
				});
			},

			getData: function() {
				return faData;
			}
		};
	}; //end of fixedasset class

	return {
		init: function() {
			handleForm();
		}
	}; 
}(); //end of fixedassetForm

jQuery(document).ready(function() {
	fixedassetForm.init();
});