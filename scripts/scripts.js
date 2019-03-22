$(function() {

    $('#loginlink').click(function(e) {
		$(".loginform").delay(100).fadeIn(200);
 		$(".registrationform").fadeOut(100);
    $("#registerlink").delay(100).fadeIn(200);
    $("#loginlink").fadeOut(100);

		e.preventDefault();
	});
	$('#registerlink').click(function(e) {
		$(".registrationform").delay(100).fadeIn(200);
 		$(".loginform").fadeOut(100);
    $("#loginlink").delay(100).fadeIn(200);
    $("#registerlink").fadeOut(100);

		e.preventDefault();
	});


  $(".thumb").click(function(){
    $(this).toggleClass('like');
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

//So that the text field on the home page will autogrow as text is added
function auto_grow(element) {
    element.style.height = "5px";
    element.style.height = (element.scrollHeight)+"px";
}

//*** PASS EDIT VALUES TO MODAL ***
$(document).on("click", ".editModal", function () {
    var editId = $(this).data('id');
    var editBody = $(this).data('val');
    var editAuthor = $(this).data('author');

    $(".modal-body #editId").val( editId );
    $(".modal-body #editBody").val( editBody );
    $(".modal-body #authorId").val( editAuthor );
});

//*** PASS PROFILE EDIT VALUES TO MODAL ***
$(document).on("click", ".proEditModal", function () {
    var editId = $(this).data('id');
    var editAuthor = $(this).data('name');
    var img = $(this).data('img');
                    
    $("#editUserImg").attr("src", img);
    $(".modal-body #proId").val( editId );
    $(".modal-body #proName").val( editAuthor );
});

//** To open a Modal on after a "type= submit" form is sent.**
$('#searchform').on('submit', function(e){
  $('#searchProfile').modal('show');
  e.preventDefault();
});
