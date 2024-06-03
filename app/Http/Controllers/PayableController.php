<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayableController extends Controller
{

    public function index()
    {
        return view('payable.index');
    }

    public function edit($id)
    {
        return view('journal.payable.edit', [
            'id' => $id,
            'title' => 'Edit Payable'
        ]);
    }
}
