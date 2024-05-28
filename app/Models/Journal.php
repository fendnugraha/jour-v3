<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Journal extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function invoice_journal()
    {
        $lastInvoice = DB::table('journals')
            ->select(DB::raw('MAX(RIGHT(invoice,7)) AS kd_max'))
            ->where([
                ['user_id', Auth()->user()->id],
            ])
            ->whereDate('created_at', date('Y-m-d'))
            ->get();

        $kd = "";
        if ($lastInvoice[0]->kd_max != null) {
            $no = $lastInvoice[0]->kd_max;
            $kd = $no + 1;
        } else {
            $kd = "0000001";
        }
        return 'JR.BK.' . date('dmY') . '.' . Auth()->user()->id . '.' . \sprintf("%07s", $kd);
    }
}
