<div id="currentPosition" data-position_id="{{$position_id}}">
    @php
        $position = \App\Position::where('positions.id', $position_id)
                                 ->join('roles', 'positions.role_id', '=', 'roles.id')
                                 ->get([
                                    'positions.id',
                                    'name'
                                 ])->first();

        $modifiers = \App\GameModifier::where('game_id', $id)
                                      ->join('modifiers', 'game_modifiers.modifier_id', '=', 'modifiers.id')
                                      ->where('position_id', $position->id)
                                      ->get([
                                        'game_modifiers.id',
                                        'name'
                                      ]);
    @endphp
    <h3>{{$position->name}}</h3>
    <p>Selected Modifiers</p>
    <div class="roles_in">
        @foreach($modifiers as $mod)
            <button class="btn btn-primary" onclick="deallocate(this)" data-modifier_id="{{$mod->id}}">{{$mod->name}}</button>
        @endforeach
    </div>
</div>