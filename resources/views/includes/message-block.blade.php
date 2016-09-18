@if(count($errors) > 0)
<div class="row">
    <div class="col-md-4 col-md-offset-4 alert alert-danger">
        <a href='#' class='close' data-dismiss="alert">&times;</a>
        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
@if(Session::has('message'))
<div class="row">
    <div class="col-md-4 col-md-offset-4 alert alert-success">
        <a href='#' class='close' data-dismiss="alert">&times;</a>
        {{ Session::get('message') }}
    </div>
</div>
@endif