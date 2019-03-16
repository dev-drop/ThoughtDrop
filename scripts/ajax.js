'use strict';

(function($)
{    
    function start($)
    {
        var $posts = $('div.posts div.post');
        
        $posts.each(function(){
        
            var $this = $(this);
            var postId =  parseInt($this.data('post-id'));
            //var $postLikes = $this.data('post-likes');
            //var postComments;
            var $postLikes = $('i.likeCount', $this);
            var $like_button = $('button.likePost', $this);
            var $comment_buton = $('button.commentPost', $this);
        
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
    





            $comment_buton.on('click', function()
                {
                    console.log('Comment On Post: ' + postId);
                })
            })
    }
    
    $(document).ready(start);
    
})(window.jQuery);
 