@extends('templates.master')

@section('content')

<div class="container">
	<div class="jumbotron text-center">
		<h1 class="jumbotron-heading">Modifiers</h1>
		<p class="lead text-muted">Choose which modifiers you'd like in the game!</p>
	</div>

    @php
        $allModifiers = \App\Modifier::orderBy('is_experimental')->orderBy('name')->get();
        $inGame =  DB::table('game_modifiers')
                     ->join('modifiers', 'game_modifiers.modifier_id', '=', 'modifiers.id')
                     ->orderBy('game_modifiers.id')
                     ->get([
                        'game_modifiers.id',
                        'modifier_id',
                        'name'
                     ]);
    @endphp
    <div>
        <h3>Available Modifiers (click to add)</h3>
        <div class="availableModifiers">
            @foreach($allModifiers as $mod)
                @php
                    $visible = false;
                    if ($mod->can_have_multiple) {
                        $visible = true;
                    } else {
                        if (!$inGame->where('modifier_id', $mod->id)->count()) {
                            $visible = true;
                        }
                    }
                @endphp
                <button class="btn btn-primary"
                    @if(!$visible)
                        style="display:none;"
                    @endif

                    @if($mod->can_have_multiple)
                        data-can_have_multiple='1'
                    @else
                        data-can_have_multiple='0'
                    @endif
                type="button" data-id="{{$mod->id}}" onclick="addModifier(this)">{{$mod->name}}</button>
            @endforeach
        </div>
    </div>
    <hr>
    <div>
        <h3>Modifiers Selected (click to remove)</h3>
        <div class="modifiersInGame">
        @foreach($inGame as $mod)
            <button class="btn btn-primary"
                    data-modifier_id="{{$mod->modifier_id}}"
                    data-id="{{$mod->id}}" type="button"
                    onclick="removeModifier(this)">{{$mod->name}}</button>
        @endforeach
        </div>
    </div>
    <hr>
    <button id="submit" class="btn btn-block btn-success" type="button">Assign to Roles!</button>
</div>

<script>

    function addModifier(clickedButton) {
        let button = $(clickedButton);
        let modifier_id = button.attr('data-id');
        let name = $(button).text();
        let newId = 0;

        // ajax to add to game
        $.ajax({
            method: "POST",
            url: "/add_modifier/{{$id}}",
            data: {
                "_token": "{{ csrf_token() }}",
                modifier_id: modifier_id
            },
            success: function(data) {
                newId = data;
                // if not multiple, remove
                if (button.attr('data-can_have_multiple') == '0') {
                    button.hide();
                }

                // add to in game
                $('.modifiersInGame').append(`
                <button class='btn btn-primary' data-modifier_id="`+modifier_id+`" data-id="`+newId+`" type="button" onclick="removeModifier(this)">`+name+`</button>`
                );
            },
            error: function(data) {
                alert('Something went wrong :(');
            }
        })
    }

    function removeModifier(clickedButton)
    {
        let button = $(clickedButton);
        let id = button.attr('data-id'); // game_modifiers
        let modifier_id = button.attr('data-modifier_id'); // modifier

        $.ajax({
            method: "POST",
            url: "/remove_modifier/{{$id}}",
            data: {
                "_token": "{{ csrf_token() }}",
                id: id
            },
            success: function(data) {
                button.remove();
                $('.availableModifiers .btn[data-id="'+modifier_id+'"]').css('display', 'inline-block');
            },
            error: function(data) {
                alert('Something went wrong :(');
            }
        });
    }

    $('#submit').on('click', function() {
        if (confirm("Are you sure you're done?")) {
            window.location.href = '/apply_modifiers/{{$id}}';
        }
    })
</script>


@endsection