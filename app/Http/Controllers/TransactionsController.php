<?php

namespace App\Http\Controllers;

class TransactionsController extends Controller
{
    public function index()
    {
        return view('transactions.index');
    }
}
