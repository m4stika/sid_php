var Lock = function () {
	var handlelock = function() {
		$('.lock-form').validate({
			errorElement: 'span', 
            errorClass: 'help-block', 
            focusInvalid: false, 			
			rules: {
				password: {required: true, minlength: 5, maxlength: 15}
			},
			// row: {
			//     valid: 'has-success',
			//     invalid: 'has-error'
			// },
			success: function(label) {                
                $('.alert-danger', $('.lock-form')).hide();
            },
			submitHandler: function() {
				$('.alert-danger', $('.lock-form')).hide();
				data = $('.lock-form').serialize();
				$.ajax({
					url : siteurl+"Auth/check_validate",
	                type: "POST",
	                dataType: "JSON",					
					data : data,
					success :  function(response) {					
	                    //console.log(response);
						if (response["status"]==true) {																				
							$('.alert-danger', $('.lock-form')).hide();
							setTimeout('window.location.href=siteurl; ',1000);																					
						} else {						
							$(".alert-danger").fadeIn(500, function(){
	                            $('.alert-danger', $('.lock-form')).show();
	                            $("#msg").html(response['data']);                            	    						
							});
						} 
					} // end of success	
				})
			}
		})
	}
    
    return {
        //main function to initiate the module
        init: function () {
        	handlelock();
        }

    };

}();

jQuery(document).ready(function() {
    Lock.init();
});