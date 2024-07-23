var Login = function() {	
    var handleLogin = function() {
        $('.login-form').validate({
            errorElement: 'span', 
            errorClass: 'help-block', 
            focusInvalid: false, 		
            	
            rules: {
                username: {
                    required: true,
                    minlength: 5,
                    maxlength: 15,
                    //remote: siteurl+"userlogin/check_exist"
                    remote: {
                        url: "Auth/check_exist",
                        type: "post",
                        data: {
                            username: function() {
                                return $("[name='username']").val();
                            }
                        }
                    }
                    
                },
                password: {
                    required: true,
                    minlength: 5,
                    maxlength: 15
                },
                remember: {
                    required: false
                }
            },

            messages:
			{
				password:{
                      required: "silahkan masukkan password"
						},
				username: { 
                      required: "silahkan masukkan user name",
                      remote: "user tidak di temukan"
                      //remote: $.format("{0} tidak ditemukan")
                    }
			},
           
		   invalidHandler: function(event, validator) { //display error alert on form submit                   
				$('.alert-danger', $('.login-form')).show();

            },

            highlight: function(element) { // hightlight error inputs
              //  $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
                $('.alert-danger', $('.login-form')).show();
            },

            unhighlight: function(element) { // hightlight error inputs
              //  $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
                $('.alert-danger', $('.login-form')).hide();
            },

            success: function(label) {
                //label.closest('.form-group').removeClass('has-error');
                //label.remove();			
                $('.alert-danger', $('.login-form')).hide();			
            },

            errorPlacement: function(error, element) {
                //error.insertAfter(element.closest('.input-icon'));    
                $('.alert-danger', $('.login-form')).show();
                $('#msg').html(error);
                //error.appenTo('#msg');
            },
			
            submitHandler: submitform						
        });

        $('.login-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.login-form').validate().form()) {
                    $('.login-form').submit(); //form validation success, call ajax form submit
                }
                return false;
            }
        });
		
		function submitform() {
			var data = $(".login-form").serialize();			
			l = Ladda.create( document.querySelector( '.ladda-button' ) );						            
           // console.log(siteurl+"userlogin/check_exist");			
            //console.log( $(".login-form").serialize() );
			$.ajax({
				url : siteurl+"Auth/check_validate",
                type: "POST",
                dataType: "JSON",
				//type : 'GET',
				//url  : 'login_proses.php',
                //url : "<?php echo site_url('userlogin/check_exist/')?>/" + data['username'],
				data : data,			
				beforeSend : function(){
					$(".alert-danger").fadeOut();
					l.start();
					$(".ladda-label").html('sending..');
					//$("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
				},
                error: function (xhr, error, thrown) {                                  
                                console.log(xhr['responseText']);
                            },
				success :  function(response) {					
                    //console.log(response);
					if (response["status"]==true) {						
						//$("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Signing in ...');
						//$("#btn-login").html('<img src="../assets/global/img/input-spinner.gif" /> &nbsp; Signing In ...');
						//console.log(response['data']);
						$(".ladda-label").html('Signing In..');
                        //console.log(siteurl);                        
						setTimeout('l.stop(); l.remove(); window.location.href=siteurl; ',1000);																					
					} else {						
						$(".alert-danger").fadeIn(1000, function(){												
    						//$("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
    						$(".ladda-label").html('Login');
                            $('.alert-danger', $('.login-form')).show();
                            $("#msg").html(response['data']);                            
    						l.stop();    						
						});
									
						//$('.alert-danger').show();
						//$("#msg").html(response);
						
					} 
				} // end of success
				
			}) // end of ajax			
			
			return false;
		}
		
    };

    var handleForgetPassword = function() {
        $('.forget-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {                
                email: {required: true, email: true},                
            },

            messages: {
                email: {
                    required: "Email is required."
                }
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   

            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function(form) {
                form.submit();
            }
        });

        $('.forget-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.forget-form').validate().form()) {
                    $('.forget-form').submit();
                }
                return false;
            }
        });

        jQuery('#forget-password').click(function() {
            jQuery('.login-form').hide();
            jQuery('.forget-form').show();
        });

        jQuery('#back-btn').click(function() {
            jQuery('.login-form').show();
            jQuery('.forget-form').hide();
        });

    }

    var handleRegister = function() {

        function format(state) {
            if (!state.id) { return state.text; }
            var $state = $(
             '<span><img src="../assets/global/img/flags/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
            );
            
            return $state;
        }

        if (jQuery().select2 && $('#country_list').size() > 0) {
            $("#country_list").select2({
	            placeholder: '<i class="fa fa-map-marker"></i>&nbsp;Select a Country',
	            templateResult: format,
                templateSelection: format,
                width: 'auto', 
	            escapeMarkup: function(m) {
	                return m;
	            }
	        });


	        $('#country_list').change(function() {
	            $('.register-form').validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
	        });
    	}

        $('.register-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                namalengkap: {required: true},                
                email: {required: true, email: true},
                username: {required: true, minlength: 5, maxlength: 15 
                                // remote: {
                                //     url: siteurl+"Auth/register_check_exist",
                                //     type: "post",
                                //     data: {
                                //         username: function() {
                                //             return $("[name='username']").val();
                                //         }
                                //     }
                                // }
                            },                    
                password: {required: true, minlength: 5, maxlength: 15},
                rpassword: {equalTo: "#register_password"}                
            },

            messages: { // custom messages for radio buttons and checkboxes                
                username: {remote: "user sudah terdaftar dalam database"}
            },

            invalidHandler: function(event, validator) { //display error alert on form submit   
				$('.alert-danger', $('.register-form')).html("masih ada data yang perlu diisi");
				$('.alert-danger', $('.register-form')).show();
            },

            highlight: function(element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

           /* errorPlacement: function(error, element) {
                if (element.attr("name") == "tnc") { // insert checkbox errors after the container                  
                    error.insertAfter($('#register_tnc_error'));
                } else if (element.closest('.input-icon').size() === 1) {
                    error.insertAfter(element.closest('.input-icon'));
                } else {
                    error.insertAfter(element);
                }
            },*/

            submitHandler: submitregister
        });
				
		
		function submitregister() {
			var data = $(".register-form").serialize();			
			$.ajax({				
				url : siteurl+"Auth/register_validate",
                type: "POST",
                dataType: "JSON",
				data : data,			
				beforeSend : function(){
					//$(".alert-danger").fadeOut();
					$("#register-submit-btn").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
				},
				success :  function(response) {					
					if (response['status']==true) {													
						$("#register-submit-btn").html("<img src='assets/global/img/input-spinner.gif' /> &nbsp; processing ...");
						setTimeout(function(){
							$("#register-submit-btn").html('submit');
							$('.alert-danger', $('.register-form')).hide();
							jQuery('.login-form').show();
							jQuery('.register-form').hide();							
						},2000); //end of setTimeout
												
					} else {						
						$('.alert-danger', $('.register-form')).html(response['data']);						
						$('.alert-danger', $('.register-form')).fadeIn(2000, function(){
						$("#register-submit-btn").html('submit');
								});	//end of fadeIn
					}
				} // end of success
				
			}) // end of ajax
			
			return false;
		} //enf of submitregister function

        $('.register-form input').keypress(function(e) {
            if (e.which == 13) {
                if ($('.register-form').validate().form()) {
                    $('.register-form').submit();
                }
                return false;
            }
        });

        jQuery('#register-btn').click(function() {
            jQuery('.login-form').hide();
            jQuery('.register-form').show();
        });

        jQuery('#register-back-btn').click(function() {
            jQuery('.login-form').show();
            jQuery('.register-form').hide();
        });
    };		
			

    return {
        //main function to initiate the module
        init: function() {

            handleLogin();
            //handleForgetPassword();
            handleRegister();

        }

    };

}();

jQuery(document).ready(function() {
    Login.init();		
});

