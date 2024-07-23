var perkiraanBrowse = function() {
	var handlebrowse = function() {
		var wrapper = $('.row-perkiraan');
		var containerTable = wrapper.find('.table-container');
		var tTable = containerTable.find("#table_listperkiraan");
		var wrapperPerkiraanForm = $('#row-perkiraanform');
		//var perkiraanModalForm = $('#form-perkiraan');

		

	    function resetTreetable() {
	    	tTable.treetable({
		        expandable:     true,
		        indent: 10,
		        onNodeExpand:   nodeExpand,
		        onNodeCollapse: nodeCollapse
		    });

		    // expand Root with ID "-1" by default
		    getNodeViaAjax(-1);
		    $('.new, .edit, .copy, .delete', containerTable).attr('disabled','disabled');
	    }

	    function showNotification(vClass = 'success', message = 'Complate'){
	    	var alertWrapper = containerTable.find('.alert');
	    	var alertHeading = alertWrapper.find('.alert-heading');
	    	var alertMessage = alertWrapper.find('p');
	    	//var alertinfo = (vClass == 'danger') ? 'Error..!  ' : vClass+'..!  ';
	    	//alertWrapper.removeClass('hidden').addClass('alert-'+vClass);
	    	alertWrapper.removeClass('alert-warning, alert-info, alert-danger').addClass('alert-'+vClass);
	    	alertHeading.text((vClass == 'danger') ? 'Error..!  ' : vClass+'..!  ');
	    	//var strongtxt = $('strong',alertWrapper).text(alertinfo+'! ');
	    	alertMessage.text(message);
	    	alertWrapper.show();

	    	// setTimeout( function(){
	    	// 	alertWrapper.addClass('hidden');	
	    	// }, 1000);
	    }

	    resetTreetable();

	    // Highlight selected row
	    tTable.find('tbody').on("mousedown", "tr", function() {
	    	containerTable.find('.alert').slideUp();
	    	if ($(this).hasClass('selected') ) {
                $(this).removeClass('selected');
            } else {
    	        $(".selected").not(this).removeClass("selected");
    	        $(this).toggleClass("selected");
            }

	      //console.log((('.selected > tr',$(this)).attr('data-tt-parent-id') == -1));
	      $(".table-toolbar > .new",containerTable).prop("disabled", (!$(this).hasClass('selected') || $(this).hasClass('leaf')));
	      $(".table-toolbar > .edit",containerTable).prop("disabled",(!$('tr.selected').length));
          $(".table-toolbar > .copy").prop("disabled",(!$(this).hasClass('selected')) || (('.selected > tr',$(this)).attr('data-tt-parent-id') == -1));
          $(".table-toolbar > .delete").prop("disabled",(!$(this).hasClass('selected')));
	    });

	    //Expand Node
	    function nodeExpand () {
	        //$(this.row).children('td:nth-child(1)').find('i').removeClass('fa-folder').addClass('fa-folder-open');
	        $('td:nth-child(1) > i',this.row).removeClass('fa-folder').addClass('fa-folder-open');

	        if (('tr',this.row).attr('data-child-isloaded') != "true") {
	        //if (('tr',this.row).data()['childIsloaded'] != "true") {
	        	console.log('child Node not loaded');
	        	getNodeViaAjax(this.id);
	        }
	        //console.log(('tr',this.row).data());
	        // else getNodeViaAjax(this.id);  
	    }

	    //Collapse Node
	    function nodeCollapse () {
	        $(this.row).children('td:nth-child(1)').find('i').removeClass('fa-folder-open').addClass('fa-folder');
	    }

	    //Request Data from Sarver and Extract to Node List
	    function getNodeViaAjax(parentNodeID) {
	        // show loader
			App.blockUI({target: tTable, overlayColor: 'none', cenrerY: true, animate: true});
	        //$("#loadingImage").show();
	        
	        // ajax should be modified to only get childNode data from selected nodeID
	        // was created this way to work in jsFiddle
	        //new Request.JSON({
	        $.ajax({
	            type: 'POST',
	            dataType: 'json',
	            url: siteurl+'Accounting/perkiraan/get_perkiraan',
	            data: {
	                //json: JSON.stringify( jsonData )
	                id: parentNodeID
	            },
	            success: function(data) {
	            	if(data == 'ERROR') {
	            		App.unblockUI(tTable);
	            		return;
	            	}
	                //$("#loadingImage").hide();
	                
	                
	                //var data =  JSON.stringify( data );
	                
	                var childNodes = data.nodeID[parentNodeID];
	                //console.log(parentNodeID);
	                if(childNodes) {
	                    var parentNode = tTable.treetable("node", parentNodeID);
	                    if (parentNodeID >= 1) {
	                    	parentNode.row.closest('tr').attr('data-child-isloaded',"true");
	                    }

	                    for (var i = 0; i < childNodes.length; i++) {
	                        var node = childNodes[i];

	                        var nodeToAdd = tTable.treetable("node",node['ID']);

	                        // check if node already exists. If not add row to parent node
	                        if(!nodeToAdd) {
	                            // Remove the formatting to get integer data for summation
				                var intVal = function ( i ) {
				                    return typeof i === 'string' ?
				                        i.replace(/[\$,]/g, '')*1 :
				                        typeof i === 'number' ?
				                            i : 0;
				                };

	                            // create row to add
	                            var row ='<tr data-tt-id="' + node['ID'] + 
		                                 '" data-tt-parent-id="' +parentNodeID + '" ' + 
		                                 '" data-tt-rekid="' + node['rekid'] + '" '+
		                                 '" data-tt-accountno="' + node['accountno'] + '" '+
		                                 '" data-tt-description="' + node['description'] + '" '+
		                                 '" data-tt-levelacc="' + node['levelacc'] + '" ';
	                                
	                            if(node['childNodeType'] == 'branch') {
	                                row += ' data-tt-branch="true" ';
	                            }

	                            row += ' >';

	                            // Add columns to row
	                            for (var index in node['childData']) {
	                                var data = node['childData'][index];
	                                row += "<td ";
	                                //change Background column Total 
	                                if (index == 7) row += " class='bg-yellow-saffron font-blue-chambray'";

	                                row += ">";
	                                if (index == 0) {
	                                	if(node['childNodeType'] == 'branch') { //Icon Header Node
		                                	row += "<i class='fa fa-folder icon-state-warning'></i>";
		                                } else row += "<i class='fa fa-tag icon-state-info'></i>"; //Icon Detail Node
	                                } else if (index > 3) { //Column Numeric Change Font-align = Right
	                                	data = intVal(data).format(2, 3, '.', ',');
	                                	if (index == 7) {
	                                		data = "<div class='text-right sbold'>"+data+"</div>";
	                                	} else data = "<div class='text-right'>"+data+"</div>";
	                                }
	                                row += data + "</td>";
	                            }

	                            // End row
	                            row +="</tr>";
	                            
	                            tTable.treetable("loadBranch", parentNode, row);
	                        }
	                    }
	                
	                }
	                // hide loader
	                App.unblockUI(tTable);
	            },
	            error: function (xhr, error, thrown) {                                  
                	var htoastr = new myToastr(xhr['responseText'], "<h3>Error Save</h3> <hr>");
                	htoastr.toastrError();
                	App.unblockUI(tTable);
                }
	        });
	    } //end of getNodeViaAjax

		//Container Button Click (new, edit, copy)
		containerTable.off('click','.new, .edit, .copy').on('click','.new, .edit, .copy',function(){
			//var tree = tTable.data("treetable");
			//var rowIndex = $('.selected',tTable).index();
			//var parentID = tree.nodes[rowIndex].parentId;
			containerTable.find('.alert').slideUp();
			var row = $('.selected', tTable);
			var node = tTable.treetable('node',row.attr('data-tt-id'));
			var flag = $(this).val();
			
			var perkiraanForm = new Perkiraan();
			perkiraanForm.init({
				src: "#form-perkiraan",
				flag: flag,
				data: {parentId: (flag == 0) ? node.id : node.parentId,// parentId,
                  		id: (flag == 0) ? -1 : node.id
                  	}
			});
			//node = undefined;
			//row = undefined;
			wrapperPerkiraanForm.modal({backdrop: 'static', keyboard: false, show: true})
				.on('hide.bs.modal', function(event){
					var button = $(document.activeElement).hasClass('cancel');
					//var button = $(event.target);//.hasClass('cancel');
					getNodeViaAjax(node.id);
					perkiraanForm = undefined;
					//console.log('Modal closed', button);
				});
		});

		//Refresh Grid
		containerTable.on('click','.reload',function(){
			// showNotification('success','Record has been deleted..');
			// return false;
			
			tTable.treetable('destroy');
			$('tr:gt(0)',tTable).remove();

			resetTreetable();
		});

		//Delete Button Click
		containerTable.off('click','.delete').on('click','.delete',function(e){
			e.preventDefault();
			//containerTable.find('.alert').addClass('hidden');
			var data = $('.selected', tTable).data();
			//showNotification('danger','Error Deleting Record');
			handleDelete(data);
		});

		$('.alert',containerTable).on('click','.close',function(){
	        $(this).closest('.alert').slideUp();
	   	});

		// containerTable.off('click','.add').on('click','.add',function(e){
		// 	e.preventDefault();
		// 	var data = $('.selected', tTable).data();
			
		// 	var node = tTable.treetable('node',data.ttId);
		// 	console.log(data, node);
		// 	if (undefined != node){
		// 		//tTable.treetable("removeNode", node.id);
		// 		node.row.remove();
		// 	}
		// });

		
		//Handle Delete Function
		function handleDelete(aData) {
			var node = tTable.treetable('node',aData.ttParentId);
			//var parentNode = tTable.treetable('node',node.parentid);

			//console.log(node);
			//return false;

			if (aData.ttLevelacc == 5) {
				var msg = "<div class=margin-top-10'>Menghapus Data Perkiraan : <i class='bold'> ["+aData.ttAccountno+"] => "+aData.ttDescription+"</i></div> <br/> "+
						  "<span> Anda Yakin ? </span>";
			} else 
				var msg = "<div> <span> Perkiraan : <i class='bold'> ["+aData.ttAccountno+"] => "+aData.ttDescription+"</i></span> <br/> "+
						  "<div class='margin-top-10 bold font-red'>Dan Semua Perkiraan Turunanya akan terhapus </div> <br/> "+
						  "<span> Anda Yakin ? </span></div>";
			
			bootbox.confirm( {
			   // size: 'small',
				closeButton: false,
				title: 'SID - Delete Record',
				message: msg,
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
						url: siteurl+"Accounting/perkiraan/delete_perkiraan",
						data: { rekid: aData.ttRekid, levelacc: aData.ttLevelacc, keyvalue: aData.ttId },
						dataType: 'JSON',
						error: function (xhr, error, thrown) {									
								showNotification('danger',xhr['responseText']);
								//var htoastr = new myToastr(xhr['responseText'], "<h3>Error Delete Record</h3> <hr>");
								//htoastr.toastrError();
								},
						success: function(result) { 
								//var htoastr = new myToastr("Status :"+result, "<h3>SID | Delete</h3> <hr>");
								//htoastr.toastrSuccess();
								if (result.status == '1') {
									showNotification('success','Record has been deleted..');
								} else showNotification('danger',result.message);
								

								//console.log(node);
								if (undefined == node) {
									tTable.treetable('destroy');
									$('tr:gt(0)',tTable).remove();
									resetTreetable();
								} else {
									tTable.treetable("unloadBranch", node);
									
									//node.row.remove();
									getNodeViaAjax(aData.ttParentId);	
								}
								
							}
						});
						// var htoastr = new myToastr("Record has been deleted..", "<h3>SID | Delete</h3> <hr>");
						// htoastr.toastrSuccess();
					}else {
						var htoastr = new myToastr("Deleting record canceled", "<h3>SID | Delete</h3> <hr>");
						htoastr.toastrInfo();
					}
				}
			}); 
		}



	} //end of handlebrowse
	return {
		init: function() {
			handlebrowse();
		}
	}
}();

jQuery(document).ready(function () {
	perkiraanBrowse.init();
})