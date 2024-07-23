var handleTreeReport = function() {

	var ajaxTreeReport = function() {
        $("#tree_report").jstree({
            "core" : {
                "themes" : {
                    "responsive": false,
                    //"dots" : true, // no connecting dots between dots
                    "name": "default-dark",
                    //"icons": true
                }, 
                // so that create works
                "check_callback" : true,
                'data' : {
                    'type' : "POST",
                    'url' : function (node) {
                      return 'get_report';
                    },
                    'data' : function (node) {
                      return { 'parent' : node.id };
                    }
                }
            },
            "types" : {
                "default" : {
                    "icon" : "fa fa-folder icon-state-warning icon-lg"
                },
                "file" : {
                    "icon" : "fa fa-file icon-state-warning icon-lg"
                }
            },
             "search" : {
				 "case_insensitive" : false,
				 "show_only_matches" : true,
			},
            "state" : { "key" : "demo3" },
            "plugins" : ["search", "state", "types" ]
        });

        //SEARCH CHART OF ACCOUNT
        var to = false;
		  $('#searchitem').keyup(function () {
		    if(to) { clearTimeout(to); }
		    to = setTimeout(function () {
		      var v = $('#searchitem').val();
		      $('#tree_report').jstree(true).search(v);
		    }, 250);
		  });

	    $('#portlet_account .portlet-title a.reload').click(function(e){
            e.preventDefault();  // prevent default event
            e.stopPropagation(); // stop event handling here(cancel the default reload handler)
            $('#tree_report').jstree(true).refresh();
            // // do here some custom work:
            // App.alert({
            //     'type': 'danger', 
            //     'icon': 'warning',
            //     'message': 'Custom reload handler!',
            //     'container': $('#my_portlet .portlet-body') 
            // });
        })
    } // end of ajaxTreeAccount

    return {
    	init: function() {
    		ajaxTreeReport();
    	}
    }
}();

jQuery(document).ready(function() {	
    handleTreeReport.init();
});

