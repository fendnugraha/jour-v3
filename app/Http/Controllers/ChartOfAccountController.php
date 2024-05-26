<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use Illuminate\Http\Request;

class ChartOfAccountController extends Controller
{
    public function index()
    {

        return view(
            'setting.account.index',
            [
                'title' => 'Chart Of Account Page',
                'accounts' => ChartOfAccount::with('account')->get(),
            ]
        );
    }
}
