'use strict';

(function($)
{
    function start($)
    {
        var $posts = $('div.posts div.post');

        $posts.each(function(){

            var $this = $(this);
            var postId =  parseInt($this.data('post-id'));
            var userId = $this.data('author');

            var $postLikes = $('i.likeCount', $this);
            var $postComment = $('div.card-comment', $this);

            var $like_button = $('button.likePost', $this);
            var $comment_button = $('button.commentPost', $this);

            var $userName = $('.seeUser', $this);
            var $profile_field = $('div.profileBody',$this);
            
            $userName.on('click', function()
                {

                    var getUser = $.ajax({
                        url: 'ajaxDb.php?action=seeUser&empId=' + userId,
                        dataType: 'json',
                        success: function(response)
                        {
                            if(response.status === "Success")
                            {
                                $('#selUserName').html(response.userInfo.display_name);
                                $('#selUserId').html(response.userInfo.employee_Id);
                                $('#selUserLikes').html("Likes: " + response.likeCount);
                                $('#selUserComments').html("Comments: " +response.commentCount);
                                console.log(response.commentCount);
                                console.log(response.likeCount);

                                console.log(response.userInfo.thumbnail);
                                if(!response.userInfo.thumbnail == ""){
                                    $('#selUserImg').attr("src", response.userInfo.thumbnail);
                                }else{
                                    $('#selUserImg').attr("src", "images/defaultAvatar.png");
                                }
                                console.log("success");
                                console.log(response);
                                
                                var $adminCrl = '';
                                //console.log(mySession);
                                if(mySession == 127){
                                  $adminCrl = $('<form action="" class="deleteUser" method="post">');
                                  $adminCrl.append('<input type="hidden" name="employeeId" id="hiddenValue" value="' + response.userInfo.employee_Id + '">');
                                  $adminCrl.append('Delete User:<button class="icon"  type="submit" name="deleteUser" ><i class="fas fa-user-slash"></i></button>');
                                }
                                $('#adminPermis').html($adminCrl);
                                if ($adminCrl)
                                  {
                                  var $admin_form = $('.deleteUser','#adminPermis');
                                  $admin_form.on('submit',function()
                                    {
                                    return confirm("Are you sure you want to delete this user from the database?");
                                    });
                                  }
                                
                            }else
                                {
                                Console.log("something went wrong");
                                console.log(response);
                                }
                        },
                        error: function(response){
                            console.error('Something went wrong');
                            console.log(response);
                        }
                    })
                })

            $like_button.on('click', function()
                {
                    //console.log('Post: ' + postId + ' Liked');
                    var sendLikes = $.ajax({
                    url: 'ajaxDb.php?action=likePost&postId=' + postId,
                    dataType: 'json',
                    success: function(response)
                        {
                            if(response.status === "Success")
                            {
                                $postLikes.html(" " + response.likes);
                                console.log("success");
                                console.log(response);
                            }else
                                {
                                Console.log("something went wrong");
                                console.log(response);
                                }
                        },
                        error: function(response){
                            console.error('Something went wrong');
                            console.log(response);
                        }
                    })

                })


            $comment_button.on('click', function()
                {
                    var commentHtml = "";

                    $postComment.toggleClass('showComment');
                    var getComments = $.ajax({
                    url: 'ajaxDb.php?action=getComments&postId=' + postId,
                    dataType: 'json',
                    success: function(response)
                        {
                            if(response.status === "Success")
                            {
                                
                                console.log("success");
                                console.log(response);
                                for(var i = 0; i<response.comments.length; i++){

                                commentHtml += `<div class="commentWrapper"><div class='cardheader-comment'><div id='cardheader row'><h5 class='card-title'>${response.comments[i].author_Id}</h5><p id='timestamp'>${response.comments[i].timestamp}</p></div></div><div class='.card-body-comment'><p class='card-text'>${response.comments[i].body}</p>`           
                                }
                                $('.comments-body', $this).html(commentHtml);

                            }else
                                {
                                Console.log("something went wrong");
                                console.log(response);
                                }
                        },
                        error: function(response){
                            console.error('Something went wrong');
                            console.log(response);
                        }
                    })
                    console.log('Comment On Post: ' + postId);
                })
            })
    }

    $(document).ready(start);

})(window.jQuery);
