<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function sale()
    {
        return $this->hasMany(Sale::class);
    }

    public function newCode($category)
    {
        $lastCode = $this->select(DB::raw('MAX(RIGHT(code,4)) AS lastCode'))
            ->where('category', $category)
            ->get();

        $lastCode = $lastCode[0]->lastCode;
        if ($lastCode != null) {
            $kd = $lastCode + 1;
        } else {
            $kd = "0001";
        }

        $category_slug = Category::where('name', $category)->first();

        return $category_slug->slug . '' . \sprintf("%05s", $kd);
    }
}
