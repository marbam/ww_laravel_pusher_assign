@extends('templates.master')

@section('content')

    <div class="container">

        <div class="jumbotron text-center" id="page-heading">
            <h1 class="jumbotron-heading">Your role is ready!</h1>
			<button type="button" class="btn btn-primary btn-lg btn-block" id="reveal">Click here to show your role!</button>
        </div>

		<div class="jumbotron text-center" id="role-details" style="display:none">
			<h4>You are the <span style="font-weight: bold">{{$player->role->name}}</span></h4>
			@if ($player->role->show_faction_on_reveal)
				<h4>Your faction is {{$player->role->faction->name}}</h4>
			@endif

			<h4>You are @if(!$player->role->mystic) *NOT* a @endif Mystic</h4>
			<h4>You show as @if(!$player->role->corrupt) Non- @endif Corrupt</h4>

			<button class="btn btn-success my-2" id="go-home">Back to Home Page!</button>
		</div>
    </div>

<script>
	$('#reveal').on('click', function() {
		$('#page-heading').hide();
		$('#role-details').show();
	});

	$('#go-home').on('click', function() {
		if (confirm("Are you sure you want to leave? You won't be able to get back here!")) {
			window.location.href = "/reset-player";
		}
	})
</script>
@endsection