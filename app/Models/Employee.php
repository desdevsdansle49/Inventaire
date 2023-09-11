<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public static function removeEmployee($employeeId)
    {
        Employee::where('id', $employeeId)->delete();
    }

    public static function editEmployee($employeeId, $selectForEmployee)
    {
        Employee::where('id', $employeeId)->update(['unit_id' => $selectForEmployee]);
    }

    public static function searchResult($query)
    {
        self::where('name', 'like', '%' . $query . '%')->orderBy('name', 'ASC')->paginate(10);
    }
}
