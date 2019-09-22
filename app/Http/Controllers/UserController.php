<?php

namespace App\Http\Controllers;

use Auth;
use \App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getListing()
    {
        $users = User::get([
            'id',
            'name',
            'can_approve',
            'approved'
        ]);

        $user  = Auth::User();

        return view('users.list', ['users' => $users, 'thisUser' => $user]);
    }

    public function updateUsers(Request $request)
    {
        $r = $request->all();
        unset($r['_token']);
        $usersToUpdate = [];
        foreach ($r as $field => $value) {
            $fieldUser = explode("-", $field);
            $usersToUpdate[$fieldUser[1]][$fieldUser[0]] = $value;
        }

        foreach ($usersToUpdate as $userId => $fields)
        {
            User::where('id', $userId)->update($fields);
        }
        return view('users.updated');
    }

    public function deleteUser(User $user)
    {   
        if (Auth::id() != 1) {
            abort(404);
        }
        $user->forceDelete();
        return redirect('users');
    }
}
