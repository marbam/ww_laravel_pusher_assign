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
        <div class="container">
            <div class="jumbotron text-center">
                <h1 class="jumbotron-heading">You're in the game!</h1>
                <p class="lead text-muted">Your moderator is building your game! Any non 1-moon roles will appear as they are added to the game. We'll give you your role when the game's ready!</p>
                <div class="progress" style="">
                  <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                </div>
            </div>
            <div id="app">
                <faction-list></faction-list>
            </div>
        </div>
		<script src="/js/app.js"></script>
    </body>

</html>