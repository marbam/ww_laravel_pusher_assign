@extends('templates.master')

    @section('content')
    <div class="container">
        <div class="jumbotron text-center">
            <h1 class="jumbotron-heading">New Game!</h1>
            <p class="lead text-muted">Enter a code for your game in the box below. Try to keep it simple as your players will need to enter it to join the game! You cannot enter a code already in use!</p>
        </div>
        <form action="/setup_game" method="POST">
            {{csrf_field()}}
            <label for="code">Game code:</label>
            <input type="text" name="code"></input>
            <button class="btn btn-success my-2" type="submit">Create Game!</button>
        </form>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection