/****
Class Handling Perkiraan 
****/
// (function($){ //Teknik IIFE
// (function($) {
var Perkiraan = function () {
	var caption = ['New','Edit','Copy'];
	var formOptions; //main options
	var form;
	var formContainer;
	var formPortlet;
	var the;
	var formParams = {};
	var formData = {};
	var formDataParent = {};
	var handle = false;
	var formFlag = 0; //0 = New, 1 = Edit, 2 = Copy

	var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

	return {
		init: function(options) {
			the = this;
			var options = $.extend({
                  src: "",
                  flag: 0,
                  data: {parentId: -1,
                  		id: 1
                  	}
                }, options);

			formOptions = options;
			formParams = options.data;
			formFlag = options.flag;
			
			if ($(options.src) != "") {
						handle = true;
						form = $(options.src);
						formContainer = form.parents('.form');
						formPortlet = formContainer.parents('.portlet');
						
					}

			$.ajax({
	            type: 'POST',
	            url: siteurl+'Accounting/perkiraan/get_perkiraanItem',
	            dataType: 'json',
	            async: false,
	            data: {
	                //json: JSON.stringify( jsonData )
	                id: formParams.id,
	                parentid: formParams.parentId
	            },
	            error: function(errors) {
	            	console.log('error handle record');
	            },
	            success: function(json) {
	            	//console.log(json);
	            	formData = set_DataObject(json.data);
	            	formDataParent = set_DataObject(json.parent);
	            	if (formFlag == 0 || formFlag == 2) { //Data Baru dan Copy
	            		if (formFlag == 0) set_resetData(); //Reset Data untuk Perkiraan Baru

	            		//Request Account-No Baru untuk Perkiraan Baru/Copy
	            		get_newAccountNo().done(function(data){
							formData.keyvalue = data;
						});
	            	};
	            	if (handle) {
	            		handleForm();
	            		//formValidate();
	            	};
	            }
	        });

	        function set_DataObject(data) {
	        	return {
	        		rekid : (data) ? data.rekid : -1,
	        		parentkey: (data) ? data.parentkey : '', 
	        		keyvalue: (data) ? data.keyvalue : '', 
	        		//key: (data) ? data.accountno : '', 
	        		accountno: (data) ? data.accountno : '', 
					description: (data) ? data.description : '', 
					groupacc: (data) ? data.groupacc : 0, 
					classacc: (data) ? data.classacc : 0, 
					levelacc: (data) ? data.levelacc : 0, 
					balancesheetacc: (data) ? data.balancesheetacc : true, 
					debitacc: (data) ? data.debitacc : 1, 
					openingbalance: (data) ? data.openingbalance : 0, 
					transbalance: (data) ? data.transbalance : 0, 
					balancedue: function() {
						return intVal(this.openingbalance) + intVal(this.transbalance);
					},
					autonumber: function() {
						//if (!isNew) return formData.accountno;
						var str = formData.keyvalue.substr(1,10)+'00000000';
						var accountno = (intVal(formData.groupacc)+1)+'-'+str.substr(0,8);
						if (formFlag != 1) formData.accountno = accountno;
						// formData.keyvalue.substr(1,10)+str.substr(0,2*(3-intVal(formData.levelacc)));
						return accountno;
					}	
	        	};
	        };

	        function set_resetData() {
        		formData.rekid  = -1;
        		formData.groupacc = formDataParent.groupacc;
        		formData.classacc = formDataParent.classacc;
        		formData.levelacc = (formDataParent==0) ? 2 : intVal(formDataParent.levelacc)+1;
        		formData.parentkey = formDataParent.keyvalue; 
        		formData.keyvalue = formDataParent.keyvalue; 
        		formData.debitacc = formDataParent.debitacc;
        		formData.balancesheetacc = formDataParent.balancesheetacc;
        		formData.accountno = ''; 
				formData.description = 'New Account'; 
				formData.openingbalance = 0;
				formData.transbalance = 0;
				//console.log('reset ',formData.isNew);
	        }

	        function get_newAccountNo() {
	        	//console.log('start ',(formFlag == 0) ? formData.keyvalue : formData.parentkey);
	        	return $.ajax({
		            type: 'POST',
		            url: siteurl+'Accounting/perkiraan/newAccountNo',
		            dataType: 'json',
		            async: false,
		            data: {
		                keyvalue: (formFlag == 0) ? formData.keyvalue : formData.parentkey,
		            },
		        });
	        };

        	//==============Form Validation================//
	        form.validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: true, // do not focus the last invalid input
	            ignore: ":hidden",
	            ignore:[],
	            rules: {                
	                accountno: {required: true},
	                description: {required: true},
	                groupacc: {required: true},
	                classacc: {required: true}
	            },
	            messages:
	            {
	                accountno: {required: "Nomor Perkiraan Perlu diisi"},
	                description:{required: "Nama Perkiraan Perlu diisi"}
	            },
	            highlight: function(element) { // hightlight error inputs
	                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
	                $('.row_kasbank .save').attr('disabled','disabled');
	            },
	            success: function(label) {
	                label.closest('.form-group').removeClass('has-error');
	                label.remove();                     
	            }
	            //submitHandler: submitForm
	        });
	       //==============End of Form Validation================//

	        

	        function submitForm() {
                //var isNew = (formData.isNew == true) ? 1:0;
                if (formData.levelacc <= 4) {
                    $('input[name=description]',form).val(function(){
    	        		return this.value.toUpperCase();
    	        	})
                }
                var data = form.serialize()+"&keyvalue="+formData.keyvalue+"&rekid="+formData.rekid+"&parentkey="+formData.parentkey+"&levelacc="+formData.levelacc+"&balancesheetacc="+formData.balancesheetacc+"&flag="+formFlag;

               // console.log(data);

                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    url: siteurl+'Accounting/perkiraan/save_Perkiraan',
                    data: data,
                    error: function (xhr, error, thrown) {                                  
                             var htoastr = new myToastr(xhr['responseText'], "<h3>Error Save</h3> <hr>");
                             htoastr.toastrError();
                             return false;
                            },
                    success: function(result) { 
                            var htoastr = new myToastr(result, "<h3>SID | Save </h3> <hr>");
                            htoastr.toastrSuccess();
                            //console.log(result);
                            
                            formPortlet.closest('.modal').modal('hide');
                            return true;
                            //$('.reset', $('.row_kasbank')).click();
                        }
                });
                data = undefined;
                htoastr = undefined;
                
	        }

	        function handleForm() {
	        	//console.log('handleForm');
	        	//console.log('Data : ',formData, 'Parent :', formDataParent);
	        	//console.log($('[id="autonumber"]',form).prop('checked'));
	        	
	        	if (formFlag == 0 || formFlag == 2) { //New //Copy
	        		
	        		$('#current-balance',formPortlet).text("Current Balance : Rp. 0");
	        		

	        		// $('#parentacc',form).html("<span class='label label-success'>"+formData.accountno+"</span> <i class='fa fa-hand-o-right icon-state-warning'></i> <span class='bold'>"+formData.description+"</span>");	

	        		//Setiup Class Account (Header, Detail, Detail Kas-Bank)
	    			$('select[name=classacc]', form).selectpicker('val', (formData.levelacc <= 4) ? '0' : '1');
	        		$('#classacc option',form).each(function () {
	        			if (formData.levelacc <= 4 ) {//Level Header
		        			($(this).attr('data-value') == '0') ? $(this).removeAttr('disabled') : $(this).attr('disabled','disabled');
	        			} else ($(this).attr('data-value') == '0') ? $(this).attr('disabled','disabled') : $(this).removeAttr('disabled');
	        		})
	        		//end of Class Account
	        		
	        	} else { //Edit
	        		$('#current-balance',formPortlet).text("Current Balance : Rp. "+intVal(formData.balancedue()).format(2, 3, '.', ','));

	        		//Setiup Class Account (Header, Detail, Detail Kas-Bank)
	    			$('select[name=classacc]', form).selectpicker('val', (formData.levelacc < 4) ? '0' : formData.classacc);
	        		$('#classacc option',form).each(function () {
	        			if (formData.levelacc <= 4 ) {//Level Header
		        			($(this).attr('data-value') == '0') ? $(this).removeAttr('disabled') : $(this).attr('disabled','disabled');
	        			} else ($(this).attr('data-value') == '0') ? $(this).attr('disabled','disabled') : $(this).removeAttr('disabled');
	        		})
	        		//end of Class Account
	        	};

	        	//console.log(formData.levelacc);

	        	(formData.levelacc <= 4) ? $('input[name=description]',form).addClass('uppercase') : $('input[name=description]',form).removeClass('uppercase');

	        	$('#parentacc',form).html("<span class='label label-success'>"+formDataParent.accountno+"</span> <i class='fa fa-hand-o-right icon-state-warning'></i> <span class='bold'>"+formDataParent.description+"</span>");	

	        	$('select[name=groupacc]', form).selectpicker('val', formData.groupacc);

	        	$('.caption-helper',formPortlet).text(caption[formFlag]);

	        	$('#groupacc option',form).each(function () {
	    			(formData.groupacc == $(this).attr('value')) ? $(this).removeAttr('disabled') : $(this).attr('disabled','disabled');
	    		});

	        	$('#balancesheetacc',form).text(formData.balancesheetacc == '1' ? "Balance Sheet" : "Profit-(Lost)");

	        	//$('input[name=accountno]',form).val(formData.autonumber());
	        	$('input[name=accountno]',form).val($('[id="autonumber"]',form).prop('checked') == true ? formData.autonumber() : formData.accountno);
	        	$('input[name=description]',form).val(formData.description);
	        	$('[id="debit"]',form).prop('checked',(formData.debitacc == '1') ? true : false);
	        	$('[id="credit"]',form).prop('checked',(formData.debitacc == '0') ? true : false);
	        	//$('[id="autonumber"]',form).prop('checked',(formData.debitacc == '1') ? true : false);

	        	$('.selectpicker', form).selectpicker('refresh');
	        	// $('select[name=classacc]', form).selectpicker('refresh');
	        	// $('select[name=groupacc]', form).selectpicker('refresh');
	        	$('.icheck-inline input').iCheck('update');
	        };



	        //Auto Number on change
	        form.on('ifChanged','#autonumber', function(event){
	        	//console.log($('[id="autonumber"]',form).prop('checked'));
	        	var isChecked = event.currentTarget.checked;
	        	$('input[name=accountno]',form).val(isChecked == true ? formData.autonumber() : formData.accountno);
	        	isChecked ? $('input[name=accountno]',form).attr('readonly',true) : $('input[name=accountno]',form).removeAttr('readonly') 
	        	//if (isChecked == true) get_newAccountNo();
	        })

	        form.on('click','.cancel',function(){
	        	//console.log(form.serialize());
	        })

	        form.off('click','.test').on('click','.test',function(e){
	        	e.preventDefault();
	        	$('input[name=description]',form).val(function(){
	        		return this.value.toUpperCase();
	        	})
				var data = form.serialize()+"&keyvalue="+formData.keyvalue+"&rekid="+formData.rekid+"&parentkey="+formData.parentkey+"&levelacc="+formData.levelacc+"&balancesheetacc="+formData.balancesheetacc+"&flag="+formFlag;
				console.log(data);
			});

			form.off('submit').on('submit',function(e){
	        	e.preventDefault();
	        	if (form.valid()) {
	        		submitForm();
	       		}
	        	return false;
	        });
		},

		getData: function() {
			return formData;
		},

		getDataParent: function() {
			return formDataParent;
		}
	};
};
// })(jQuery);
// }(jQuery))