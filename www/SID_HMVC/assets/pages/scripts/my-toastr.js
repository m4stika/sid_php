var myToastr = function(headermsg='', msg='') {
	toastr.options = {
				  "closeButton": false,
				  "debug": false,
				  "positionClass": "toast-top-full-width",
				  "onclick": null,
				  "showDuration": "1000",
				  "hideDuration": "1000",
				  "timeOut": "5000",
				  "extendedTimeOut": "1000",
				  "showEasing": "swing",
				  "hideEasing": "linear",
				  "showMethod": "fadeIn",
				  "hideMethod": "fadeOut"
				};
	return {
		
		init: function() {
			if(msg == '') {
				return;
			}
		},

		toastrWarning: function() {
			toastr.warning(headermsg, msg).css("width","50%");
		},

		toastrError: function() {
			toastr.error(headermsg, msg).css("width","50%");
		},

		toastrInfo: function() {
			toastr.info(headermsg, msg).css("width","50%");
		},

		toastrSuccess: function() {
			toastr.success(headermsg, msg).css("width","50%");
		}

	}
};
