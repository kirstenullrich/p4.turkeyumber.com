$('#add_entry').hide();
$('.commentform').addClass("display-none");

$('.newentry').click(function() {
	$('#add_entry').toggle();
});

$('.modify').click(function() {
	$(this).next(".mod_entry_wrap").toggle();
	$(this).prev(".existing").toggle();
	return false;
});

$('.addcomment').click(function() {
	$('.commentform').toggle();
});
//console.log("dash loaded");
