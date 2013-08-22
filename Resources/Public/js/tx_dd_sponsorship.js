/**
 * Tablesorter is used to make table pagination
 * 
 * @author duda|design GbR
 * @version 1.0
 */

$(function() {
	$("table").tablesorter({
		debug : true
	});
});

$(document).ready(function() {
	$(".table").tablesorter({
		widthFixed : true,
		widgets : ['zebra']
	}).tablesorterPager({
		container : $("#pager")
	});
});
