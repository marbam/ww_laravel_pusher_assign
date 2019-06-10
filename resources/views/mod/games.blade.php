@extends('templates.master')

@section('content')

@foreach($games as $game)
	<a href="/game/{{$game->id}}">{{$game->code}}</a> - {{$game->created_at->format('d/m/Y')}}<br>
@endforeach

<a href="/new_game">New Game</a>
@endsection