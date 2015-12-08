"use strict";

document.observe("dom:loaded", function() {
	/* Make necessary elements Dragabble / Droppables (Hint: use $$ function to get all images).
	 * All Droppables should call 'labSelect' function on 'onDrop' event. (Hint: set revert option appropriately!)
	 * 필요한 모든 element들을 Dragabble 혹은 Droppables로 만드시오 (힌트 $$ 함수를 사용하여 모든 image들을 찾으시오).
	 * 모든 Droppables는 'onDrop' 이벤트 발생시 'labSelect' function을 부르도록 작성 하시오. (힌트: revert옵션을 적절히 지정하시오!)
	 */
	var imgs = $$("#labs >");

	for (var i = 0; i < imgs.length; ++i) {
		new Draggable(imgs[i], {revert: true});	
	}
	Droppables.add('selectpad', {onDrop: labSelect});
	Droppables.add('labs', {onDrop: labSelect});
});

function labSelect(drag, drop, event) {
	/* Complete this event-handler function 
	 * 이 event-handler function을 작성하시오.
	 */
	//console.log(drag);
	var p = drag.up();
	var pId = p.getAttribute('id');
	if (pId == 'labs' && drop.id == 'selectpad') {
		var selected = $$('#selectpad >');
		if (selected.length > 2) {
			return;
		}
		var liCount = $$('#selection >').length;
		$('selection').insert('<li id="li_' + liCount + '">' + drag.getAttribute('alt') + '</li>');
		setTimeout(function() {
			var liCount = $$('#selection >').length - 1;
			$('li_' + liCount).pulsate({
		  	  duration: 1
			});
		}, 500);
		
		$('selectpad').insert(drag);
	}
	else if (pId == 'selectpad' && drop.id == 'labs') {
		$('labs').insert(drag);
		var selection = $$('#selection >');
		for (var i = 0; i < selection.length; ++i) {
			if (selection[i].innerHTML == drag.getAttribute('alt')) {
				selection[i].remove();
				break;
			}
		}
		selection = $$('#selection >');
		for (var i = 0; i < selection.length; ++i) {
			selection[i].setAttribute('id', 'li_' + i);
		}
	}
}