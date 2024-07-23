var journalEntry = function() {
	// jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
	//     return this.flatten().reduce( function ( a, b ) {
	//         if ( typeof a === 'string' ) {
	//             a = a.replace(/[^\d.-]/g, '') * 1;
	//         }
	//         if ( typeof b === 'string' ) {
	//             b = b.replace(/[^\d.-]/g, '') * 1;
	//         }
	//         return a + b;
	//     }, 0 );
	// } );

	var handleForm = function() {
		var caption = ['New','Edit','Copy'];
		var form = $('#journal-form');
		var journalWrapper = form.closest('#row_journal');
		var table = form.find('#table_jurnaldetail');
		var onchange = false;

		//$('body').toggleClass('page-quick-sidebar-open'); 

		var journalObj = new Journal();
			journalObj.init();

			// New Record
			var formData = journalObj.getRecord(-1); //(3429);
			resetForm(false);

		var nTable = table.DataTable({
            "dom": 't',
            "pageLength": 30,
            "ordering": false,

            "columnDefs": [
                {
                    "targets": [5,6],
                    "className": 'dt-right',                        
                    //"type": "num"
                },
                {
                    "targets": [1,2,3],
                    //"className": 'bg-warning'                          
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
                { "data": "remark", render: function ( data, type, row, meta ) {
	               	var output = (formData.journalStatus == '4') ? //Closed Journal
	               		//"<span class='label label-sm label-info font-dark'> "+ row.remark +" </span>" : 
	               		data :
	               		"<input type='text' name='remark' class='form-control' value ='"+data+"'>";
	               	return output;
	               }
	            }, 
                { "data": "debit", render: function ( data, type, row, meta ) {
	               	var totdebit = intVal(row.debit);
	               	totdebit = totdebit.format(2, 3, '.', ',');
	               	if (formData.journalStatus != '4') {
	               		totdebit = "<input type='text' name='debit' class='numeric form-control' value ='"+totdebit+"'>";
	               	}
	               	return totdebit;
	               }
	            },
                { "data": "credit", render: function ( data, type, row, meta ) {
	               	var totcredit = intVal(row.credit);
	               	totcredit = totcredit.format(2, 3, '.', ',');
	               	if (formData.journalStatus != '4') {
	               		totcredit = "<input type='text' name='credit' class='numeric form-control' value ='"+totcredit+"'>";
	               	}
	               	return totcredit;
	               }
	            }
            ],
           
            "footerCallback": function ( row, data, start, end, display ) {
                // Update footer
                var api = this.api(); 
                $( api.column( 5 ).footer() ).html(
                      'Rp. '+ formData.totalDebit.format(2, 3, '.', ',')
                  );
                $( api.column( 6 ).footer() ).html(
                    'Rp. '+ formData.totalCredit.format(2, 3, '.', ',')
                );
                (formData.totalDebit !== 0 && formData.totalDebit == formData.totalCredit && onchange === true) ? journalWrapper.find('.save').removeAttr('disabled') : journalWrapper.find('.save').attr('disabled','disabled');
            },
            "ajax": function (data, callback, settings) {
		        //callback( { data: (formData.detail == null) ? '' : formData.detail } );
		        callback( { data: formData.detail} );
		    }
            //data: formData.detail 
        });

		//Delete Button Click on Table
        table.on('click', '.delete', function (e) {
            e.preventDefault();
            //console.log($(this).context.outerHTML);
            
            var rowindex = (this).closest('tr').rowIndex;
            bootbox.confirm("Are you sure to delete this row ?", function(result){ 
            	if (! result) return;
            
	            if (journalObj.remove(rowindex-1)) {
	            	nTable.ajax.reload();
	            }
            });
        });

		// Reset Entry from Data object	
		function resetForm(redraw) {
			//console.log(formData);
			journalWrapper.find('.caption-helper').text(caption[formData.journalFlag]);
			form
				.find('#blth').text(formData.bulan+'-'+formData.tahun).end()
				.find('textarea[name=remark]').val(formData.journalRemark).end()
				//.find('textarea[name=remark]').val(formData.detail[0].debit).end()
				.find('input[name=journalno]').val(formData.journalNo).end()
				.find('#groupdescription').text(formData.journalGroupdesc()).end()
				.find('[id="dptgljurnal"]').datepicker('update',formData.tanggal).end()
				.find('[id="journaldate"]').val($('#dptgljurnal').datepicker('getFormattedDate','yyyy-mm-dd')).end();
			if (redraw === true) nTable.ajax.reload();
		}

		journalWrapper.on('click','.reset', function(e){
			e.preventDefault();
			formData = journalObj.getRecord(-1);
			resetForm(true);
		});

		journalWrapper.on('click','.save', function(e){
			e.preventDefault();
			formData = journalObj.saveRecord();
			resetForm(true);
		});

		journalWrapper.on('click','.print', function(e){
			e.preventDefault();
			//$('.numeric').unmask();
			//var result = $(":input",table).serializeArray();
			//result = JSON.stringify(journalObj.getData().detail)
			//console.log(result);
			


			//journalObj.addRow();
			//formData = journalObj.getRecord(-1);
			//resetForm(true);

			//formData.saveRecord();
		});

		//form and table Input keypress
		form.on('change keydown blur','input:text, textarea',function (e) {
		    //console.log(e.type);// + ": " +  e.which);
		    
		    var focusTable = $(e.target).closest('table').length;
		    var focusEntry = form.find('input:text, textarea');
		    var indexCount = focusEntry.length;
		    var index;

		    if (e.type == 'change' && onchange === false) {
		    	//console.log(onchange);
	    		onchange = true;
	    		if (formData.journalStatus != 4)
	    		(formData.totalDebit !== 0 && formData.totalDebit === formData.totalCredit && onchange === true) ? journalWrapper.find('.save').removeAttr('disabled') : journalWrapper.find('.save').attr('disabled','disabled');
		    }
		    if (onchange && (e.type == 'focusout' || e.which === 13)) {
		         //console.log('setRow');
		        var item;

		        if ($(this).attr('name') == 'debit' || $(this).attr('name') == 'credit')
		        	item = {title: $(this).attr('name'), value: $(this).val()};
		        else item = {title: $(this).attr('name'), value: $(this).val()};

		        index = focusEntry.index(this) + 1;
		        //console.log(item);

		        if (focusTable > 0) {
			        var rowindex = (this).closest('tr').rowIndex;
			        journalObj.setRow(rowindex-1, item);
			        if (item.title == 'debit' || item.title == 'credit') {
			        	var recordobj = formData.detail;
			        	if (item.title == 'debit' && recordobj[rowindex-1].debit !== 0) 
			        		index++;
			        	if (recordobj[rowindex-1].debit !== 0 || recordobj[rowindex-1].credit !== 0)
			        		nTable.row(rowindex-1).data(recordobj[rowindex-1]);
			        	
			        }
			        nTable.draw( false );

			    } else {
			    	journalObj.setRow(-1, item);
			    }
			    if ($(this).is('textarea')) return;
			    if (index == indexCount) {
			    	focusEntry.eq(0).select();
			    } else focusEntry.eq(index).select();
		        onchange = false;
		    } else if (e.which === 13) {
		     	if ($(this).is('textarea')) return;
		     	index = form.find('input:text, textarea').index(this) + 1;
		        if (index == indexCount) {
		        	focusEntry.eq(0).select();
		        } else focusEntry.eq(index).select();
		    }
		     
		});

		// Tanggal Pembayaran Onchange
        form.on('changeDate','#dptgljurnal', function(ev){
             //form.find('#journaldate').val($(this).datepicker('getFormattedDate','yyyy-mm-dd'));
             var item = {title: 'journaldate', value: $(this).datepicker('getFormattedDate','yyyy-mm-dd')};
             journalObj.setRow(-1, item);
             form.find('textarea[name=remark]').focus();
             onchange = false;
        });

		// ==================================================//
        // ================== DRAG & DROP =================== //
        // ==================================================//
        table.droppable({ //Accept from Search List
            drop: function( event, ui ) {
                var element = $(event.target); //$(event.toElement); // equivalent to $(ui.helper);
                if (element.closest('table').length) {
                    var data = $(ui.draggable).data('value');
                    if (journalObj.addRow(data)) nTable.ajax.reload();
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
                        if (adata.classacc == 1) {
                           if (journalObj.addRow(adata)) nTable.ajax.reload();
                        }
                    }
                }
            });
        // End of DRAG & DROP =======================
        

		//$('.numeric').mask("###,###,###,##0.00", {placeholder: "0", reverse: true });

		journalWrapper.find('textarea[name=remark]').focus();

		//tab-pane change
        journalWrapper.find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
          var activeTab = journalWrapper.find("ul li.active").attr('id');
          if (activeTab == 'history')  {
          	journalWrapper.find('.save, .reset').attr('disabled','disabled'); 
          } else {
          	journalWrapper.find('.reset').removeAttr('disabled');
          	(formData.totalDebit !== 0 && formData.totalDebit === formData.totalCredit && formData.journalStatus !== 4) ? 
          		journalWrapper.find('.save, .reset').removeAttr('disabled') : journalWrapper.find('.save').attr('disabled','disabled');
          }

        });

		/***************************************
				HANDLE HISTORY
		***************************************/
		tableHistory = journalWrapper.find('#table_history_jurnal');
		tabHistory = tableHistory.closest('#tab_history');
		var grid = new Datatable();
		var DataTable;

		grid.init({
            src: tableHistory,
            onSuccess: function(grid) {},
            onError: function (grid) {},
            dataTable: {
                //"destroy": true,
                "dom": "r<''t><'row'<'col-md-8 col-sm-12'li><'col-md-4 col-sm-12'<'pull-right'p>>>", // datatable layout
                "serverSide": true,
                "lengthMenu": [
                    [10, 20, 50, 100, 150, -1],
                    [10, 20, 50, 100, 150, "All"] // change per page values here
                ],
                "pageLength": 10, // default record count per page
                // "columnDefs": [
                //     {  "targets": [0], "orderable": false, "className": "dt-body-right dt-head-center" },
                //     {  "targets": [1], "className": "dt-body-right dt-head-center" },
                //     {
                //         "targets": [6],
                //         "className": 'dt-body-right dt-head-center',
                //     },
                // ],
                "columns": [
	                //journalid, journalgroup, journalno, journaldate, dueamount, journalremark, status
	                { "data": "action"},
	                { "data": "journalid"},
	                { "data": "status", render: function( data, type, row, meta ) {
	                		var states = ["default","success","info","warning","danger"];
							var verifikasi = ["Open","Kasir","Keuangan","Pimpinan","Closed"];
							return  "<span class='label label-sm label-"+ states[data] +"'> "+ verifikasi[row.status] + "</span>";
	                	}
	            	},
	                { "data": "journaldate", render: function ( data, type, row, meta ) {
	                		return journalObj.getDate(data, 'DMY');
	                	}
	                },
	                { "data": "journalno"},
	                { "data": "journalremark", "className": 'dt-body-justify'},
                    { "data": "dueamount", 
                    	"className": 'bold dt-body-right dt-head-center bg-blue-dark bg-font-blue-dark', 
                    	"render": function ( data, type, row, meta ) {
		               		var dueamount = intVal(row.dueamount);
		               		return dueamount.format(2, 3, '.', ',');
		               		//return "<span class='bold pull-right'>" + dueamount.format(2, 3, '.', ',') + "</span>"
		                }
		            },
                ],
                "ajax": {
                    type: "post",
                    dataType: "json",                 
                    url: siteurl+'Accounting/journal/get_Listjurnal',
                    error: function (xhr, error, thrown) {
                                journalWrapper.find('.info').html(xhr.responseText);
                                //console.log('error',xhr.responseText);
                            },
                },
                //"pagingType": "simple_numbers",
                "order": []
            }
        });
        DataTable = grid.getDataTable();
        grid.setAjaxParam("customFilter", true);

        // handle filter cancel button click
        tableHistory.on('click', '.filter-cancel', function(e) {
        	grid.setAjaxParam("customFilter", true);
        });

        // Tanggal from history Onchange
        tableHistory.on('changeDate','#tglhistoryfrom', function(ev){
            tableHistory.find('#GL_tgljournal').val($(this).datepicker('getFormattedDate','yyyy-mm-dd'));
        });

        // Tanggal to history Onchange
        tableHistory.on('changeDate','#tglhistoryto', function(ev){
            tableHistory.find('#GL_tgljournalto').val($(this).datepicker('getFormattedDate','yyyy-mm-dd'));
        });

        // handle new button click
        tabHistory.on('click', '.new', function(e) {
            e.preventDefault();
            formData = journalObj.getRecord(-1);

            journalWrapper.find('#detil a:last').tab('show');
            resetForm(true);
        });

        // handle edit or copy button click
        tabHistory.on('click', '.edit, .copy', function(e) {
            e.preventDefault();

            var aData = DataTable.row('.selected').data();
            if (aData === undefined) {
            	var rowindex = (this).closest('tr').rowIndex;
            	aData = DataTable.row(rowindex-2).data();
            }
            var flag =  $(this).hasClass('edit') ? 1 : 2;

            formData = journalObj.getRecord(aData.journalid, flag);
            journalWrapper.find('#detil a:last').tab('show');
            resetForm(true);
            
        });

		
	};
	return {
		init: function() {
			handleForm();
		}
	};
}();
// End of JournalEntry


/***********************************
Class Handling Journal
created by : Mastika - 25 feb 2017 
***********************************/
// (function($) {
var Journal = function () {	
	var the;
	//var form;
	//var journalWrapper;
	var journalData = resetdata();
	//journalData.tanggal = journalData.journalDate();
	//console.log(journalData);
			


	function setTotal() {
		var recDetial = journalData.detail;
		var totaldebit = 0;
		var totalcredit = 0;
		if (recDetial) {
			for (i=0; i<recDetial.length; i++) {
				totaldebit += intVal(recDetial[i].debit);
				totalcredit += intVal(recDetial[i].credit);
			}
		}
		journalData.totalDebit = totaldebit;
		journalData.totalCredit = totalcredit;
		//console.log('Debet : ',journalData.totalDebit, 'Kredit: ',journalData.totalCredit);
	}

	function changedate (tanggal = '', formatdate = 'YMD') {
	            var date = (tanggal == '') ? new Date() : new Date(tanggal);
	            var month = date.getMonth() + 1;
	            var tgl = date.getDate();
	            if (formatdate == 'YMD') {
	            	date =  date.getFullYear() + "-" + ((month > 9) ? month : "0" + month) + "-" + ((tgl > 9) ? tgl : "0" + tgl);
	            } else date = ((tgl > 9) ? tgl : "0" + tgl) + "/" + ((month > 9) ? month : "0" + month) + "/" + date.getFullYear();
	            return date;
			}

	function getLastno(group = -1) {
		var param = {};
		if (group != -1) {
			$.ajax({
	            type: 'POST',
	            url: siteurl+'Accounting/journal/get_LastjournalNo',
	            dataType: 'json',
	            async: false,
	            data: {
	                journalgroup: group,
	            },
	            success: function(json) {
	            	param = json;
	            }
	        });
		}
		return param;
	}
	function resetdata(group = -1) {
		var journalparam = getLastno(group);
		var item = {
			bulan: journalparam.bulanbuku,
			tahun: journalparam.tahunbuku,
			journalAutonum: journalparam.autoNumber,
			journalNo: journalparam.journalNo,
			journalFlag: 0,
			journalId: -1,
			journalRemark: '-',
			tanggal: '',
			journaldate: '',
			totalDebit: 0,
			totalCredit: 0,
			journalGroup: 1,
			journalStatus: 0,
			journalGroupdesc: function() {
				var desc = ['Opening Balance','General Journal','Akad Kredit','Inventory','Kas & Bank','Fixed-Asset','Pembatalan Kontrak','Tunai Keras/Bertahap','other'];
				return desc[this.journalGroup];
			},
			detail: []
		};

		item.tanggal = changedate('','DMY');
		item.journaldate = changedate('','YMD');
		//console.log(item.tanggal, item.journaldate);
		return item;
	}

	return {
		init: function(options) {
			the = this;
			var options = $.extend({
                  //src: "",
                  flag: 0,
                  journalGroup: 1, //General Journal
                  journalid: -1
                }, options);

			journalData.journalFlag = options.flag;
			journalData.journalGroup = options.journalGroup;
			journalData.journalId = options.journalid;
		}, //end of INIT

		getRecord: function(id = -1, flag = 0) {
			//console.log('Get Record');
			journalData.journalId = id; 
			journalData.journalGroup = 1; //Set dafault General Journal
			if (journalData.journalId != -1) {
				$.ajax({
		            type: 'POST',
		            url: siteurl+'Accounting/journal/get_journal',
		            dataType: 'json',
		            async: false,
		            data: {
		                id: journalData.journalId
		            },
		            error: function (xhr, error, thrown) {									
								console.log(xhr.responseText);
								//showNotification('danger','Error Delete Record');
							},
		            success: function(json) {
		            	journalData.journalId = json.journalid;
		            	journalData.journalGroup = json.journalgroup;
		            	journalData.tanggal = json.journaldate; //journalData.journalDate(json.journaldate);
		            	journalData.journalRemark = json.journalremark;
		            	journalData.journalNo = json.journalno;
		            	journalData.journalStatus = json.status;
		            	journalData.detail = json.detail;
		            	if (flag == 2) { //copy
		            		var param = getLastno(json.journalgroup);
		            		journalData.bulan = param.bulanbuku;
							journalData.tahun = param.tahunbuku;
							journalData.journalAutonum = param.autoNumber;
							journalData.journalNo = param.journalNo;
							journalData.journalStatus = 0;
							journalData.journalId = -1;
							//journalData.journalRemark = '-',
							journalData.tanggal = changedate('','DMY');
							journalData.journaldate = changedate('','YMD');
		            	}
		            }
		        });
		    } else journalData = resetdata(journalData.journalGroup);
		    journalData.journalFlag = flag;
		    setTotal();
		    return journalData;
		},

		addRow: function(data = null) {
			if (data != null && journalData.journalStatus != 4) {
				var item = {
					action: "delete",
					rekid: data.noid,
					accountno: data.accountno,
					description: data.description,
					remark: '',
					debit: 0,
					credit: 0
				};
				journalData.detail.push(item);
				
				return true;
			} else return false;
		},

		setRow: function (index=-1, data) {
			if ( index == -1 ) { //Update Header
				if (data.title == 'journalno') journalData.journalNo = data.value
				else if (data.title == 'journaldate') {
					journalData.journaldate = data.value;
					journalData.tanggal = changedate(journalData.journaldate, 'DMY');
					console.log(journalData.tanggal, journalData.journaldate);

				} else if (data.title == 'remark') journalData.journalRemark = data.value;
				//console.log(journalData);
				return true;
			} else {
				//console.log('masuk table');
				if (data.title == 'remark') journalData.detail[index].remark = data.value
				else if (data.title == 'debit') {
					journalData.detail[index].debit = intVal(data.value);
					journalData.detail[index].credit = 0; 
					setTotal();
				} else if (data.title == 'credit') {
					journalData.detail[index].credit = intVal(data.value);
					journalData.detail[index].debit = 0;
					setTotal();
				}
			}

			//console.log(journalData.detail[index]);
			return true;
		},

		remove: function(index = -1) {
			if (index == -1) return false;
				journalData.detail.splice(index,1);
				setTotal();
			return true;
		},

		saveRecord: function() {
			var datastr = JSON.stringify(journalData);
			//console.log(datastr);
			//return
			$.ajax({
		            type: 'POST',
		            url: siteurl+'Accounting/journal/save_journal',
		            dataType: 'json',
		            async: false,
		            data: {
		                datajson: JSON.stringify(journalData)
		            },
		            error: function (xhr, error, thrown) {									
								console.log(xhr.responseText);
							},
		            success: function(json) {
		            	//console.log(json);
		            	journalData = resetdata(journalData.journalGroup);
		            }
		        });
			return journalData;
		},

		getData: function() {
			return journalData;
		},

		getDate: function(tgl, format) {
			return changedate(tgl, format);
		}
	}; //end of Return

}; //end of Journal Function
// }(jQuery))

jQuery(document).ready(function(){
	journalEntry.init();
});