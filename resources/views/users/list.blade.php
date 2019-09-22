@extends('templates.master')

@section('content')
@if ($thisUser->can_approve)
	<form action="/update_users" method="POST">
	@csrf
@endif
<table class="table">
	<thead>
		<tr>
			<th>Name</th>
			<th>Can Approve</th>
			<th>Is Approved</th>
			@if($thisUser->id == 1)
				<th>Delete</th>
			@endif
		</tr>
	</thead>
	<tbody>
		@foreach($users as $user)
			<tr>
				<td>{{$user->name}}</td>
				@if($thisUser->can_approve)
					<td>
					    <select class="form-control" name="can_approve-{{$user->id}}">
					      <option value="0"
					      @if(!$user->can_approve)
					      	selected 
					      @endif
					      >No</option>
					      <option value="1"
					      @if($user->can_approve) 
					      	selected 
					      @endif
					      >Yes</option>
					    </select>
					</td>

					<td>
					    <select class="form-control" name="approved-{{$user->id}}">
					      <option value="0"
					      @if(!$user->approved) 
					      	selected 
					      @endif
					      >No</option>
					      <option value="1"
					      @if($user->approved) 
					      	selected 
					      @endif
					      >Yes</option>
					    </select>
					</td>
					@if($thisUser->id == 1 && $user->id != 1)
					<td>
					  <button type="button" class="btn btn-danger delete" 
					  	onclick='confirm("Are you sure you want to delete this user?")
					  		window.location.href = "/user_delete/{{$user->id}}";
					  	'
					  >Delete User</button>
					</td>
					@endif
				@else
					<td>{{$user->can_approve ? 'Yes' : 'No'}}</td>
					<td>{{$user->approved ? 'Yes' : 'No'}}</td>
				@endif
			</tr>
		@endforeach
	</tbody>
</table>

@if ($thisUser->can_approve)
	<button type="submit" class="btn btn-success btn-block">Update!</button>
	</form>
@endif
	<a href="/" class="btn btn-primary btn-block"><< Home</a> 
@endsection