@extends('templates.master')

@section('content')
	<div class="container">
		<table class="table">
			<thead>
				<tr>
					<th>Player Name</th>
					<th>Role</th>
					@if($data['game']->has_modifiers)
						<th>Modifiers</th>
					@endif
					<th>Corrupt</th>
					<th>Mystic</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data['players'] as $player)
					<tr>
						<td>{{$player->name}}</td>
						@php
							$allocatedRole = $data['roles']->find($player->allocated_role_id);
						@endphp
						<td>{{$allocatedRole->name}}</td>
						@if($data['game']->has_modifiers)
							<td>
								@foreach($data['modifiers']->where('player_id', $player->id) as $modifier)
									{{$modifier->name}}<br>
								@endforeach
							</td>
						@endif
						@if($allocatedRole->corrupt || $player->overridden_corrupt)
							<td>&#10004;</td>
						@else
							<td></td>
						@endif
						@if($allocatedRole->mystic)
							<td>&#10004;</td>
						@else
							<td></td>
						@endif
					</tr>
				@endforeach
			</tbody>
		</table>

		<p>Remember to deal with Monster Farmer if they're in - This system won't handle that!</p>
	</div>
@endsection