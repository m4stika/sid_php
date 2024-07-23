var Login = function() {
	
    var handleLogin = function() {
		/*var form1 = $('#edittyperumahform');
        var error1 = $('.alert-danger', form1);
        var success1 = $('.alert-success', form1);
		*/
		$('#edittyperumahform').validate({		
			
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
			
            rules: {
                noid: {
                    required: true
                },
                typerumah: {
                    required: true
                },
                keterangan: {
                    required: false
                }
            },

            messages:
			{
				noid:{
                      required: "please enter your password"
						},
				typerumah: "please enter your email address",
			},
           
		   invalidHandler: function(event, validator) { //display error alert on form submit                   
				$('.alert-danger', $('.login-form')).show();
				/*$('.alert-danger', $('.login-form')).show();
				success1.hide();
                error1.show();
                App.scrollTo(error1, -200);
				*/
            },

            highlight: function(element) { // hightlight error inputs
                $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
				
            },

            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();						
            },

            errorPlacement: function(error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },
			
            submitHandler: submitform
               // success1.show();
               // error1.hide();
            				
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
			
			$.ajax({
				
				type : 'POST',
				url  : 'login_proses.php',
				data : data,			
				beforeSend : function(){
					$(".alert-danger").fadeOut();
					l.start();
					$(".ladda-label").html('sending..');
					//$("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
				},
				success :  function(response) {					
					if (response=="ok") {						
						//$("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Signing in ...');
						//$("#btn-login").html('<img src="../assets/global/img/input-spinner.gif" /> &nbsp; Signing In ...');
						
						$(".ladda-label").html('Signing In..'); 
						setTimeout('l.stop(); l.remove(); window.location.href="layout_blank_page1.php"; ',1000);									
											
					} else {						
						$(".alert-danger").fadeIn(1000, function(){												
						//$("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
						$(".ladda-label").html('Login');
						l.stop();
						$("#msg").html(response);
									});
									
						//$('.alert-danger').show();
						//$("#msg").html(response);
						
					}
				} // end of success
				
			}) // end of ajax			
			
			return false;
		}
		
		/*
		$("button#submit").click( function() { 		  			
						
			$.post( $(".login-form").attr("action"),
					$(".login-form :input").serializeArray(),
					function(data) {
					  $("span#msg").html(data);					  
					  if(data=="0") {
						$('.alert-danger', $('.login-form')).show();  
					  } else {						  
						  /*
						  $(".login-form").submit(function(){
							//form.submit();
							return false;
						  });
						  */
		/*			  }
				});					
				$(".login-form").submit(function() {return false} );
		});
		*/
		
		
		
		
    };

    var handleForgetPassword = function() {
        $('.forget-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",
            rules: {
                email: {
                    required: true,
                    email: true
                }
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

                namalengkap: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                alamat: {
                    required: true
                },
                kota: {
                    required: true
                },
                country: {
                    required: true
                },

                username: {
                    required: true
                },
                password: {
                    required: true
                },
                rpassword: {
                    equalTo: "#register_password"
                },

                tnc: {
                    //required: true
                }
            },

            messages: { // custom messages for radio buttons and checkboxes
                tnc: {
                 // required: "Please accept TNC first."
                }
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
				
				type : 'POST',
				url  : 'register_proses.php',
				data : data,			
				beforeSend : function(){
					//$(".alert-danger").fadeOut();
					$("#register-submit-btn").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
				},
				success :  function(response) {					
					if (response=="ok") {													
						$("#register-submit-btn").html('<img src="../assets/global/img/input-spinner.gif" /> &nbsp; processing ...');
						setTimeout(function(){
							$("#register-submit-btn").html('submit');
							$('.alert-danger', $('.register-form')).hide();
							jQuery('.login-form').show();
							jQuery('.register-form').hide();							
						},2000); //end of setTimeout
												
					} else {						
						$('.alert-danger', $('.register-form')).html(response);
						
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
            //handleRegister();

        }

    };

}();

jQuery(document).ready(function() {
    Login.init();		
});

