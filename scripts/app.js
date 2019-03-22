'use strict';

(function($)
{
  function start()
  {
    var $this = $(this);
    var $search = $('form#searchform');
    var $profile_field = $('div.profileBody',$this);
    var availableNames = [];
    console.log(mySession);
		$search.submit(function()
		{

			//gets the value of the search bar
			var value = $('input[name="searchInput"]').val();
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
							$profile_field.text('No Users Found or your search was not long enough');
							return;
							}
                $profile_field.html('');
                for (var index = 0 ; index < response.users.length ; ++index)
                							{
                							var userProf = response.users[index];
                              if(!userProf.thumbnail){
                                  userProf.thumbnail = "images/defaultAvatar.png";
                              }
                							var $userProf = $('<div class="profile">');
                              var $picbod = $('<div class="profImg">')
                              var $Profbod = $('<div class="profbod">');
                							var $Uname = $('<div class="userName">');
                              var $Uid = $('<div class="userId">');
                              var $Upic = $('<img src=""/>');
                              var $adminCrl = '';
                              if(mySession == 127){
                                $adminCrl = $('<form action="" class="deleteUser" method="post">');
                                $adminCrl.append('<input type="hidden" name="employeeId" id="hiddenValue" value="' + userProf.employee_Id + '">');
                                $adminCrl.append('<button class="icon"  type="submit" name="deleteUser"><i class="fas fa-user-slash"></i></button>');
                              }
                							$Uname.text(userProf.display_name);
                							$Uid.text(userProf.employee_Id);
                              $Upic.attr("src",userProf.thumbnail);
                              $Profbod.append($Uname).append($Uid).append($adminCrl);
                              if ($adminCrl)
                                {
                                var $admin_form = $('.deleteUser',$Profbod);
                                $admin_form.on('submit',function()
                                  {
                                  return confirm("Are you sure you want to delete this user from the database?");
                                  });
                                }
                              $picbod.append($Upic);
                							$userProf.append($picbod).append($Profbod);
                							$profile_field.append($userProf);
                							}


              }else{
              $profile_field.text('Something went wrong, Please try your search again later.');
               console.log("response error");

              }
          },
          error: function(error)
          {
            $profile_field.text('Something went wrong, Please try your search again later.');
            console.log(error);
          }
        });
        return false; // prevent default page refresh
      });


    }
  $(document).ready(start);
})(window.jQuery);
