<?php

namespace App\Models;

use App\Models\ChartOfAccount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function ChartOfAccount()
    {
        return $this->belongsTo(ChartOfAccount::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function journal()
    {
        return $this->hasMany(Journal::class);
    }
}
