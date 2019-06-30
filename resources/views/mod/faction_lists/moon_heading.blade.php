<h1>{{$heading}}</h1>
@foreach($data as $faction)
	@include('mod.faction_lists.faction_heading', ['faction' => $faction])
@endforeach