'use strict';

(function($)
{    
    function start($)
    {
        var $posts = $('div.posts div.post');
        
        $posts.each(function(){
        
            var $this = $(this);
            var postId =  parseInt($this.data('post-id'));
            
            var $postLikes = $('i.likeCount', $this);
            var $postComment = $('div.card-comment', $this);
            
            var $like_button = $('button.likePost', $this);
            var $comment_button = $('button.commentPost', $this);
        
            
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
                                //$postLikes.html(" " + response.likes);
                                console.log("success");
                                console.log(response);
                                for(var i = 0; i<response.comments.length; i++){
                                 
                                commentHtml += `<div class="commentWrapper"><div class='cardheader-comment'><div id='cardheader row'><h5 class='card-title'>${response.comments[i].author_Id}</h5><p id='timestamp'>${response.comments[i].timestamp}</p></div></div><div class='.card-body-comment'><p class='card-text'>${response.comments[i].body}</p><div><button class='icon likePost'><i class='fas fa-thumbs-up thumb likeCount'> ${response.comments[i].likes}</i></button></div>`           
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

var commentHtml = "<div class='card-body cardheader'><div id='cardheader row'><h5 class='card-title'>/*AUTHOR ID */</h5><p id='timestamp'>/*TIMESTAMP*/</p></div></div><div class='card-body'><p class='card-text'>/*COMMENT BODY*/</p><div><button class='icon likePost'><i class='fas fa-thumbs-up thumb likeCount'>/* COMMENT LIKES*/</i></button>";




/*
'<div class="card-body cardheader">
              <div id="cardheader row">
                <h5 class="card-title">response.comment[i].author_Id</h5>
                <p id="timestamp">/*TIMESTAMP</p>
              </div>
            </div>

              <div class="card-body">
                <p class="card-text">/*COMMENT BODY</p>
                <div>
                  <button class="icon likePost"><i class="fas fa-thumbs-up thumb likeCount">/* COMMENT LIKES</i></button>'
                  
              <?php
                
//-------------- VALIDATE USER FOR ADMIN PERMISSIONS -------------------
                $adminOptions = validate_permissions($_SESSION['currentUser'], $row['author_Id']);
                if($adminOptions || ($_SESSION['userRole'] == 127)){
                ?>
              <div class="adminOpt">
              
<!-------------- OPEN EDIT MODAL WINDOW -------------------------------->
                  <button type="button" class="editModal icon" data-toggle="modal" data-target="#myModal" data-id="<?php echo $row['Id'];?>" data-author="<?php echo $row['author_Id']; ?>" data-val="<?php echo $row['body']; ?>" ><i class="fas fa-edit"></i></button>
                 
                  <!-- DELETE POST FORM -->
                  <form action="" class="deleteForm" method="post">
                        <input type="hidden" name="postId" value="<?php echo $row['Id']; ?>" />
                        <button class="icon"  type="submit" name="delete"><i class="fas fa-trash"></i></button>
                  </form>
              </div>
              </div>
              </div>'
*/
 