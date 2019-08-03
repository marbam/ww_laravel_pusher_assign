@extends('templates.master')

@section('content')

<div class="container">
	<div class="jumbotron text-center">
		<h1 class="jumbotron-heading">Player Listing</h1>
		<p class="lead text-muted">Here's a chance to review your player listing. Take this opportunity to tweak the order to match the physical roles sheet that's been passed around. After this there's no going back!</p>
	</div>


	<form action="/final_allocation/{{$data['game']->id}}" method="POST">
		@csrf
		<table>
			<thead>
				<tr>
					<th>Name</th>
					<th>Order on Sheet</th>
					<th>Sneaky Role Allocation</th>
				</tr>
			</thead>
			<tbody>
			@foreach($data['players'] as $player)
				<tr>
					<td>{{$player->name}}</td>
					<td>
						<input type="number" name="listing_order__{{$player->id}}" value="{{$player->listing_order}}">
					</td>
					<td>Not Implemented Yet!</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	<button type="submit" class="btn btn-success my-2">Allocate!</button>
	</form>
</div>
@endsection