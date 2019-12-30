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
        <div class="container">
            <div class="jumbotron text-center">
                <h1 class="jumbotron-heading">Building Game</h1>
                <p class="lead text-muted">First section below is a real-time list of players joining the game. </p>
                <p class="lead text-muted">Second is the ability to add a technophobe/internetless player to the game.</p>
                <p class="lead text-muted">Third is the role list. Each role has two buttons next to it - Clicking the left one will announce the faction as a MAYBE IN to the players waiting, or remove it from their list. Clicking the right one will add it to your private game list. </p>
                <a href="/games" class="btn btn-success my-2">Back to Games List</a>
            </div>
            <hr>
            <div id="app">
                <player-list></player-list>
            </div>
            <hr>
            <div>
                <form action="/add_phoneless/{{$data['game_id']}}" method="POST">
                    <h3>Add player without phone</h3>
                    {{csrf_field()}}
                    <label for="name">Player name:</label>
                    <input type="text" name="name"></input>
                    <button type="submit" class="btn btn-success my-2">Add to game</button>
                </form>
            </div>
            <hr>
            <div>
                <h2>Roles in Game: <span id="role_count">{{$data['alreadyIn']}}</span></h2>
            </div>
            <hr>
            <div>
                <h2>Modifiers</h2>
                <label for="has_modifiers">Are you planning on putting modifiers into this game? (Separate Screen)</label for="has_modifiers">
                <select class="form-control" id="has_modifiers">
                    <option value="0">No</option>
                    <option value="1"
                    @if ($data["game"]->has_modifiers) selected @endif
                    >Yes</option>
                </select>
            </div>
            <hr>
            <div class="roles">
                @include('mod.faction_lists.moon_heading', [
                    'heading' => 'One Moon', 'data' => $data['factions']->where('moons', 1)
                ])
                <hr>
                @include('mod.faction_lists.moon_heading', [
                    'heading' => 'Two Moons', 'data' => $data['factions']->where('moons', 2)
                ])
                <hr>
                @include('mod.faction_lists.moon_heading', [
                    'heading' => 'Three Moon', 'data' => $data['factions']->where('moons', 3)
                ])
            </div>
        </div>
    </body>

	<script src="/js/app.js"></script>
    <script>


        $( document ).ready(function() {

            $('.not-in').click( function () { //faction which is not in
                $(this).toggleClass('btn-warning');
                $(this).toggleClass('btn-default');
                var role_id = $(this).data('show_players');
                if ($(this).hasClass('btn-warning')) {
                    $(this).text('Maybe In');
                    sendUpdate('add', role_id, null, null, false); // add faction
                } else {
                    $(this).text('Out');
                    var updateCount = false;
                    if ($('#'+role_id).hasClass('btn-success')) {
                        $('#'+role_id).removeClass('btn-success').text('Out');
                        updateCount = true;
                    }
                    sendUpdate('remove', role_id, 'remove', role_id, updateCount); // remove faction and role
                }

            });

            $('.role').click(function() {
                $(this).toggleClass('role-out');
                $(this).toggleClass('btn-default');
                $(this).toggleClass('role-in');
                $(this).toggleClass('btn-success');

                var role_id = $(this).attr('id');
                if ($(this).hasClass('role-in')) {
                    $(this).text("In");
                    $("[data-show_players='"+role_id+"']").text('Maybe In').addClass('btn-warning');
                    sendUpdate('add', role_id, 'add', role_id, true); // add faction and role
                } else {
                    $(this).text("Out");
                    sendUpdate(null, null, 'remove', role_id, true); // remove faction and role
                }
            });
        });

        $('#has_modifiers').on('change', function() {
            let has_modifiers = $(this).val();
            $.ajax({
              method: "POST",
              url: "/game_has_modifiers/{{$id}}",
              data: {
                "_token": "{{ csrf_token() }}",
                has_modifiers: has_modifiers
                }
            })
        })

        $('#proceed_button').click(function() {
            if ($(this).data('players') == $(this).data('roles')) {
                if (confirm("Are you sure you're ready to close the game?")) {
                    window.location = "/close/{{$id}}";
                }
            } else {
                alert('players and roles do not match');
            }
        });


        function sendUpdate(announceState = null, announceId = null, roleState = null, roleId = null, changeCount = false) {
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
                if (changeCount) {
                    let button = $('#proceed_button');
                    let count = button.data('roles');
                    if (announceState == 'add') {
                        count = count + 1;
                    } else {
                        count = count - 1;
                    }
                    button.data('roles', count);
                    $('#role_count').html(count);
                }
            });
        }

    </script>

</html>