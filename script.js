function addOffice() {
	window.open("offices.php", target="_self");
}

function edit() {
	var option = document.body.querySelectorAll('option');
	for (var i = 0; i < option.length; i++) {
	    if(option[i].selected) {
	    	var x = '?id=' + option[i].id;
	    	window.open("offices.php" + x, target="_self");
	    }
	}	
}

function deleteOffice() {
	var option = document.body.querySelectorAll('option');
	for (var i = 0; i < option.length; i++) {
	    if(option[i].selected) {
	    	var x = '?id=' + option[i].id;
	    	window.open("delete.php" + x, target="_self");
	    }
	}	
}

function viewOffice() {
	var option = document.body.querySelectorAll('option');
	for (var i = 0; i < option.length; i++) {
	    if(option[i].selected) {
	    	var x = '?id=' + option[i].id + '&view';
	    	window.open("offices.php" + x, target="_self");
	    }
	}	
}
