<section class='row posts'>
        <div class='col-md-6 col-md-offset-3' id='posts-container' 
             @if (count($posts) > 1)
             data-next-page='{{ $posts->nextPageUrl() }}'
             @endif
             >
            <header><h3><!-- What other people say... --></h3></header>
            @include('includes.post-feed')
        </div>
</section>
<section class='row'>
    <div class='col-md-6 col-md-offset-3' id='feed-info'>
        
    </div>
</section>
    
    <div class="modal fade" tabindex="-1" role="dialog" id='edit-modal'>
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Edit Post</h4>
          </div>
          <div class="modal-body">
            <form action='#'>
                <div class='form-group'>
                    <label for='post-body'>Edit the Post</label>
                    <textarea class='form-control' name='post-body' id='post-body' rows='2'
                              onkeydown="if (event.keyCode == 13){ event.preventDefault(); submitEditPost(); }"></textarea>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="save-modal">Save changes</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    <script>
        var postId = 0;
        var postBodyElement = null;
        var voted_flag = false;
        $('.post').find('.interaction').find('.edit').on('click', function(event) {
            event.preventDefault();
            postBodyElement = event.target.parentNode.parentNode.getElementsByTagName('p')[1];
            var postBody = postBodyElement.textContent;
            postId = event.target.parentNode.parentNode.dataset['postid'];
            $('#post-body').val(postBody);
            $('#edit-modal').modal();
        });
        $('#save-modal').on('click', function() {
            submitEditPost();
        });
        function submitEditPost()
        {
            $.ajax({
                method: 'post',
                url: '{{ route('edit') }}',
                data: 
                { 
                    body: $('#post-body').val(),
                    postId: postId,
                    _token: '{{ Session::token() }}'
                }
            })
            .done(function(msg) {
                $(postBodyElement).text(msg['new_body']);
                $('#edit-modal').modal('hide');
            });
        }
        $(document).on('click', '.like', function(e){
            e.preventDefault();
            var id = $('#' + this.id);
            var type = id.hasClass('arrow-up') == true ? 'like' : 'dislike';
            postId = e.target.parentNode.parentNode.parentNode.dataset['postid'];
            console.log({
                    type: type,
                    postId: postId,
                    _token: '{{ Session::token() }}'
                });
            $.ajax({
                method: 'post',
                url: '{{ route('post.like') }}',
                data: {
                    type: type,
                    postId: postId,
                    _token: '{{ Session::token() }}'
                }
            })
                    .done(function() {
                        var likesID = $('#likes-' + postId);
                        var clicked = id.hasClass('clicked');
                        var arrowUp = id.hasClass('arrow-up');
                        var numLikes = parseInt( likesID.text() );
                        var alreadyUp = $('#arrow-up-' + postId).hasClass('clicked');
                        var alreadyDown = $('#arrow-down-' + postId).hasClass('clicked');
                        
                        
                        if (arrowUp && clicked)         //cancelling upvote
                            likesID.text( numLikes - 1 );
                        else if (arrowUp && !clicked && alreadyDown )   //upvoting post, but already downvoted
                            likesID.text( numLikes + 2 );
                        else if (arrowUp && !clicked)   //upvoting post
                            likesID.text( numLikes + 1 );
                        else if (!arrowUp && clicked)   //cancelling downvote
                            likesID.text( numLikes + 1 );
                        else if (!arrowUp && !clicked && alreadyUp)  //downvoting post, but already upvoted
                            likesID.text( numLikes - 2 );
                        else if (!arrowUp && !clicked && !alreadyUp)  //downvoting post
                            likesID.text( numLikes - 1 );
                        
                        if (id.hasClass('clicked'))
                            id.removeClass('clicked');
                        else
                            id.addClass('clicked');
                        
                        if (id.hasClass('arrow-up'))
                        {
                            $('#arrow-down-' + postId).removeClass('clicked');
                        }
                        else
                        {
                            $('#arrow-up-' + postId).removeClass('clicked');
                        }
            });
        });
        @if ($postsCount > 10)
        $(window).scroll(function () {
            var page = $('#posts-container').data('next-page');
            
            if (page !== null)
            {
                clearTimeout( $.data(this, "scrollCheck"));     //to not make too many requests, only check position every so often
                $.data(this, 'scrollCheck', setTimeout(function() {
                    var scrollPositionForPostsLoad = $(window).height() + $(window).scrollTop() + 100;
                    
                    if (scrollPositionForPostsLoad >= $(document).height())
                    {
                        $.get(page, function(data) {
                            $('#feed-info').html("<img src='{{ asset('img/spinner.gif') }}' alt='spinner' />");
                            
                            $('#posts-container').append(data.posts);
                            $('#posts-container').data('next-page', data.next_page);
                            console.log(data.next_page);
                        });
                    }
                }, 350));
            }
            else
                $('#feed-info').empty();
        })
        @endif
    </script>


