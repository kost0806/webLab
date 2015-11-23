document.observe("dom:loaded", function() {
    $("b_xml").observe("click", function(){
    	//construct a Prototype Ajax.request object
    	new Ajax.Request('songs_xml.php', {
    		method: 'get',
    		parameters: {top: $F('top')},
    		onSuccess: showSongs_XML,
    		onFailure: ajaxFailed,
    		onException: ajaxFailed
    	});
    });
    $("b_json").observe("click", function(){
        new Ajax.Request('songs_json.php', {
        	method: 'get',
        	parameters: {top: $F('top')},
        	onSuccess: showSongs_JSON,
        	onFailure: ajaxFailed,
    		onException: ajaxFailed
        });
    });
});

function showSongs_XML(ajax) {
	// alert(ajax.responseText);
	// console.log(ajax.responseText);
	$('songs').update('');

	var xml_count = ajax.responseXML.getElementsByTagName('song').length;
	for (var i = 0; i < xml_count; ++i) {
		var song = ajax.responseXML.getElementsByTagName('song')[i];
		var title = song.getElementsByTagName('title')[0].textContent;
		var artist = song.getElementsByTagName('artist')[0].textContent;
		var genre = song.getElementsByTagName('genre')[0].textContent;
		var time = song.getElementsByTagName('time')[0].textContent;
		var liContent = title + ' - ' + artist + ' [' + genre + ']' + ' (' + time + ')';
		$('songs').insert('<li>' + liContent + '</li>');
	}
}

function showSongs_JSON(ajax) {
	// alert(ajax.responseText);
	// console.log(ajax.responseText);
	$('songs').update('');
	var jsonObj = JSON.parse(ajax.responseText);
	var songs = jsonObj['songs'];
	for (var i = 0; i < songs.length; ++i) {
		var title = songs[i]['title'];
		var artist = songs[i]['artist'];
		var genre = songs[i]['genre'];
		var time = songs[i]['time'];
		var liContent = title + ' - ' + artist + ' [' + genre + ']' + ' (' + time + ')';
		$('songs').insert('<li>' + liContent + '</li>');
	}
}

function ajaxFailed(ajax, exception) {
	var errorMessage = "Error making Ajax request:\n\n";
	if (exception) {
		errorMessage += "Exception: " + exception.message;
	} else {
		errorMessage += "Server status:\n" + ajax.status + " " + ajax.statusText + 
		                "\n\nServer response text:\n" + ajax.responseText;
	}
	alert(errorMessage);
}
