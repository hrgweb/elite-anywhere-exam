<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index()
    {
        return view('organization.index');
    }

    public function store()
    {
        return Organization::create(request()->only([
            'name',
            'email'
        ]));
    }

    public function fetch()
    {
        return Organization::all();
    }

    public function update($id)
    {
        $data = request()->data;

        return Organization::where('id', $id)->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function destroy($id)
    {
        return Organization::where('id', $id)->delete();
    }

    public function persons($id)
    {
        return Organization::find($id)->persons()->get();
    }
}
