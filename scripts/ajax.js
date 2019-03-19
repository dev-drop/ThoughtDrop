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
                                
                                console.log("success");
                                console.log(response);
                                for(var i = 0; i<response.comments.length; i++){
                                 
                                commentHtml += `<div class="commentWrapper" data-comment-id="${response.comments[i].Id}"><div class='cardheader-comment'><div id='cardheader row'><h5 class='card-title'>${response.comments[i].author_Id}</h5><p id='timestamp'>${response.comments[i].timestamp}</p></div></div><div class='.card-body-comment'><p class='card-text'>${response.comments[i].body}</p><div><button class='icon likePost'><i class='fas fa-thumbs-up thumb likeCount'> ${response.comments[i].likes}</i></button></div></div></div>`           
                                }
                                $('.comments-body', $this).html(commentHtml);
                                
                                var $comments = $('div.commentWrapper', $this);
                                    
                                $comments.each(function(){
                                    
                                    $this = $(this);
                                    var commentId = parseInt($this.data('comment-id'));    
                                    var $like_button = $('.likeCount', $this);
                                    console.log($like_button);
                                    $like_button.on('click', function(){
                                        

                                        var commentLikes = $.ajax({
                                        url: 'ajaxDb.php?action=likeComment&commentId=' + commentId,
                                        dataType: 'json',
                                        success: function(response)
                                            {
                                                if(response.status === "Success")
                                                {
                                                    
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
                                

                                    
                                })
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




