// Initialize the prediction graph after the DOM has fully loaded
document.addEventListener('DOMContentLoaded', function () {

	// menu-toggler
	var menu_toggle = document.getElementById('menu-toggle');
	var menu_navigation = document.getElementById('main-navigation');
	if( menu_navigation && menu_toggle ){
		menu_toggle.onclick = function(e){
			e.preventDefault();
			menu_navigation.classList.toggle('show');
		};
	}

	// notices close
	document.addEventListener('click', function (e) {
		// solution https://stackoverflow.com/questions/4643249/cross-browser-event-object-normalization
		var target = e.target || e.srcElement || e.relatedTarget  || e.fromElement || e.toElement;
		if (target.nodeType === 3) target = target.parentNode;
		if( target.className == 'notices-close' && target.parentElement.classList.contains('notices-wrapper') ){
			target.parentElement.classList.add('hide');
		}
	});

});