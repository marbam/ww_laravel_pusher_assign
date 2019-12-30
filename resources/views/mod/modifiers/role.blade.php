<div id="currentPosition" data-position_id="{{$id}}">
    @php
        $position = \App\Position::where('positions.id', $id)
                                 ->join('roles', 'positions.role_id', '=', 'roles.id')
                                 ->get([
                                    'positions.id',
                                    'name'
                                 ])->first();
    @endphp
    <h3>{{$position->name}}</h3>
    <p>Selected Modifiers</p>
    <div class="roles_in">

    </div>
</div>