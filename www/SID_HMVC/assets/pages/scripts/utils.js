function setCookie(key, value) {
	var expires = new Date();
	expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 1000));
	document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
}

function getCookie(key) {
	var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
	return keyValue ? keyValue[2] : null;
}

function clearValidation(formelement) {
	var validator1 = $(formelement).validate();
		 //Iterate through named elements inside of the form, and mark them as error free
	$('[name]',formelement).each(function(){
	   validator1.successList.push(this);//mark as error free
	   validator1.showErrors();//remove error messages if present
	});
	validator1.resetForm();//remove error class on name elements and clear history
	validator1.reset();//remove all error and success data
};

function addcombo(listelement) {
/*
	var mycombo = $('#masterkavlingform').find('[id="cbtyperumah"]');
	//mycombo.empty();
	if (mycombo.has('option').length > 0) return;
	mylib.data = listelement;
	for (var i = 0, len = listelement.length; i< len; ++i) {
		$(new Option(listelement[i]["typerumah"], i)).appendTo(mycombo);		
	};
	*/
};

function slidebarSelected (iditem) {	
	iditem = iditem || '#db-perencanaan';
	//$(idgroup).addClass(" active open ");
	//$(idgroup).has('a').append("<span class='selected'></span>");
	$(iditem).parents().eq(1).addClass(" start active open ");
	$(iditem).parents().eq(1).has('a').addClass(" active open ");	
	$(iditem).addClass(" active open ");
	$(iditem).has('a').append("<span class='selected'></span>");
	//console.log($(iditem).parents().eq(1));
};

