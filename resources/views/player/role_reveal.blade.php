<p>Your role is ready!</p>
<div id="reveal">
	<p>Click here to reveal it</p>
</div>


<div id="role-details">
	<p>Your role is {{$player->role->name}}</p>
	@if ($player->role->faction->show_faction_on_reveal) 
		<p>Your faction is {{$player->role->faction}}</p>
	@endif

	<p>You are @if(!$player->role->mystic) *NOT* a @endif Mystic</p>
	<p>You show as @if(!$player->role->corrupt) Non- @endif Corrupt</p>

	<button>Go back to Games Listing!</button>
</div>

<style>
	#reveal {
		height: 200px;
		width: 200px;
		background-color: blue;
		border-radius: 25px;
		text-align: center;
	}

	#reveal p {
		padding-top: 80px;
	}

</style>