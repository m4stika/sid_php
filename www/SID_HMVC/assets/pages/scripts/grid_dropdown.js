var gridDropdown = function() {
	// var no = 0;
	// var statusbooking = 0;
	// var endiv = true;
	return {
		addDropdown: function (no, statusbooking, enddiv) {
        	if (statusbooking === undefined) {statusbooking = 0;} 
        	if (no === undefined) {no = 0;} 
        	if (enddiv === undefined) {enddiv = true;} 

			var menustr = 
				"<div class='btn-group'> "+
					"<button class='btn btn-xs btn-success dropdown-toggle no-margin' type='button' data-toggle='dropdown' aria-expanded='false'>"+
						"<label class='label bg-green-jungle bg-font-green-jungle'>"+no+"</label> Actions"+
						"<i class='fa fa-caret-down'></i>"+
					"</button>"+
					"<ul class='dropdown-menu' role='menu'>"+
						"<li> <a href='javascript:;' class='edit'> <i class='fa fa-edit'></i> Edit</a> </li>"+
						"<li> <a href='javascript:;' class='copy'> <i class='fa fa-files-o'></i> Copy Form</a></li>";
			if (statusbooking == '0') {
				menustr += 		"<li class=''><a href='javascript:;' class='delete'> <i class='fa fa-trash-o'></i> Delete</a></li>";
			}
			if (enddiv === true) {
				menustr +=	"</ul></div>"; 
			}
			return menustr;
		}
	};
};