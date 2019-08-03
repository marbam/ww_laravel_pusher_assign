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
<button type="submit">Allocate!</button>
</form>