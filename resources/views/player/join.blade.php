@extends('templates.master')

@section('content')

    <div class="container">

        <div class="jumbotron text-center">
            <h1 class="jumbotron-heading">Joining a game</h1>
            <p class="lead text-muted">Welcome! Your mod will have given you a code for the game. Enter your name and the code to join the game!</p>
        </div>

        <form action="/join_game" method="POST">
            {{csrf_field()}}
            <label for="name">Your name:</label>
            <input type="text" name="name"></input>

            <label for="code">Game code:</label>
            <input type="text" name="code"></input>
            <button type="submit" class="btn btn-success my-2">Submit</button>
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