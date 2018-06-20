@extends('layouts.app')

@section('content')

    @foreach($discussions as $d)
    <div class="card">
        <div class="card-header">
            <img src="{{ $d->user->avatar }}" alt="" width="40px" height="40px">&nbsp;&nbsp;&nbsp;
            <span>{{ $d->user->name }}, <b>{{ $d->created_at->diffForHumans() }}</b></span>

            @if($d->hasBestAnswer())
            <span class="btn btn-sm btn-success float-right">Closed</span>
            @else
            <span class="btn btn-sm btn-danger float-right">Open</span>
            @endif

        
            <a href="{{ route('discussions.show',['slug' => $d->slug]) }}" class="btn btn-outline-secondary btn-sm float-right mr-2">View</a>
        </div>

        <div class="card-body">
            <h4 class="text-center">
                {{ $d->title }}
            </h4>
            <p class="text-center">
                {{ str_limit($d->content,50) }}
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
    @endforeach

    <div class="text-center">
        {{ $discussions->links()}}
    </div>

@endsection
