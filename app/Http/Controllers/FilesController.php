<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilesController extends Controller
{
    //
    public function index() {
        return view('files.index');
    }
}
