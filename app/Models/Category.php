<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public static function removeCategory($name)
    {
        $categoryId = Category::firstWhere('name', $name)->id;
        $newCategoryId = Category::firstWhere('name', '-')->id;
        Item::where('category_id', $categoryId)->update(['category_id' => $newCategoryId]);
        Category::where('Name', '=', $name)->delete();
    }

    public static function searchResult($query)
    {
        return Category::where('name', 'like', '%' . $query . '%')->orderBy('name', 'ASC')->paginate(10);
    }

    public static function idFromName($name)
    {
        return (Category::where('name', 'like', $name)->get('id'))[0]->id;
    }
}
