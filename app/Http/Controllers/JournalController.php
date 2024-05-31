<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{

    public function index()
    {
        return view('journal.index', [
            'title' => 'Jurnal',
        ]);
    }

    public function dailyReport()
    {
        return view('report.index', [
            'title' => 'Daily Report',
        ]);
    }

    public function administrator()
    {
        return view('report.administrator', [
            'title' => 'Administrator',
        ]);
    }
}
