<p> {{$role->name}}
	@if($moons == 1) 
		<button class="btn btn-warning always-in">Maybe In</button>
	@elseif($role->maybe_in)
		<button class="btn btn-warning not-in" data-show_players="{{$role->id}}">Maybe In</button>
	@else
		<button class="btn btn-default not-in" data-show_players="{{$role->id}}">Out</button>
	@endif

	@if($role->already_in)
		@if(in_array($role->name, ['Alpha Wolf', 'Clairvoyant']))
			<button class="btn btn-success role-always-in">In</button>
		@else
			<button class="btn btn-success role role-in" id="{{$role->id}}">In</button>
		@endif
	@else
		<button class="btn btn-default role" id="{{$role->id}}">Out</button>
	@endif	

</p>