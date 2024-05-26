<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {

        return view('setting.warehouse.index', [
            'title' => 'Gudang (Cabang)',
            'warehouses' => Warehouse::all(),
        ]);
    }
}
