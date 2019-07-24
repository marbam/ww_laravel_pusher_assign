<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>Bristol Werewolf</title>
        <script>
            var gameId = {!! json_encode($game_id) !!}
        </script>
    </head>
    <body>
		waiting...
    	<div id="app">
			<faction-list></faction-list>
		</div>
		<script src="/js/app.js"></script>
    </body>

</html>