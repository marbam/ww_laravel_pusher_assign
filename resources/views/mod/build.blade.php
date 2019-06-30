<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <title>Bristol Werewolf</title>

    </head>
    <body>
    	<div id="app">
    		<player-list></player-list>
    	</div>

        <div class="roles">
            @include('mod.faction_lists.moon_heading', [
                'heading' => 'One Moon', 'data' => $data->where('moons', 1)
            ])
            @include('mod.faction_lists.moon_heading', [
                'heading' => 'Two Moons', 'data' => $data->where('moons', 2)
            ])
            @include('mod.faction_lists.moon_heading', [
                'heading' => 'Three Moon', 'data' => $data->where('moons', 3)
            ])
        </div>




    </body>






	<script src="/js/app.js"></script>

</html>