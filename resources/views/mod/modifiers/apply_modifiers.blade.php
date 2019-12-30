@extends('templates.master')

@section('content')

<div class="container">
	<div class="jumbotron text-center">
		<h1 class="jumbotron-heading">Modifiers</h1>
		<p class="lead text-muted">Apply the modifiers to roles!</p>
	</div>
    <div>
        <h3>Selected Modifiers</h3>
        @foreach($modifiers as $mod)
            <button type="button" class="btn btn-primary" data-id="{{$mod->id}}" onclick="addRole(this)">{{$mod->name}}</button>
        @endforeach
        <hr>
        <button class="btn btn-success" type="button" id="previous">Previous</button>
        <button class="btn btn-success" type="button" id="next">Next</button><br><br>

        <div id="role_here">
            @include('mod.modifiers.role', ['id' => $positions[0]])
        </div>
    </div>
</div>

<script>

    let positionIds = {{$positions}};

    function addRole(clickedButton) {
        let button = $(clickedButton);
        $('.roles_in').append(`<button type="button" class="btn btn-primary">`+button.text()+`</button>`);
        button.hide();
    }

    $('#previous').on('click', function() {
        let currentId = $("#currentPosition").attr('data-position_id');
        if (positionIds[0] != currentId) {
            let nextId = '';
            $.each(positionIds, function(key, value) {
                if (currentId == value) {
                    console.log('in');
                    nextId = positionIds[key-1];
                    overwriteRoleDiv(currentId, nextId);
                }
            })
        }
    })

    $('#next').on('click', function() {
        let currentId = $("#currentPosition").attr('data-position_id');
        if (currentId != positionIds[positionIds.length-1]) {
            let nextId = '';
            $.each(positionIds, function(key, value) {
                if (currentId == value) {
                    nextId = positionIds[key+1];
                    overwriteRoleDiv(currentId, nextId);
                }
            })
        }
    })

    function overwriteRoleDiv(prevId, nextId) {
        $.ajax({
            method: "POST",
            url: "/get_role_div/"+nextId,
            data: {
                "_token": "{{ csrf_token() }}",
                id: nextId
            },
            success: function(data) {
                $('#role_here').html(data);
            },
            error: function(data) {
                alert('Something went wrong :(');
            }
        });
    }
</script>
@endsection