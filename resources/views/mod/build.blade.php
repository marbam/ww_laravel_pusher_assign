<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
        <script>
            var gameId = {!! json_encode($data['game_id']) !!}
        </script>

        <title>Bristol Werewolf</title>

    </head>
    <body>
    	<div id="app">
    		<player-list></player-list>
    	</div>

        <div class="roles">
            @include('mod.faction_lists.moon_heading', [
                'heading' => 'One Moon', 'data' => $data['factions']->where('moons', 1)
            ])
            @include('mod.faction_lists.moon_heading', [
                'heading' => 'Two Moons', 'data' => $data['factions']->where('moons', 2)
            ])
            @include('mod.faction_lists.moon_heading', [
                'heading' => 'Three Moon', 'data' => $data['factions']->where('moons', 3)
            ])
        </div>
    </body>

	<script src="/js/app.js"></script>
    <script>


        $( document ).ready(function() {

            $('.not-in').click( function () {
                $(this).toggleClass('btn-warning');
                $(this).toggleClass('btn-default');
                var id = $(this).data('show_players');
                if ($(this).hasClass('btn-warning')) {
                    $(this).text('Maybe In');
                    sendUpdate('add', id);
                } else {
                    $(this).text('Out');
                    $('#'+id).removeClass('btn-success').text('Out');
                    sendUpdate('remove', id, 'remove', id);
                }

            });

            $('.role').click(function() {
                $(this).toggleClass('role-out');
                $(this).toggleClass('btn-default');
                $(this).toggleClass('role-in');
                $(this).toggleClass('btn-success');

                var id = $(this).attr('id');
                if ($(this).hasClass('role-in')) {
                    $(this).text("In");
                    $("[data-show_players='"+id+"']").text('Maybe In').addClass('btn-warning');
                    sendUpdate('add', id, 'add', id);
                } else {
                    $(this).text("Out");
                    sendUpdate(null, null, 'remove', id);
                }

            });

        });

        $('#proceed_button').click(function() {
            if ($(this).data('players') == $(this).data('roles')) {
                if (confirm("Are you sure you're ready to close the game?")) {
                    window.location = "/close/{{$id}}";
                }
            } else {
                alert('players and roles do not match');
            }
        });


        function sendUpdate(announceState = null, announceId = null, roleState = null, roleId = null ) {
            $.ajax({
              method: "POST",
              url: "/mod_update/{{$id}}",
              data: {
                "_token": "{{ csrf_token() }}", 
                announceState: announceState, 
                announceId: announceId,
                roleState: roleState,
                roleId: roleId
                }
            })
            .done(function(data) {
                let button = $('#proceed_button');
                let count = button.data('roles');
                if (announceState == 'add') {
                    count = count + 1;
                } else {
                    count = count - 1;
                }
                button.data('roles', count);
            });
        }

    </script>

</html>