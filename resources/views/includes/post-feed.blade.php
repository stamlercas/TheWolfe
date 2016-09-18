<section class='row posts'>
        <div class='col-md-6 col-md-offset-3' id='posts-container'>
            <header><h3><!-- What other people say... --></h3></header>
            @foreach($posts as $post)
            @include('includes.post')
            @endforeach
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
        $('.like').on('click', function(e){
            e.preventDefault();
            var id = $('#' + this.id);
            var type = id.hasClass('arrow-up') == true ? 'like' : 'dislike';
            postId = e.target.parentNode.parentNode.parentNode.dataset['postid'];
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
    </script>

