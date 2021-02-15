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
        return User::paginate(5);
    }
}