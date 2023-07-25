<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public static function removeUnit($unitId)
    {
        Employee::where('unit_id', $unitId)->update(['unit_id' => '1']);
        Unit::where('id', $unitId)->delete();
    }

    public static function editUnit($unitId, $selectForUnit)
    {
        Unit::where('id', $unitId)->update(['department_id' => $selectForUnit]);
    }

    public static function searchResult($query)
    {
        return self::where('name', 'like', '%' . $query . '%')->orderBy('name', 'ASC')->paginate(10);
    }

    public static function idFromName($unit)
    {
        return Unit::where('name', '=', $unit)->get('id')[0]->id;
    }
}
