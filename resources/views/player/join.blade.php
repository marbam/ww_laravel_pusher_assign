@extends('templates.master')

@section('content')

    <form action="/join_game" method="POST">
    	{{csrf_field()}}
    	name<input type="text" name="name"></input>
        code<input type="text" name="code"></input>
    	<button type="submit">Submit</button>
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

@endsection