$('#add_entry').hide();

$('.newentry').click(function() {
	$('#add_entry').toggle();
});

$('.modify').click(function() {
	$(this).next(".mod_entry_wrap").toggle();
	$(this).prev(".existing").toggle();
	return false;
});

//console.log("dash loaded");
