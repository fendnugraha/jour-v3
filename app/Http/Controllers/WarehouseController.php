<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    public function index()
    {

        return view('setting.warehouse.index', [
            'title' => 'Gudang (Cabang)',
        ]);
    }

    public function edit($id)
    {
        $warehouse = Warehouse::find($id);
        $ChartOfAccount = ChartOfAccount::where('account_id', 1)->whereIn('warehouse_id', [0, $id])->get();
        return view(
            'setting.warehouse.edit',
            [
                'title' => 'Edit Gudang' . ' ' . $warehouse->name,
                'warehouse' => $warehouse,
                'chartOfAccounts' => $ChartOfAccount
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3|max:90|unique:warehouses,name,' . $id,
            'address' => 'required|max:160|min:3',
            'cashAccount' => 'required'
        ]);

        try {
            DB::beginTransaction();
            // Create and save the warehouse
            $warehouse = Warehouse::find($id);

            ChartOfAccount::where('id', $warehouse->chart_of_account_id)->update(['warehouse_id' => 0]);

            $warehouse->update([
                'name' => $request->name,
                'address' => $request->address,
                'chart_of_account_id' => $request->cashAccount
            ]);

            ChartOfAccount::where('id', $request->cashAccount)->update(['warehouse_id' => $warehouse->id]);

            DB::commit();

            return redirect('/setting/warehouse')->with('success', 'Gudang ' . $warehouse->name . ' Telah Diupdate');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('/setting/warehouse')->with('error', $e->getMessage());
        }
    }
}
