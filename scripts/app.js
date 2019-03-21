'use strict';

(function($)
{
  function start()
  {
    console.log("I am in the app.js file");
    var $this = $(this);
    var $search = $('form#searchform');
    var $profile_field = $('div.profileBody',$this);
    var availableNames = [];
		$search.submit(function()
		{

			//gets the value of the search bar
			var value = $('input[name="searchInput"]').val();
			console.log(value);
      $.ajax({
				url: 'search.php?action=search',
				dataType: 'json',
        method: 'post',
        data:{searchInput:value},
				success: function(response)
					{
            if (response.status === 'success')
  						{
              if (response.users.length === 0)
							{
							$profile_field.text('No Users Found.');
							return;
							}
                $profile_field.html('');
                console.log(response);
                for (var index = 0 ; index < response.users.length ; ++index)
                							{
                							var userProf = response.users[index];
                							var $userProf = $('<div class="profile">');
                              var $picbod = $('<div class="profImg">')
                              var $Profbod = $('<div class="profbod">');
                							var $Uname = $('<div class="userName">');
                              var $Uid = $('<div class="userId">');
                              var $Upic = $('<img src=""/>');
                							$Uname.text(userProf.display_name);
                							$Uid.text(userProf.employee_Id);
                              $Upic.attr("src",userProf.thumbnail);
                              $Profbod.append($Uname).append($Uid);
                              $picbod.append($Upic);
                							$userProf.append($picbod).append($Profbod);
                							$profile_field.append($userProf);
                							}


              }else{
               console.log("response error");
               console.log(response);

              }
          },
          error: function(error)
          {
            console.log(error);
          }
        });
        return false; // prevent default page refresh
      });

//AUTOCOMPLETE
// var availableNames = [
//         response.users.display_name,
//         response.users.employee_Id
//         ];
//         $( "#searchbar" ).autocomplete({
//           source: availableNames
//         });



    }
  $(document).ready(start);
})(window.jQuery);
