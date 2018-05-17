@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <img src="{{ $d->user->avatar }}" alt="" width="40px" height="40px">&nbsp;&nbsp;&nbsp;
    <span>{{ $d->user->name }}, <b>{{ $d->created_at->diffForHumans() }}</b></span>
    <a href="{{ route('discussion',['slug' => $d->slug]) }}" class="btn btn-secondary float-right">View</a>
    </div>

    <div class="card-body">
        <h4 class="text-center">
            {{ $d->title }}
        </h4>
        <hr>
        <p class="text-center">
            {{ $d->content }}
        </p>
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
        <span>{{ $r->user->name }}, <b>{{ $r->created_at->diffForHumans() }}</b></span>
        <a href="{{ route('discussion',['slug' => $r->slug]) }}" class="btn btn-secondary float-right">View</a>
    </div>

    <div class="card-body">
        <p class="text-center">
            {{ $r->content }}
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
