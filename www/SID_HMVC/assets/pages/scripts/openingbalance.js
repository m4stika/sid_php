var openingbalanceform = function() {
	var handleForm = function() {
		var table = $('#table_openingbalance');
		var wrapper = table.closest('#row_openingbalance');
		var onchange = false;

		var openingbalanceObj = new Openingbalance();
		openingbalanceObj.init();
		var formData = openingbalanceObj.getRecord();
		var grid = new Datatable();
		//nTable = table.DataTable({
		grid.init({
            src: table,
            select: false,
            dataTable: {
	            "dom": "<t>",
	         //    scrollY: 400,
	         //    scroller: {
	         //        loadingIndicator: true
	         //    },
		        // "scrollCollapse": true,
	            "paging": false,
	            "ordering": false,
	            "serverSide": false,
	            "columnDefs": [
	                {
	                    "targets": [4,5],
	                    "className": 'dt-right',                        
	                },
	            ],
	            "columns": [
	                { "data": "action", render: function ( data, type, row, meta ) {
		               	var label = "<i class='delete fa fa-trash-o fa-2x font-red-thunderbird'></i>";
		               	if (data == 'lock') {
		               		var className = formData.journalStatus == 4 ? 'red-mint' : 'yellow-crusta';
		               		label = "<i class='fa fa-lock font-"+ className +"'></i>";
		               	}
		               	return label;
		               }
		            },
	                { "data": "rekid"},
	                { "data": "accountno"},
	                { "data": "description"},
	                { "data": "debit", render: function ( data, type, row, meta ) {
		               	var amount = intVal(data);
		               	amount = amount.format(2, 3, '.', ',');
	               		amount = (row.rekid == '305') ? amount : "<input type='text' name='debit' class='numeric form-control' value ='"+amount+"'>";
		               	return amount;
		               }
		            },
		            { "data": "credit", render: function ( data, type, row, meta ) {
		               	var amount = intVal(data);
		               	amount = amount.format(2, 3, '.', ',');
	               		amount = (row.rekid == '305') ? amount : "<input type='text' name='credit' class='numeric form-control' value ='"+amount+"'>";
		               	return amount;
		               }
		            },
	            ],
	           
	            "footerCallback": function ( row, data, start, end, display ) {
	                // Update footer
	                var api = this.api(); 
	                $( api.column( 4 ).footer() ).html(
	                      'Rp. '+ formData.totalDebit.format(2, 3, '.', ',')
	                  );
	                $( api.column( 5 ).footer() ).html(
	                      'Rp. '+ formData.totalCredit.format(2, 3, '.', ',')
	                  );
	                var selisih_abs = Math.abs(formData.selisih);
	                (formData.selisih >= 0) ? 
	                		wrapper.find('#amountalocated').text('Rp. '+ selisih_abs.format(2, 3, '.', ',')) :
	                		wrapper.find('#amountalocated').text('Rp. ('+ selisih_abs.format(2, 3, '.', ',') + ')');

	                //console.log(formData.totalDebit, formData.totalCredit, onchange);
	                //console.log('ok') : console.log('NO'); // 
	                (onchange) ? wrapper.find('.save1').removeAttr('disabled') : wrapper.find('.save1').attr('disabled','disabled');
	            },
	            "ajax": function (data, callback, settings) {
			        callback({ 
			        	data: formData.detail
			        });
			    }
	        }
        }); //end of DataTable
        var nTable = grid.getDataTable();

        wrapper.find('.caption-helper').text(formData.bulan+'-'+formData.tahun);

        //Delete Button Click on Table
        table.on('click', '.delete', function (e) {
            e.preventDefault();
            //console.log($(this).context.outerHTML);
            var rowindex = (this).closest('tr').rowIndex;
            bootbox.confirm("Are you sure to delete this row ?", function(result){ 
            	if (! result) return;
            
	            if (openingbalanceObj.remove(rowindex-1)) {
	            	nTable.ajax.reload();
	            }
            });
        });

        //Save Record
        wrapper.on('click','.save1', function(e){
			e.preventDefault();
			var formData = openingbalanceObj.saveRecord();
			nTable.ajax.reload();
			//resetForm(true);
		});

        //Reset
		wrapper.on('click','.reset', function(e){
			e.preventDefault();
			formData = openingbalanceObj.getRecord();
			nTable.ajax.reload();
		});

        //form and table Input keypress
		table.on('change keydown blur','input:text',function (e) {
		    var focusTable = $(e.target).closest('table').length;
		    var focusEntry = table.find('input:text');
		    var indexCount = focusEntry.length;
		    var index;

		    if (e.type == 'change' && onchange === false) {
	    		onchange = true;
	    		//if (formData.journalStatus != 4)
	    		if (onchange)  {
	    			wrapper.find('.save1').removeAttr('disabled');
	    		} else {
	    			wrapper.find('.save1').attr('disabled','disabled');
	    		}


		    }
		    if (onchange && (e.type == 'focusout' || e.which === 13)) {
		        var item;
		        // if ($(this).attr('name') == 'debit' || $(this).attr('name') == 'credit')
		         	item = {title: $(this).attr('name'), value: $(this).val()};
		        // else item = {title: $(this).attr('name'), value: $(this).val()};

		        index = focusEntry.index(this) + 1;

		        //if (focusTable > 0) {
		        var rowindex = (this).closest('tr').rowIndex;
		        openingbalanceObj.setRow(item, rowindex-1);
		        //if (item.title == 'debit' || item.title == 'credit') {
	        	var recordobj = formData.detail;
	        	if (item.title == 'debit') {// && recordobj[rowindex-1].debit !== 0) {
	        		//(recordobj[rowindex-1].debit !== 0) ? index++ : index = index;
	        		index++;
	        		//console.log('update');
	        		//this.select();
	        	}
	        	//if (recordobj[rowindex-1].debit !== 0 || recordobj[rowindex-1].credit !== 0) {
	        		nTable.row(rowindex-1).data(recordobj[rowindex-1]);
	        		nTable.row(0).data(recordobj[0]);
	        	//}
		        	
		        //}
		        nTable.draw( false );

			    // } else {
			    // 	openingbalanceObj.setRow(item);
			    // }
			    
			    if (index === indexCount) {
			    	focusEntry.eq(0).select();
			    } else focusEntry.eq(index).select();
		        onchange = false;
		    } else if (e.which === 13) {
		     	index = table.find('input:text').index(this) + 1;
		        if (index === indexCount) {
		        	focusEntry.eq(0).select();
		        } else focusEntry.eq(index).select();
		    }
		     
		});

        

        // ==================================================//
        // ================== DRAG & DROP =================== //
        // ==================================================//
        table.droppable({ //Accept from Search List
            drop: function( event, ui ) {
                var element = $(event.target); //$(event.toElement); // equivalent to $(ui.helper);
                if (element.closest('table').length) {
                    var data = $(ui.draggable).data('value');
                    if (data.balancesheetacc === '1') {
	                    if (openingbalanceObj.addRow(data)) {
	                    	nTable.ajax.reload();
	                    }
	                }
                }
            }
        });

        $(document) //Accept From Tree
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
                if (!t.closest('.jstree').length) {
                    if (t.closest('table').length) {
                        var adata = data.data.origin.get_node(data.element).data;
                        if (adata.classacc !== '0' && adata.balancesheetacc === '1') {
                           if (openingbalanceObj.addRow(adata)) nTable.ajax.reload();
                        }
                    }
                }
            });
        // End of DRAG & DROP =======================
        // 
	}; //end of handleForm
	

	/***********************************
	Class Handling Openingbalance
	created by : Mastika - 4 maret 2017 
	***********************************/
	// (function($) {
	var Openingbalance = function () {	
		var the;
		var obData = resetdata();

		function changedate (tanggal, formatdate) {
			if (tanggal === undefined) {
				tanggal = '';
			}
			if (formatdate === undefined) {
				formatdate = 'YMD';
			}
            var date = (tanggal === '') ? new Date() : new Date(tanggal);
            var month = date.getMonth() + 1;
            var tgl = date.getDate();
            if (formatdate == 'YMD') {
            	date =  date.getFullYear() + "-" + ((month > 9) ? month : "0" + month) + "-" + ((tgl > 9) ? tgl : "0" + tgl);
            } else date = ((tgl > 9) ? tgl : "0" + tgl) + "/" + ((month > 9) ? month : "0" + month) + "/" + date.getFullYear();
            return date;
		}

		function resetdata() {
			var item = {
				journalId: -1,
				journalFlag: 0,
				bulan: 0,
				tahun: 0,
				journalAutonum: 1,
		        journalGroup: 0,
		        tanggal: '',
				journaldate: '',
		        journalRemark: 'Account Opening Balance',
		        journalNo: 0,
		        journalstatus: 0,
		        totalDebit: 0,
				totalCredit: 0,
				selisih: 0,
				detail: []
			};
			item.tanggal = changedate('','DMY');
			item.journaldate = changedate('','YMD');
			return item;
		}

		function setTotal() {
			var recDetail = obData.detail;
			var totaldebit = 0;
			var totalcredit = 0;
			

			if (recDetail.length > 0) {
				for (i=1; i<recDetail.length; i++) {
					totaldebit += intVal(recDetail[i].debit);
					totalcredit += intVal(recDetail[i].credit);
				}
			}
			obData.totalDebit = totaldebit;
			obData.totalCredit = totalcredit;
			obData.selisih = (totaldebit) - (totalcredit);
			recDetail[0].credit = 0;
			recDetail[0].debit = 0;
			(obData.selisih > 0) ? recDetail[0].credit = Math.abs(obData.selisih) : recDetail[0].debit = Math.abs(obData.selisih);

			var totalikhtisarLR_Debet = intVal(recDetail[0].debit);
			var totalikhtisarLR_Credit = intVal(recDetail[0].credit);
			obData.totalDebit += totalikhtisarLR_Debet;
			obData.totalCredit += totalikhtisarLR_Credit;

		}
		
		return {
			init: function(options) {
				the = this;
				var opt = $.extend({
	                  //src: "",
	                  flag: 0,
	                  id: -1
	                }, options);

				//obData.flag = opt.flag;
				obData.journalId = opt.id;
			}, //end of INIT

			getRecord: function() {
				//if (id != -1) {
					//obData.journalID = id;
					$.ajax({
						type: 'POST',
						dataType: 'JSON',
						async: false,
						url: siteurl+'Accounting/openingbalance/get_openingbalance',
						//data: {id: id},
						error: function(xhr, error, thrown) {									
							console.log(xhr.responseText);
							obData.detail = [];
						},
						success: function(json) {
							if (json.hasrecord == '0') { 
								//obData = resetdata();
								obData.bulan = json.bulan;
								obData.tahun = json.tahun;
								obData.journalAutonum = json.autonum;
								obData.journalNo = json.journalno;
								obData.tanggal = changedate(obData.tahun+'/'+obData.bulan+'/01','DMY');
								obData.journaldate = obData.tahun+'-'+obData.bulan+'-01';
								obData.journalFlag = 0; //New Record;
								obData.detail = json.detail;
							} else {
								obData.journalId = json.journalid;
								obData.bulan = json.bulan;
								obData.tahun = json.tahun;
								obData.journalAutonum = json.autonum;
				            	obData.journalGroup = json.journalgroup;
				            	obData.tanggal = json.journaldate;
				            	obData.journalRemark = json.journalremark;
				            	obData.journalNo = json.journalno;
				            	obData.journalstatus = json.status;
				            	obData.journalRemark = json.journalremark;
				            	obData.dueamount = json.dueamount;
				            	obData.journalFlag = 1; //Edit Record
				            	obData.detail = json.detail;
				            	setTotal();
				            }	
						}
					});
				// } else {
				// 	obData = resetdata();
				// }
				return obData;
			},

			addRow: function(data) {
				if (data === undefined) {
					data = null;
				}
				if (data !== null) {
					var item = {
						action: "delete",
						rekid: intVal(data.noid),
						accountno: data.accountno,
						description: data.description,
						debitacc: data.debitacc,
						balancesheetacc: data.balancesheetacc,
						remark: 'Account Opening Balance',
						debit: 0,
						credit: 0
					};
					//console.log(data);
					obData.detail.push(item);
					setTotal();
					
					return true;
				} else return false;
			},

			setRow: function (data, index) {
				if (index === undefined) {
					index = -1;
				}
				if (data.title == 'debit') {
					obData.detail[index].debit = Math.abs(intVal(data.value));
					obData.detail[index].credit = 0; 
					setTotal();
				} else if (data.title == 'credit') {
					obData.detail[index].credit = Math.abs(intVal(data.value));
					obData.detail[index].debit = 0;
					setTotal();
				}
				//console.log(obData.detail[index]);
				return true;
			},

			remove: function(index = -1) {
				if (index == -1) return false;
					obData.detail.splice(index,1);
					setTotal();
				return true;
			},

			saveRecord: function() {
				// var datastr = JSON.stringify(obData);
				// console.log(datastr);
				//return
				$.ajax({
			            type: 'POST',
			            url: siteurl+'Accounting/journal/save_journal',
			            dataType: 'json',
			            async: false,
			            data: {
			                datajson: JSON.stringify(obData)
			            },
			            error: function (xhr, error, thrown) {									
									console.log(xhr.responseText);
								},
			            success: function(json) {
			            	console.log(json);
			            	obData = the.getRecord();
			            	//obData = resetdata(obData.journalGroup);
			            }
			        });
				return obData;
			},
		}; //end of return
	}; // end of Openingbalance

	return {
		init: function() {
			handleForm();
		}
	};
}(); //end of openingbalanceform

jQuery(document).ready(function(){
	openingbalanceform.init();
});

