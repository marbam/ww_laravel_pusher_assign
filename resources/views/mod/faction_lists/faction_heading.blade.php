<h2>{{$faction->name}}</h2>
@foreach($faction->roles as $role)
	@include('mod.faction_lists.role', ['role' => $role, 'moons' => $faction->moons])
@endforeach