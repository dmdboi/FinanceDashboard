<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RulesController extends Controller
{
    //
    public function index()
    {
        return view('rules.index');
    }

    public function create()
    {
        return view('rules.create');
    }
}
