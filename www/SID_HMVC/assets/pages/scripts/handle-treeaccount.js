var handleTreeAccount = function() {

	var ajaxTreeAccount = function() {
        $("#tree_acc").jstree({
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
                    'url' : function (node) {
                      return siteurl+'Accounting/perkiraan/get_ChartOfAccount';
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
            "plugins" : [ "dnd", "search", "state", "types" ]
        });

        //SEARCH CHART OF ACCOUNT
        var to = false;
		  $('#searchitem').keyup(function () {
		    if(to) { clearTimeout(to); }
		    to = setTimeout(function () {
		      var v = $('#searchitem').val();
		      $('#tree_acc').jstree(true).search(v);
		    }, 250);
		  });

	    $('#portlet_account .portlet-title a.reload').click(function(e){
            e.preventDefault();  // prevent default event
            e.stopPropagation(); // stop event handling here(cancel the default reload handler)
            $('#tree_acc').jstree(true).refresh();
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
    		ajaxTreeAccount();
    	}
    }
}();

jQuery(document).ready(function() {	
    handleTreeAccount.init();
});

