var handleModalReposition = function() {
	var handlereposition = function() {
        function reposition() {
	        var modal = $(this),
	            dialog = modal.find('.modal-dialog, .modal-confirm');

	        modal.css('display', 'block');
	        
	        // Dividing by two centers the modal exactly, but dividing by three 
	        // or four works better for larger screens.
	        dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));        
	    };

	    // Reposition when a modal is shown
			$("body").on("shown.bs.modal", ".modal", reposition); 
		    //$('.modal').on('shown.bs.modal', reposition);
			
		    // Reposition when the window is resized
		    $(window).on('resize', function() {
		        $('.modal:visible').each(reposition);
		    }); 
    } 

    return {
    	init: function() {
    		handlereposition();
    	}
    }
}();

jQuery(document).ready(function() {			
    handleModalReposition.init();	
});    
    
