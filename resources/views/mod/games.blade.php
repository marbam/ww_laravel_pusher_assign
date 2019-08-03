@extends('templates.master')

@section('content')
<div class="container">
	<div class="jumbotron text-center">
		<h1 class="jumbotron-heading">Games Listing</h1>
		<p class="lead text-muted">Below is a list of all your games created within the last 24 hours. All games older than 24 hours will be deleted when you make a new game.</p>
		<a href="/new_game" class="btn btn-success my-2">Set up new game</a>
	</div>

	@if($games->isNotEmpty())
		<table class="table">
			<thead>
				<tr>
					<th>Game Code</th>
					<th>Created</th>
				</tr>
			</thead>
			<body>
				@foreach($games as $game)
					<tr>
						<td><a href="/game/{{$game->id}}">{{$game->code}}</a></td>
						<td>{{$game->created_at->format('d/m/Y')}}</td>
					</tr>
				@endforeach
			</body>
		</table>
	@else
		<p>No games yet!</p>
	@endif
</div>
@endsection