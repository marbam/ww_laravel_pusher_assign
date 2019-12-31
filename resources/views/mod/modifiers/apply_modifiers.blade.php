@extends('templates.master')

@section('content')

<div class="container">
	<div class="jumbotron text-center">
		<h1 class="jumbotron-heading">Modifiers</h1>
		<p class="lead text-muted">Apply the modifiers to roles!</p>
	</div>
    <div>
        <h3>Selected Modifiers</h3>
        <div id="available">
            @foreach($modifiers as $mod)
                <button type="button" class="btn btn-primary"
                    data-id="{{$mod->id}}" onclick="allocate(this)"
                @if($mod->position_id)
                    style="display:none"
                @endif
                >{{$mod->name}}</button>
            @endforeach
        </div>
        <hr>
        <button class="btn btn-success" type="button" id="previous">Previous</button>
        <button class="btn btn-success" type="button" id="next">Next</button><br><br>

        <div id="role_here">
            @include('mod.modifiers.role', ['position_id' => $positions[0]])
        </div>
        <hr>
        <button class="btn btn-primary btn-block" id="submit">Click here when you're finished!</button>
    </div>
</div>

<script>

    let positionIds = {{$positions}};

    function allocate(clickedButton) {
        let button = $(clickedButton);
        let modifier_id = button.attr('data-id');
        $.ajax({
            method: "POST",
            url: "/allocate_modifier/{{$id}}",
            data: {
                "_token": "{{ csrf_token() }}",
                modifier_id: modifier_id,
                positionId: $("#currentPosition").attr('data-position_id')
            },
            success: function(data) {
                $('.roles_in').append(`<button type="button" class="btn btn-primary" onclick="deallocate(this)" data-modifier_id="`+modifier_id+`">`+button.text()+`</button>`);
                button.hide();
            },
            error: function(data) {
                alert('Something went wrong :(');
            }
        })
    }

    function deallocate(clickedButton) {
        let button = $(clickedButton);
        let modifier_id = button.attr('data-modifier_id');
        $.ajax({
            method: "POST",
            url: "/deallocate_modifier/{{$id}}",
            data: {
                "_token": "{{ csrf_token() }}",
                modifier_id: modifier_id,
                positionId: $("#currentPosition").attr('data-position_id')
            },
            success: function(data) {
                $('#available .btn[data-id="'+modifier_id+'"]').css('display', 'inline-block');
                button.remove();
            },
            error: function(data) {
                alert('Something went wrong :(');
            }
        })
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

    function save_notes()
    {
        $.ajax({
            method: "POST",
            url: "/save_mod_notes/",
            data: {
                "_token": "{{ csrf_token() }}",
                notes: $('.notes_from_mod').val(),
                positionId: $("#currentPosition").attr('data-position_id')
            },
            error: function(data) {
                alert("Couldn't save :(");
            }
        });
    }

    $('#submit').on('click', function() {
        if (confirm("Are you sure you've allocated everything?")) {
            window.location.href = '/allocate/{{$id}}';
        }
    })

</script>
@endsection