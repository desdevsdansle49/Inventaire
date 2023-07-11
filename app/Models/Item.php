<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public static function shearchResult($query)
    {
        return Item::where('Name', 'like', '%' . $query . '%')
            ->orWhere('Barcode', '=', $query);
    }
}
