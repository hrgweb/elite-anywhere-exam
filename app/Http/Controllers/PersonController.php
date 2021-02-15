<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index()
    {
        return view('person.index');
    }

    public function store()
    {
        return User::create(request()->only([
            'name',
            'first_name',
            'last_name',
            'email'
        ]));
    }

    public function fetch()
    {
        return User::all();
    }

    public function update($id)
    {
        $data = request()->data;

        return User::where('id', $id)->update([
            'name' => $data['name'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
        ]);
    }

    public function destroy($id)
    {
        return User::where('id', $id)->delete();
    }

    public function organizations($id)
    {
        return User::find($id)->organizations()->get();
    }
}
