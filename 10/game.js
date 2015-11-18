"use strict";

var interval = 3000;
var numberOfBlocks = 9;
var numberOfTarget = 3;
var targetBlocks = [];
var selectedBlocks = [];
var timer;

document.observe('dom:loaded', function(){
	$('stop').observe('click', stopGame);
	$('start').observe('click', stopToStart);
});

function stopToStart(){
    stopGame();
    startToSetTarget();
}

function stopGame(){
	$('state').innerHTML = "Stop";
	$('answer').innerHTML = "0/0";
	targetBlocks = [];
	selectedBlocks = [];
	clearInterval(timer);
}

function startToSetTarget(){
	$('state').innerHTML = "Ready!";
	targetBlocks = [];
	selectedBlocks = [];
	clearInterval(timer);

	var arr = [];

	var check = [0, 0, 0, 0, 0, 0, 0, 0, 0];
	while (true) {
		if (targetBlocks.length == numberOfTarget) {
			break;
		}
		var i = Math.floor(Math.random() * 9);
		if (check[i] == 0) {
			check[i] = 1;
			targetBlocks.push(i);
		}
	}
	timer = setTimeout(setTargetToShow, interval);
}

function setTargetToShow(){
	$('state').innerHTML = "Memorize!";
	var blocks = $$('.block');
	for (var i = 0; i < numberOfTarget; ++i) {
		blocks[targetBlocks[i]].addClassName('target');
	}

	timer = setTimeout(showToSelect, interval);
}

function showToSelect(){
	$('state').innerHTML = "Select!";
	var blocks = $$('.block');
	for (var i = 0; i < numberOfTarget; ++i) {
		blocks[targetBlocks[i]].removeClassName('target');
	}

	for (var i = 0; i < numberOfBlocks; ++i) {
		blocks[i].observe('click', function(event) {
			if (selectedBlocks.length < numberOfTarget && !this.hasClassName('selected')) {
				this.addClassName('selected');
				selectedBlocks.push(parseInt(this.getAttribute('data-index')));
				// selectedBlocks.push(this);
			}
		});
	}

	timer = setTimeout(selectToResult, interval);
}

function selectToResult(){
	$('state').innerHTML = 'Checking';
	var blocks = $$('.block');
	for (var i = 0; i < numberOfBlocks; ++i) {
		blocks[i].removeClassName('selected');
	}

	for (var i = 0; i < numberOfBlocks; ++i) {
		blocks[i].stopObserving('click');
	}

	var numberOfCorrect = 0;

	console.log('targetBlocks: ');
	console.log(targetBlocks);
	console.log('selectedBlocks: ');
	console.log(selectedBlocks);

	for (var i = 0; i < numberOfTarget; ++i) {
		if (selectedBlocks.indexOf(targetBlocks[i]) != -1) {
			numberOfCorrect += 1;
		}
	}

	var beforeAnswer = $('answer').innerHTML.split('/');
	$('answer').innerHTML = '' + (numberOfCorrect + parseInt(beforeAnswer[0])) + '/' + (numberOfTarget + parseInt(beforeAnswer[1]));
	timer = setTimeout(startToSetTarget, interval);
}