$('#add_entry').hide();
$('.commentform').addClass("display-none");

$('.newentry').click(function() {
	$('#add_entry').toggle();
});

$('.modify').click(function() {
	console.log('modify clicked');
	$(this).next(".mod_entry_wrap").toggle();
	$(this).prev(".existing").toggle();
	return false;
});


//console.log("dash loaded");
