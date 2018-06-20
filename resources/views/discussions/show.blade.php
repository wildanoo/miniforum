@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <img src="{{ $d->user->avatar }}" alt="" width="40px" height="40px">&nbsp;&nbsp;&nbsp;
        <span>{{ $d->user->name }}, <b>( {{ $d->user->points }} )</b></span>

        @if($d->hasBestAnswer())
        <span class="btn btn-sm btn-success float-right">Closed</span>
        @else
        <span class="btn btn-sm btn-danger float-right">Open</span>
        @endif
        
        @if(Auth::id() == $d->user->id)
            @if(!$d->hasBestAnswer())
                <a href="{{ route('discussion.edit',['slug' => $d->slug]) }}" class="btn btn-info btn-sm float-right mr-2">Edit</a>
            @endif
        @endif

        @if($d->is_being_watched_by_auth_user())
            <a href="{{ route('discussion.unwatch',['id' => $d->id]) }}" class="btn btn-secondary btn-sm float-right mr-2">Unwatch</a>
        @else
            <a href="{{ route('discussion.watch',['id' => $d->id]) }}" class="btn btn-secondary btn-sm float-right mr-2">Watch</a>
        @endif
    </div>

    <div class="card-body">
        <h4 class="text-center">
            {{ $d->title }}
        </h4>
        <hr>
        <p class="text-center">
            {!! Markdown::convertToHtml($d->content) !!}
        </p>

        <hr>

        @if($best_answer)
        <div class="text-center">
            <h3 class="text-center mt-5">BEST ANSWER</h3>
            <div class="card card-success">
                <div class="card-header">
                    <img src="{{ $best_answer->user->avatar }}" alt="" width="40px" height="40px">&nbsp;&nbsp;&nbsp;
                    <span>{{ $best_answer->user->name }}, <b>( {{ $best_answer->user->points }} )</b></span>
                </div>

                <div class="card-body">
                    {!! Markdown::convertToHtml($best_answer->content) !!}
                </div>
            </div>
        </div>
        
        @endif

    </div>
    <div class="card-footer">
        <span>
            {{ count($d->replies) }} Replies
        </span>
        <a href="{{ route('channel',['slug' => $d->channel->slug]) }}" class="btn btn-outline-secondary btn-sm float-right ">{{ $d->channel->title }}</a>
    </div>
</div>
<div class="py-2"></div>

@foreach($d->replies as $r)
<div class="card">
    <div class="card-header">
        <img src="{{ $r->user->avatar }}" alt="" width="40px" height="40px">&nbsp;&nbsp;&nbsp;
        <span>{{ $r->user->name }}, <b>( {{ $r->user->points }} )</b></span>
        @if(!$best_answer)
            @if(Auth::id() == $d->user->id)
                <a href="{{ route('discussion.best.answer',['id' => $r->id]) }}" class="btn btn-primary btn-sm float-right">Mark as best answer</a>
            @endif
        @endif

        @if(Auth::id() == $r->user->id)
            @if(!$r->best_answer)
            <a href="{{ route('reply.edit',['id' => $r->id]) }}" class="btn btn-info btn-sm float-right mr-2">Edit</a>
            @endif
        @endif
    </div>

    <div class="card-body">
        <p class="text-center">
            {!!  Markdown::convertToHtml($r->content) !!}
        </p>
    </div>
    <div class="card-footer">
        @if($r->is_liked_by_auth_user())
            <a href="{{ route('reply.unlike', ['id' => $r->id]) }}" class="btn btn-danger btn-sm">Unlike <span class="badge badge-light">{{ $r->likes->count() }}</span></a>
        @else
    <a href="{{ route('reply.like',['id' => $r->id]) }}" class="btn btn-success btn-sm">Like <span class="badge badge-light">{{ $r->likes->count() }}</span></a>
        @endif
    </div>
</div>
<div class="py-2"></div>
@endforeach

<div class="card">
    <div class="card-body">
        @if(Auth::check())
        <form action="{{ route('discussion.reply',['id' => $d->id]) }}"  method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="reply">Leave a reply...</label>
                <textarea name="reply" id="reply" cols="30" rows="10" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <button class="btn float-right">Leave a reply</button>
            </div>
        </form>
        @else
            <div class="text-center">
                <h2>Sign in to leave a reply</h2>
            </div>
        @endif
    </div>
</div>
@endsection
