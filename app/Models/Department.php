<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public static function removeDepartment($departmentId)
    {
        Unit::where('department_id', $departmentId)->update(['department_id' => '1']);
        Department::where('id', $departmentId)->delete();
    }

    public static function searchResult($query)
    {
        return Department::where('name', 'like', '%' . $query . '%')->orderBy('name', 'ASC')->paginate(10);
    }

    public static function idFromName($department)
    {
        Department::where('name', '=', $department)->get('id')[0]->id;
    }
}
