<p> {{$role->name}}
	@if($moons == 1) 
		<button class="btn btn-warning">Maybe In</button>
	@else 
		<button class="btn btn-default">Out</button>
	@endif

	@if($role->already_in)
		<button class="btn btn-success">In</button>
	@else
		<button class="btn btn-default">Out</button>
	@endif	

</p>