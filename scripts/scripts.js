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

  $('.searchbtn').click(function(e) {
    $("#searchbar").delay(100).fadeIn(200);

  });





//this is the function for the number counter on the textarea
    $('textarea').keyup(function() {

      var characterCount = $(this).val().length,
          current = $('#current'),
          maximum = $('#maximum'),
          theCount = $('#the-count');

      current.text(characterCount);


      /*This isn't entirely necessary, just playin around*/
      if (characterCount < 70) {
        current.css('color', '#666');
      }
      if (characterCount > 70 && characterCount < 90) {
        current.css('color', '#6d5555');
      }
      if (characterCount > 90 && characterCount < 100) {
        current.css('color', '#793535');
      }
      if (characterCount > 100 && characterCount < 120) {
        current.css('color', '#841c1c');
      }
      if (characterCount > 120 && characterCount < 139) {
        current.css('color', '#8f0001');
      }

      if (characterCount >= 140) {
        maximum.css('color', '#8f0001');
        current.css('color', '#8f0001');
        theCount.css('font-weight','bold');
      } else {
        maximum.css('color','#666');
        theCount.css('font-weight','normal');
      }


    });

});


function auto_grow(element) {
    element.style.height = "5px";
    element.style.height = (element.scrollHeight)+"px";
}
