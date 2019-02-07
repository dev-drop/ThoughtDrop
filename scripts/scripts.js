$(function() {

    $('#loginlink').click(function(e) {
		$(".loginform").delay(100).fadeIn(200);
 		$(".registrationform").fadeOut(100);
    $("#registerlink").delay(100).fadeIn(200);
    $("#loginlink").fadeOut(100);

	//	$('#registerlink').removeClass('active');
	//	$(this).addClass('active');
		e.preventDefault();
	});
	$('#registerlink').click(function(e) {
		$(".registrationform").delay(100).fadeIn(200);
 		$(".loginform").fadeOut(100);
    $("#loginlink").delay(100).fadeIn(200);
    $("#registerlink").fadeOut(100);

		//$('#loginlink').removeClass('active');
		//$(this).addClass('active');
		e.preventDefault();
	});

});
